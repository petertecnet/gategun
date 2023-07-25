<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

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
    
        $user = Auth::user();
        $avatar = $request->file('image');
        $fileName = $user->id . '-' . $user->cpf . '-avatar.' . $avatar->getClientOriginalExtension();
        $directoryName = $user->id . '-' . $user->cpf;
    
        $directoryPath = public_path('avatars/' . $directoryName);
    
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }
    
        // Check if there's a file with the same name as the uploaded file
        if (File::exists($directoryPath . '/' . $avatar->getClientOriginalName())) {
            // Generate a new unique file name by adding a number to the end of the original file name
            $count = 1;
            $newFileName = pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME) . '_' . $count . '.' . $avatar->getClientOriginalExtension();
    
            while (File::exists($directoryPath . '/' . $newFileName)) {
                $count++;
                $newFileName = pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME) . '_' . $count . '.' . $avatar->getClientOriginalExtension();
            }
    
            // Rename the existing file with the new unique name
            File::move($directoryPath . '/' . $avatar->getClientOriginalName(), $directoryPath . '/' . $newFileName);
        } else {
            // If the file does not exist, simply move the uploaded file to the avatars directory
            $avatar->move($directoryPath, $avatar->getClientOriginalName());
        }
    
        $imagePath = 'avatars/' . $directoryName . '/' . $fileName;
    
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
            'location' => 'required|string|max:255',
        ]);
    
        $imagePath = $production->image;
        $directoryPath = public_path('logos');
    
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }
    
        if ($request->hasFile('image')) {
            $logo = $request->file('image');
    
            // Check if there's a file with the same name as the uploaded file
            if (File::exists($directoryPath . '/' . $logo->getClientOriginalName())) {
                // Generate a new unique file name by adding a number to the end of the original file name
                $count = 1;
                $newFileName = pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME) . '_' . $count . '.' . $logo->getClientOriginalExtension();
    
                while (File::exists($directoryPath . '/' . $newFileName)) {
                    $count++;
                    $newFileName = pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME) . '_' . $count . '.' . $logo->getClientOriginalExtension();
                }
    
                // Rename the existing file with the new unique name
                File::move($directoryPath . '/' . $logo->getClientOriginalName(), $directoryPath . '/' . $newFileName);
    
                $imagePath = 'logos/' . $newFileName;
            } else {
                // If the file does not exist, simply move the uploaded file to the logos directory
                $logo->move($directoryPath, $logo->getClientOriginalName());
                $imagePath = 'logos/' . $logo->getClientOriginalName();
            }
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
}
