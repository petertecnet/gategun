<?php



namespace App\Http\Controllers;
use App\Models\Ticket;
use Intervention\Image\Facades\Image; 
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Renderer\Image\RendererInterface;
use BaconQrCode\Renderer\Image\Svg;
use BaconQrCode\Renderer\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TicketController extends Controller
{
    // Mostrar a lista de tickets
    public function index()
    {
        $tickets = Ticket::all();
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
    $ticket =  Ticket::where('event_id', $id)->first();
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

    $data = [
        'items' => [
            [
                'amount' =>  $request->input('totalvalue'),
                'description' => 'Ingresso do evento tal',
                'quantity' => 1,
            ]
        ],
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

        // Retornar apenas o campo "status"
        return response()->json(['status' => $status]);

    } catch (\GuzzleHttp\Exception\RequestException $e) {
        // Tratamento de exceção caso ocorra um erro na requisição
        return false;
    }
}

    
}
