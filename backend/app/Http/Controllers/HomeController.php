<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Obter todos os eventos do banco de dados
        $events = Event::all();
    
        foreach ($events as $event) {
            $event->date = Carbon::parse($event->date);
        }
    
        // Obtém o valor da variável de ambiente 'ENDPOINT_URL'
        $endpoint = env('ENDPOINT_URL');
    
        // Cria uma coleção para armazenar as datas dos próximos eventos
        $upcomingDates = new Collection();
    
        // Adiciona as datas dos próximos eventos à coleção
        foreach ($events as $event) {
            if ($event->date->isFuture()) {
                $upcomingDates->push($event->date);
            }
        }
    
        // Ordena as datas em ordem crescente
        $upcomingDates = $upcomingDates->sortBy('timestamp');
    
        // Passa os eventos, a variável de ambiente e as datas dos próximos eventos para a view 'home'
        return view('home', compact('events', 'endpoint', 'upcomingDates'));
    }
    
}
