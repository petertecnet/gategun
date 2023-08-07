<?php

namespace App\Http\Controllers;

use App\Models\{Production, Event, Item};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
class ProductionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
public function index()
{
    // Obtém o usuário logado
    $user = Auth::user();

    // Obtém as produções associadas ao usuário logado
    $productions = $user->production;

    return view('crud.productions.index', compact('productions'));
}

    public function create()
    {
        return view('productions.create');
    }
    // ...
    
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'location' => 'required|string|max:255',
        'address' => 'required|string|max:255',
    ]);

    $user = Auth::user();
    $directoryPath = public_path('productions');

    if (!File::exists($directoryPath)) {
        File::makeDirectory($directoryPath, 0755, true);
    }

    $imagePath = null;

    if ($request->hasFile('image')) {
        $imgprod = $request->file('image');

        // Generate a unique name for the image using the timestamp
        $imageName = $user->name . '-' . Str::slug($request->name) . '-' . time() . '.' . $imgprod->getClientOriginalExtension();

        // Resize the image before saving
        $image = Image::make($imgprod)->fit(125, 125);
        $image->save($directoryPath . '/' . $imageName);

        $imagePath = 'productions/' . $imageName;
    }

    $production = new Production([
        'name' => $request->name,
        'type' => $request->type,
        'description' => $request->description,
        'image' => $imagePath,
        'location' => $request->location,
        'address' => $request->address,
        'capacity' => $request->capacity,
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
            'location' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);
    
        // Verifica se foi enviada uma nova imagem
        if ($request->hasFile('image')) {
            $imgprod = $request->file('image');
    
            // Define o diretório para salvar a imagem
            $directoryPath = public_path('productions');
    
            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0755, true);
            }
            
            $user = Auth::user();
            $imageName = $user->name . '-' . Str::slug($request->name) . '-updated-' . time() . '.' . $imgprod->getClientOriginalExtension();
    
            // Redimensionar a nova imagem antes de salvar
            $image = Image::make($imgprod)->fit(125, 125);
            $image->save($directoryPath . '/' . $imageName);
    
            // Remove a imagem antiga, se existir
            if ($production->image) {
                File::delete($directoryPath . '/' . $production->image);
            }
    
            // Atualiza o caminho da imagem com o novo nome
            $production->image = 'productions/' . $imageName;
        }
    
        $production->name = $request->name;
        $production->type = $request->type;
        $production->description = $request->description;
        $production->location = $request->location;
        $production->address = $request->address;
        $production->capacity = $request->capacity;
        $production->save();
    
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
