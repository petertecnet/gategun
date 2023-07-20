<?php



namespace App\Http\Controllers;
use App\Models\Ticket;
use Intervention\Image\Facades\Image; 

use Illuminate\Http\Request;

class TicketController extends Controller
{
    // Mostrar a lista de tickets
    public function index()
    {
        $tickets = Ticket::all();
        return view('tickets.index', compact('tickets'));
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
        $ticket = Ticket::findOrFail($id);
        return view('tickets.show', compact('ticket'));
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
}
