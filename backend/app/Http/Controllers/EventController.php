<?php

namespace App\Http\Controllers;

use App\Models\{Event, Ticket, Feedback, Item, Comment};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image; 
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class EventController extends Controller
{  
    public function __construct()
    {
        $this->middleware('auth');
    }
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
            'location' => 'required',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $directoryPath = public_path('productions');

        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }

        if ($request->hasFile('image')) {
            $imgprod = $request->file('image');

            // Redimensionar a imagem 
            $image = Image::make($imgprod)->fit(854, 480);
            $image->save($directoryPath . '/' . $imgprod->getClientOriginalName());

            $imagePath = 'productions/' . $imgprod->getClientOriginalName();
        }

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
        // Busca o evento pelo ID
        $event = Event::find($id);
    
        // Verifica se o evento foi encontrado
        if (!$event) {
            // Evento não encontrado, redireciona ou mostra uma mensagem de erro
            return redirect()->route('events.index')->with('error', 'Evento não encontrado.');
        }
    
        // Verifica se o usuário está autenticado
        $user = Auth::user();
    
        $participated = Item::where('event_id', $id)
            ->where('user_id', $user->id)
            ->where('type', 'ingresso') // ou qualquer outro tipo relevante para o ingresso
            ->where('is_used', true)
            ->exists();
    
        // Busca os comentários do evento
        $comments = Comment::where('event_id', $id)->get();
    
        // Converte a data do evento para o formato desejado (caso necessário)
        $event->date = Carbon::parse($event->date);
    
        // Retorna a view com os dados do evento, se o usuário participou e os comentários
        return view('crud.events.show', compact('event', 'participated', 'comments'));
    }
    public function storeComment(Request $request, $eventId)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);
    
        // Verifica se o usuário está autenticado
        $user = Auth::user();
    
        // Cria o comentário no banco de dados associando-o ao evento e ao usuário autenticado
        $comment = Comment::create([
            'event_id' => $eventId,
            'user_id' => $user->id,
            'comment' => $request->input('comment'),
        ]);
    
        // Retorna o novo comentário em formato JSON
        return response()->json($comment);
    }
    
    public function getComments($eventId)
    {
        // Buscar o evento pelo ID
        $event = Event::findOrFail($eventId);
    
        // Carregar os comentários relacionados a esse evento
        $comments = $event->comments()->with('user')->orderBy('created_at', 'desc')->get();
    
        // Retornar os comentários em formato JSON
        return response()->json(['comments' => $comments]);
    }
    public function storeFeedback(Request $request, $eventId)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

        // Cria o feedback no banco de dados
        Feedback::create([
            'event_id' => $eventId,
            'user_id' => Auth::id(),
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('events.show', $eventId)->with('success', 'Avaliação enviada com sucesso!');
    }



    public function edit(Event $event)
    {
        
        $tickets = Ticket::where('event_id', $event->id)->get();
        return view('crud.events.update', compact('event', 'tickets'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $directoryPath = public_path('productions');

        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }

        if ($request->hasFile('image')) {
            $imgprod = $request->file('image');

            // Redimensionar a imagem 
            $image = Image::make($imgprod)->fit(854, 480);
            $image->save($directoryPath . '/' . $imgprod->getClientOriginalName());

            $imagePath = 'productions/' . $imgprod->getClientOriginalName();
        } else {
            // Caso a imagem não tenha sido enviada no request, manter a imagem atual do evento
            $imagePath = $event->image;
        }

        // Atualização do evento no banco de dados
        $event->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'date' => $request->input('date'),
            'time' => $request->input('time'),
            'location' => $request->input('location'),
            'price' => $request->input('price'),
            'image' => $imagePath,
        ]);

        // Redirecionamento para a página de exibição do evento atualizado
        return redirect()->route('events.show', $event->id)->with('success', 'Evento atualizado com sucesso!');
    }
    public function destroy(Event $event)
    {
        // Armazenar o ID do produtor antes de excluir o evento
        $producerId = $event->production_id;
    
        $event->delete();
    
        // Redirecionar para a página de detalhamento da produção
        return redirect()->route('productions.show', $producerId)->with('success', 'Evento excluído com sucesso!');
    }

    
}
