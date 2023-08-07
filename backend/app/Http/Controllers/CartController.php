<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Cart, Item};
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // Obtém o usuário autenticado
        $user = Auth::user();

        // Obtém o carrinho de compras do usuário autenticado que não foi pago
        $cart = Cart::where('user_id', $user->id)
            ->where('is_paid', 0)
            ->first();

        // Se o carrinho não existe, cria um novo carrinho para o usuário
        if (!$cart) {
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->is_paid = 0;
            $cart->items = [];
            $cart->save();
        }

        // Obtém os itens do carrinho atualizado
        $items = $cart->items;

        // Retorna a lista de itens do carrinho em formato JSON
        return response()->json(['items' => $items]);
    }

    public function store(Request $request)
    {
        // Obtém o carrinho de compras do usuário autenticado
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)
        ->where('is_paid', 0)
        ->first();
    
        // Verifica se o carrinho de compras existe, caso não exista, cria um novo
        if (!$cart) {
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->items = [];
            $cart->is_paid = 0;
        }
    
    
        // Obtém o array de items do carrinho
        $items = $cart->items ?? [];
    
        // Verifica se os campos de preço e quantidade também estão presentes e não são nulos
        if ($request->has('item_price') && $request->has('item_quantity')) {
            // Obtém os arrays enviados no formulário
            $itemNames = $request->item_name;
            $itemPrices = $request->item_price;
            $itemtQuantities = $request->item_quantity;
            $itemIds = $request->ticket_id;
            $itemTypes = $request->item_type;
            $itemDescriptions = $request->event_name;
            $itemEventIds = $request->item_event_id;
    
            // Loop para adicionar cada item ao carrinho
            for ($i = 0; $i < count($itemNames); $i++) {
                $newItem = [
                    'id' => $itemIds[$i],
                    'itemtype' => $itemTypes[$i],
                    'event' => $itemDescriptions[$i],
                    'name' => $itemNames[$i],
                    'price' => $itemPrices[$i],
                    'quantity' => $itemtQuantities[$i],
                    'eventId' => $itemEventIds[$i],
                ];
    
                // Verifica se o item já existe no carrinho
                $itemExists = false;
                foreach ($items as $key => $item) {
                    if (
                        $item['name'] === $newItem['name']
                        && $item['itemtype'] === $newItem['itemtype']
                        && $item['id'] === $newItem['id']
                    ) {
                        // Se o item já existe, soma a quantidade do item existente com o novo item
                        $items[$key]['quantity'] += $newItem['quantity'];
                        $itemExists = true;
                        break;
                    }
                }
    
                // Se o item não existe no carrinho, adiciona-o
                if (!$itemExists) {
                    $items[] = $newItem;
                }
            }
        } else {
            // Se os campos de preço e quantidade não estiverem presentes, adiciona um item vazio ao carrinho
           
        return redirect()->back()->with('danger', 'Itens não foram  adicionados ao carrinho.');
        }
    
        // Salvar o array de items atualizado no atributo "items" do carrinho
        $cart->items = $items;
    
        // Salvar o carrinho no banco de dados
        $cart->save();
    
        return redirect()->back()->with('success', 'Itens adicionados ao carrinho com sucesso.');
    }
    

    public function update(Request $request, $itemId)
    {
         // Verifica se o usuário está autenticado
         if (Auth::check()) {
            // Obtém o carrinho do usuário autenticado
            $user = Auth::user();
            $cart = Cart::where('user_id', $user->id)  ->where('is_paid', 0)->first();

            // Verifica se o carrinho existe e possui itens
            if ($cart && count($cart->items) > 0) {
                // Cria um novo array para armazenar os itens atualizados
                $updatedItems = [];

                // Percorre os itens do carrinho
                foreach ($cart->items as $item) {
                    // Verifica se o item corresponde ao que está sendo atualizado
                    if ($item['id'] === $itemId) {
                        $quantity = intval($request->input('quantity'));

                        // Verifica se a quantidade é válida (maior que zero)
                        if ($quantity > 0) {
                            // Atualiza a quantidade do item
                            $item['quantity'] = $quantity;
                            $updatedItems[] = $item;
                        } else {
                            // Caso a quantidade seja zero ou negativa, não adiciona o item atualizado ao novo array (ou seja, remove o item do carrinho)
                        }
                    } else {
                        // Adiciona os outros itens ao novo array sem modificá-los
                        $updatedItems[] = $item;
                    }
                }

                // Atribui o novo array ao atributo $cart->items
                $cart->items = $updatedItems;
                $cart->save();
            }
        }

        // Redireciona de volta para a página do carrinho
        return redirect()->route('cart.viewCart')->with('success', 'Item atualizado no carrinho com sucesso.');
    
    }

    public function destroy($id)
    {
        // Obtém o carrinho de compras do usuário autenticado
        $user = Auth::user();
        $cart = $user->cart;

        // Verifica se o carrinho de compras existe
        if (!$cart) {
            return redirect()->back()->with('error', 'Carrinho de compras não encontrado.');
        }

        // Verifica se o item com o ID fornecido existe no carrinho
        if (!isset($cart->items[$id])) {
            return redirect()->back()->with('error', 'Item não encontrado no carrinho.');
        }

        // Remove o item do carrinho
        unset($cart->items[$id]);
        $cart->save();

        return redirect()->back()->with('success', 'Item removido do carrinho com sucesso.');
    }

 
    public function addItemToCart(Request $request)
    {
        
    
        $user = Auth::user();
        $cart = Cart::where('user_id', '1')->where('is_paid', 0)->first();
    
        // Verifica se o carrinho de compras existe, caso não exista, cria um novo
        if (!$cart) {
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->items = [];
            $cart->is_paid = 0;
        }
    
        // Obtém o array de items do carrinho
        $items = $cart->items ?? [];
    
        // Cria um novo item a ser adicionado ao carrinho
        $newItem = [
            'id' => $request->input('item_id'),
            'name' => $request->input('item_name'),
            'price' => $request->input('item_price'),
            'quantity' => $request->input('item_quantity'),
            'type' => $request->input('item_type'),
            'description' => $request->input('item_description'),
            'eventId' => $request->input('item_event_id'),
        ];
    
        // Verifica se o item já existe no carrinho
        $itemExists = false;
        foreach ($items as $key => $item) {
            if ($item['name'] === $newItem['name'] && $item['type'] === $newItem['type'] && $item['id'] === $newItem['id']) {
                // Se o item já existe, soma a quantidade do item existente com o novo item
                $items[$key]['quantity'] += $newItem['quantity'];
                $itemExists = true;
                break;
            }
        }
    
        // Se o item não existe no carrinho, adiciona-o
        if (!$itemExists) {
            $items[] = $newItem;
        }
    
        // Salvar o array de items atualizado no atributo "items" do carrinho
        $cart->items = $items;
    
        // Salvar o carrinho no banco de dados
        $cart->save();
    
        // Retornar uma resposta em formato JSON
        return response()->json([
            'message' => 'Item adicionado ao carrinho com sucesso!',
            'item' => $cart,
        ]);
    }

