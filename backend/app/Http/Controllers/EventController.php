<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image; 
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        // Upload da imagem do evento
        $imagePath = $request->file('image')->store('event_images', 'public');
    
        // Redimensionamento da imagem para 900x600
        $image = Image::make(storage_path("app/public/{$imagePath}"));
        $image->fit(900, 600);
        $image->save();
    
        // Criação do evento no banco de dados
        $event = Event::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'date' => $request->input('date'),
            'time' => $request->input('time'),
            'location' => $request->input('location'),
            'price' => $request->input('price'),
            'image' => $imagePath,
            'production_id'=> $request->input('production_id'),
            'production_name'=> $request->input('production_name'),
        ]);
    
        // Redirecionamento para a página de exibição do evento recém-criado
        return redirect()->route('events.show', $event->id);
    }
    public function show($id)
    {
        $event = Event::findOrFail($id);
        $tickets = Ticket::where('event_id', $event->id)->get();
        
        return view('crud.events.show', compact('event', 'tickets'));
    }
    

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'production_id' => 'required|exists:producers,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'required|numeric|min:0',
            'url_img' => 'nullable|url',
        ]);

        $event->update($request->all());

        return redirect()->route('events.index')->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(Event $event)
    {
        // Armazenar o ID do produtor antes de excluir o evento
        $producerId = $event->producer_id;
    
        $event->delete();
    
        // Redirecionar para a página de detalhamento da produção
        return redirect()->route('productions.show', $producerId)->with('success', 'Evento excluído com sucesso!');
    }
}
