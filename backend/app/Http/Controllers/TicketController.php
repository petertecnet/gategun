<?php



namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Cart, Item};
class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // Mostrar a lista de tickets
    public function index()
    {
        // Obtém o usuário autenticado
        $user = auth()->user();
    
        // Obtém todos os carrinhos pagos do usuário
        $carts = Cart::where('user_id', $user->id)
            ->where('is_paid', 1)
            ->get();
    
        // Inicializa um array para armazenar os ingressos e suas quantidades
        $ticketQuantities = [];
    
        // Itera pelos carrinhos e extrai os ingressos do campo items
        foreach ($carts as $cart) {
            $items = $cart->items;
    
            // Itera pelos itens e verifica se o campo "type" é igual a "Ingresso"
            foreach ($items as $item) {
                if ($item['type'] === 'Ingresso') {
                    // Verifica se já existe um ticket para o mesmo ID
                    if (isset($ticketQuantities[$item['id']])) {
                        // Se existir, soma a quantidade atual à quantidade existente
                        $ticketQuantities[$item['id']]['quantity'] += $item['quantity'];
                    } else {
                        // Se não existir, cria um novo ticket com o ID, nome do ingresso e a quantidade atual
                        $ticketQuantities[$item['id']] = [
                            'id' => $item['id'],
                            'name' => $item['name'], // Nome do ingresso
                            'quantity' => $item['quantity'],// Nome do ingresso
                            'event_id' => $item['eventId'],
                        ];
                    }
                }
            }
        }
    
        // Agora temos o array $ticketQuantities com os IDs dos ingressos, seus nomes e suas quantidades somadas
    
        // Inicializa um array para armazenar os tickets finais
        $tickets = [];
    
        // Itera pelo array de quantidades para criar os tickets
        foreach ($ticketQuantities as $ticket) {
            // Verifica se a quantidade é maior que zero
            if ($ticket['quantity'] > 0) {
                // Adiciona o ticket ao array de tickets
                $tickets[] = $ticket;
            }
        }
    
        // Agora, você tem o array $tickets com os ingressos individuais, seus nomes e suas quantidades somadas corretamente
    
        return view('crud.tickets.index', compact('tickets'));
    }
    

    // Mostrar o formulário de criação de ticket
    public function create()
    {
        return view('tickets.create');
    }

    // Armazenar um novo ticket no banco de dados
    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'ticket_type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            // Outros campos do ticket
        ]);


        $ticket = Ticket::create($data);
        
        return redirect()->route('events.show', $ticket->event_id);  }

    // Mostrar os detalhes de um ticket específico
    public function show($id)
    {
       
    $tickets = Ticket::where('event_id', $id)->get();
        return view('crud.tickets.show', compact('tickets'));
    }

    // Mostrar o formulário de edição de ticket
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('tickets.edit', compact('ticket'));
    }

    // Atualizar os dados de um ticket no banco de dados
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            // Outros campos do ticket
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->update($data);

        return redirect()->route('tickets.index')->with('success', 'Ticket atualizado com sucesso!');
    }

    // Excluir um ticket do banco de dados
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket excluído com sucesso!');
    }

  
  
public function payment(Request $request)
{
    $totalValue = $request->input('totalvalue');
    $totalValue =  $totalValue * 1; 

    $user = Auth::user();
    $ticketsData = $request->input('tickets');

    // Verifique se existem ingressos selecionados
    if (!$ticketsData) {
        return redirect()->back()->with('error', 'Nenhum ingresso selecionado.');
    }
    $ticketsArray = json_decode($ticketsData, true);
    // Inicialize variáveis para o valor total e os itens do pedido
    $totalValue = 0;
    $items = [];
    // Calcule o valor total e crie os itens do pedido com base nos ingressos selecionados
    foreach ($ticketsArray  as $ticket) {
        $name = $ticket['name'];
        $quantity = $ticket['quantity'];
        $price = $ticket['price'];
        $itemTotal = $quantity * $price;

        $totalValue += $itemTotal;

        // Crie um array para representar cada item do pedido
        $items[] = [
            'name' => $name,
            'quantity' => $quantity,
            'price' => $price,
            'item_total' => $itemTotal,
        ];
    }

    $data = [
        'items' => $items,
        'customer' => [
            'name' => $user->name,
            'email' => $user->email,
            'type' => 'individual',
            'document' => '02292465167',
            'phones' => [
                'home_phone' => [
                    'country_code' => '55',
                    'number' => '22180513',
                    'area_code' => '21',
                ]
            ]
        ],
        'payments' => [
            [
                'payment_method' => 'pix',
                'pix' => [
                    'expires_in' => '600',
                    'additional_information' => [
                        [
                            'name' => 'Quantidade',
                            'value' => '1',
                        ]
                    ]
                ]
            ]
        ]
    ];

    try {
        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://api.pagar.me/core/v5/orders', [
            'json' => $data,
            'headers' => [
                'Authorization' => 'Basic c2tfcnBScUcwNkgySG9MQk1ZeDo=', // Substitua pela sua chave de autorização do Pagar.me
                'Accept' => 'application/json',
            ],
        ]);

        $responseData = json_decode($response->getBody()->getContents(), true);
        $qrCodeUrl = $responseData['charges'][0]['last_transaction']['qr_code_url'];
        $qrCode = $responseData['charges'][0]['last_transaction']['qr_code'];
        $idorder = $responseData['id'];

        // Retorna a view com o QR code
        return view('crud.tickets.qrcode', compact('qrCodeUrl', 'qrCode', 'idorder'));
    } catch (\Exception $e) {
        // Tratamento de exceção caso ocorra um erro na requisição
        return view('erro');
    }
}

