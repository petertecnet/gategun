<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class ProductionController extends Controller
{
    public function index()
    {
        $productions = Production::all();
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
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $image = Image::make(storage_path('app/' . $imagePath));
            $image->fit(350, 350);
            $image->save();
            $imagePath = 'storage/' . str_replace('public/', '', $imagePath);
        }
    
        $production = new Production([
            'name' => $request->name,
            'image' => $imagePath,
            'location' => $request->location,
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
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
        return view('productions.edit', compact('production'));
    }

    public function update(Request $request, Production $production)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'location' => 'required|string|max:255',
        ]);

        $imageUrl = $production->image_url;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $image = Image::make(storage_path('app/' . $imagePath));
            $image->fit(350, 350);
            $image->save();
            $imageUrl = asset('storage/' . str_replace('public/', '', $imagePath));
        }

        $production->update([
            'name' => $request->name,
            'image_url' => $imageUrl,
            'location' => $request->location,
        ]);

        return redirect()->route('productions.index')->with('success', 'Produção atualizada com sucesso!');
    }

    public function destroy(Production $production)
    {
        $production->delete();
        return redirect()->route('productions.index')->with('success', 'Produção excluída com sucesso!');
    }
}
