<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

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
    
        // Passa os eventos e a variável de ambiente para a view 'home'
        return view('home', compact('events', 'endpoint'));
    }
    
}