public function checkout()
{
    // Verifica se o usuário está autenticado
    if (Auth::check()) {
        // Obtém o carrinho do usuário autenticado
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)  ->where('is_paid', 0)->first();

        // Verifica se o carrinho existe e não está vazio
        if ($cart && !empty($cart->items)) {
            // Realize o processamento do checkout aqui (exemplo: criar uma ordem de compra, registrar o pagamento, etc.)

            // Após o checkout, você pode definir o carrinho como pago e limpar os itens do carrinho, se desejar:
            $cart->is_paid = 1;
            $cart->items = [];
            $cart->save();

            // Redirecione o usuário para a página de sucesso de checkout ou qualquer outra página relevante
            return redirect()->route('checkout.success')->with('success', 'Compra realizada com sucesso!');
        } else {
            return redirect()->route('cart')->with('warning', 'O carrinho está vazio. Adicione itens ao carrinho antes de fazer o checkout.');
        }
    } else {
        // Se o usuário não estiver autenticado, redirecione-o para a página de login ou qualquer outra página relevante
        return redirect()->route('login')->with('warning', 'Você precisa fazer login antes de fazer o checkout.');
    }
}


public function viewCart()
{
    // Verifica se o usuário está autenticado
    if (Auth::check()) {
        // Obtém o carrinho do usuário autenticado
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)
        ->where('is_paid', 0)
        ->first();

        // Verifica se o carrinho existe
        if ($cart) {
            // Exiba a página de visualização do carrinho com os itens
            return view('crud.cart.index', compact('cart'));
        } else {
            return redirect()->route('home')->with('warning', 'Carrinho não encontrado.');
        }
    } else {
        // Se o usuário não estiver autenticado, redirecione-o para a página de login ou qualquer outra página relevante
        return redirect()->route('login')->with('warning', 'Você precisa fazer login para ver o carrinho.');
    }
}