public function checkPaymentStatus(Request $request)
{
    $orderId = $request->route('idorder');

    $client = new \GuzzleHttp\Client();

    try {
        $response = $client->request('GET', "https://api.pagar.me/core/v5/orders/{$orderId}", [
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic c2tfcnBScUcwNkgySG9MQk1ZeDo=',
            ],
        ]);

        $responseData = json_decode($response->getBody()->getContents(), true);
        $status = $responseData['status'];

        // Obtém o carrinho do usuário autenticado
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)
        ->where('is_paid', 0)
        ->where('idorder', $orderId)
            ->first();

        if ($status === 'paid') {
            // Define o carrinho como pago
            $cart->is_paid = 1;
            $cart->save();

            // Itera pelos itens do carrinho e salva-os na tabela "items"
            $cartItems = json_decode($cart->items, true);
            foreach ($cartItems as $item) {
                if ($item['type'] === 'Ingresso') {
                    // Cria múltiplas instâncias de Item, uma para cada ingresso comprado
                    for ($i = 0; $i < $item['quantity']; $i++) {
                        $newItem = new Item([
                            'name' => $item['name'],
                            'quantity' => 1, // Cada ingresso é registrado individualmente com quantidade 1
                            'event_id' => $item['event_id'],
                            'type' => $item['type'],
                            'description' => $item['description'],
                            'cart_id' => $cart->id,
                            'is_used' => false, // Por padrão, o item não foi utilizado
                            'user_id' => $user->id,
                        ]);

                        // Salva o novo item na tabela "items"
                        $newItem->save();
                    }
                }
            }

            // Redirect to the tickets page after the payment is confirmed
            return redirect()->route('tickets.index')->with('success', 'Pagamento realizado com sucesso!');

        } else {
            // Retornar apenas o campo "status"
            return response()->json(['status' => $status]);
        }
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        // Tratamento de exceção caso ocorra um erro na requisição
        return false;
    }
}

public function myOne($id)
{
    // Recupera o ingresso com o ID fornecido do banco de dados
    $ticket = Item::findOrFail($id);
    

    if (!$ticket) {
        return view('erro');
    }
$production = 
    // Verifica se o ingresso já foi utilizado pelo participante
    $isUsed = $ticket->is_used;

    // Obter o nome da produção associada ao evento do ingresso
    $productionName = $ticket->event->production_name;

    // Criar o conteúdo do QR code como uma string JSON
    $qrCodeContent = 'http://pgtrip.com.br/tickets/detail/'.$id;

    // URL da API do Google Chart para gerar o QR code
    $apiUrl = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" . urlencode($qrCodeContent);

    // Renderizar a view "myOne.blade.php" e passar os dados do ingresso, nome da produção e a URL do QR code como parâmetros
    return view('crud.tickets.myOne', compact('ticket', 'isUsed', 'productionName', 'apiUrl'));
}

public function detail($id)
    {
        // Recupera o ingresso com o ID fornecido do banco de dados
        $ticket = Item::findOrFail($id);

        // Verificar se o usuário autenticado é o Produtor do evento correspondente ao ingresso
        if (Auth::user()->id === $ticket->event->production->user_id) {
            // Obter o usuário associado ao item pelo user_id
            $user = $ticket->user;

            // Renderizar a view de detalhamento do ingresso e passar os dados do ingresso e do usuário como parâmetros
            return view('crud.tickets.ticket_detail', compact('ticket', 'user'));
        } else {
            // Caso o usuário autenticado não seja o Produtor do evento correspondente ao ingresso, redirecionar para uma página de erro ou mensagem
            return view('crud.tickets.unauthorized');
        }
    }

    public function captureTicket($id)
    {
        // Recupera o ingresso com o ID fornecido do banco de dados
        $ticket = Item::findOrFail($id);

        // Marca o ingresso como usado
        $ticket->update(['is_used' => true]);

        // Redireciona de volta para a página de detalhes do ingresso
        return redirect()->route('tickets.detail', ['id' => $ticket->id])->with('success', 'Ingresso validado e participante liberado!');
    }
    public function checkValidation($id)
{
    try {
        // Recupera o ingresso com o ID fornecido do banco de dados
        $ticket = Item::findOrFail($id);

        // Verifica se o ingresso já foi utilizado pelo participante
        $isUsed = $ticket->is_used;

        // Verifica se o ingresso pertence ao usuário autenticado (produtor)
        if ($ticket->user_id !== Auth::id()) {
            return response()->json(['error' => 'Acesso não autorizado.'], 403);
        }

        // Retorna o status de validação do ingresso
        return response()->json(['validated' => $isUsed]);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Erro ao verificar o status de validação do ingresso.'], 500);
    }
    
}
}