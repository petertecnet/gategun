<?php

namespace App\Http\Controllers;

use App\Models\{Production, Event, Item};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class ProductionController extends Controller
{
    
public function index()
{
    // Obtém o usuário logado
    $user = Auth::user();

    // Obtém as produções associadas ao usuário logado
    $productions = $user->productions;

    return view('crud.productions.index', compact('productions'));
}

    public function create()
    {
        return view('productions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'location' => 'required|string|max:255',
        ]);

        $user = Auth::user();$imagePath = $request->image;

        $directoryPath = public_path('production/events');

        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }

        if ($request->hasFile('image')) {
            $imgprod = $request->file('image');

            // Redimensionar a imagem 
            $image = Image::make($imgprod)->fit(125, 125);
            $image->save($directoryPath . '/' . $imgprod->getClientOriginalName());

            $imagePath = 'productions/events' . $imgprod->getClientOriginalName();
        }
        $production = new Production([
            'name' => $request->name,
            'image' => $imagePath,
            'location' => $request->location,
            'user_id' => $user->id,
            'user_name' => $user->name,
        ]);

        $production->save();
        return redirect()->route('productions.index')->with('status', 'Produção cadastrada com sucesso!');
    }

    public function show(Production $production)
    {
        // Obter os eventos associados à produção
        $events = Event::where('production_id', $production->id)->get();
        return view('crud.productions.show', compact('production', 'events'));
    }

    public function edit(Production $production)
    {
        return view('crud.productions.update', compact('production'));
    }

    public function update(Request $request, Production $production)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $production->image;
       
        $directoryPath = public_path('productions/events');

        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }

        if ($request->hasFile('image')) {
            $imgprod = $request->file('image');

            // Redimensionar a imagem 
            $image = Image::make($imgprod)->fit(125, 125);
            $image->save($directoryPath . '/' . $imgprod->getClientOriginalName());

            $imagePath = 'productions/events/' . $imgprod->getClientOriginalName();
        } else {
            // Caso a imagem não tenha sido enviada no request, manter a imagem atual do evento
            $imagePath = $production->image;
        }
        $production->update([
            'name' => $request->name,
            'image' => $imagePath,
            'location' => $request->location,
        ]);

        return redirect()->route('productions.show', $production->id)->with('success', 'Produção atualizada com sucesso!');
    }

    public function destroy(Production $production)
    {
        $production->delete();
        return redirect()->route('productions.index')->with('success', 'Produção excluída com sucesso!');
    }

    public function registerEntry($id)
{
    // Recupera o ingresso com o ID fornecido do banco de dados
    $ticket = Item::findOrFail($id);

    // Verifica se o ingresso já foi utilizado pelo participante
    $isUsed = $ticket->is_used;

    // Se o ingresso ainda não tiver sido utilizado, mostra a tela de confirmação para o produtor
    if (!$isUsed) {
        return view('crud.tickets.confirmEntry', compact('ticket'));
    }

    // Caso contrário, redireciona de volta para a página de detalhes do ingresso
    return redirect()->route('tickets.myOne', $id);
}

// Função para confirmar o registro de entrada
public function confirmEntry(Request $request)
{
    $ticketId = $request->input('ticket_id');

    // Recupera o ingresso com o ID fornecido do banco de dados
    $ticket = Item::findOrFail($ticketId);

    // Marca o ingresso como usado
    $ticket->update(['is_used' => true]);

    // Redireciona de volta para a página de detalhes do ingresso
    return redirect()->route('tickets.myOne', $ticketId);
}

public function scanQRCode()
{
    return view('crud.tickets.scanQRCode');
}
}