public function generateQRCode()
    {
        // Verifica se o usuário está autenticado
        if (Auth::check()) {
            // Obtém o carrinho do usuário autenticado
            $user = Auth::user();  
            $cart = Cart::where('user_id', $user->id)
            ->where('is_paid', 0)
            ->first();
            $now = Carbon::now();

            // Verifica se o carrinho existe e possui itens
            if ($cart && count($cart->items) > 0) {
                // Monta os dados para a requisição da API do Pagar.me
                $items = [];

                foreach ($cart->items as $item) {
                    $items[] = [
                        'description' => $cart['id']." -".$item['type']." - ".$item['name']." - ".$item['id']." - ".$item['id'],
                        'amount' => $item['price'],
                        'quantity' => $item['quantity'],
                    ];
                }
             
                $data = [
                    'items' => $items,
                    'customer' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'type' => 'individual',
                        'document' => '02292465167', // Substitua pelo documento do cliente, se disponível
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
                                        'name' => $cart->id,
                                        'value' => '1',
                                    ]
                                ]
                            ]
                        ]
                    ]
                ];

                try {
                    // Faz a requisição para a API do Pagar.me para obter os dados do QR code
                   
                     $client = new \GuzzleHttp\Client();

                    $response = $client->request('POST', 'https://api.pagar.me/core/v5/orders', [
                        'json' => $data,
                        'headers' => [
                            'Authorization' => 'Basic c2tfcnBScUcwNkgySG9MQk1ZeDo=', 
                            'Accept' => 'application/json',
                        ],
                    ]);

                    $responseData = json_decode($response->getBody()->getContents(), true);
                    $qrCodeUrl = $responseData['charges'][0]['last_transaction']['qr_code_url'];
                    $qrCode = $responseData['charges'][0]['last_transaction']['qr_code'];
                    $idorder = $responseData['id'];
                    $cart->idorder = $idorder;
                    $cart->save();

                    // Retorna a view com o QR code
                    return view('crud.tickets.qrcode', compact('qrCodeUrl', 'qrCode', 'idorder'));
                } catch (\Exception $e) {
                    // Trate o erro aqui, caso ocorra
                    return redirect()->back()->with('error', 'Erro ao gerar o QR code. Tente novamente mais tarde.');
                }
            } else {
                return redirect()->route('home')->with('warning', 'Carrinho vazio ou não encontrado.');
            }
        } else {
            // Se o usuário não estiver autenticado, redirecione-o para a página de login ou qualquer outra página relevante
            return redirect()->route('login')->with('warning', 'Você precisa fazer login para gerar o QR code.');
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
        ->where('is_paid', 0)
            ->first();

        // Verifica se o carrinho foi encontrado
        if ($cart) {
            if ($status === 'paid') {
                // Define o carrinho como pago
                $cart->is_paid = 1;
                $cart->save();

                // Itera pelos itens do carrinho e salva-os individualmente na tabela "items"
                $cartItems = $cart->items;

                foreach ($cartItems as $item) {
                    // Cria múltiplas instâncias de Item, uma para cada item comprado
                    for ($i = 0; $i < $item['quantity']; $i++) {
                        $newItem = new Item([
                            'name' => $item['name'],
                            'quantity' => 1, // Cada item é registrado individualmente com quantidade 1
                            'eventid' => $item['eventId'],
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
            // Retornar apenas o campo "status"
            return response()->json(['status' => $status]);
        } else {
            // Retornar mensagem de erro caso o carrinho não tenha sido encontrado
            return response()->json(['status' => $status]);
        }

    } catch (\GuzzleHttp\Exception\RequestException $e) {
        // Tratamento de exceção caso ocorra um erro na requisição
        return response()->json(['error' => 'Erro ao verificar o status do pagamento'], 500);
    }
}
}