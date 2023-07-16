<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\NoteRespuest;

class NoteController extends Controller
{
    public function index():View {
        $notes = Note::all();
        return View('note.index',compact('notes'));
    }

    public function create():View {
        return view('note.create');
    }

    public function store(NoteRespuest $request):RedirectResponse {

        // Note::create($request->all());
        $done = (bool)$request->input('done');
        Note::create([
            'title' => $request->title,
            'description' => $request->description,
            'done' => $done
            ]);

        // $note->save();

        return redirect()->route('note.index');
    }

    public function edit($id): View{
        $note = Note::findOrFail($id);
        
        return View('note.edit',compact('note'));

    }
    public function update(NoteRespuest $request, $id):RedirectResponse {
        $request->validate([
            'title'=>'required|max:255|min:3',
            'description'=>'required|max:255|min:3'
        ]);
        $note = Note::findOrFail($id);

        $done = (bool)$request->input('done');

        $note->title = $request->input('title');
        $note->description = $request->input('description');
        $note->done = $done;

        $note->save();
        // Note::create($request->all());
        return redirect()->route('note.index');
        
    }

    public function show($id):View  { 
        $note = Note::find($id);
        return view('note.show',compact('note'));
    }
    public function delete($id){
        $note = Note::findOrFail($id);
        $note->delete();
        return redirect()->route('note.index');
    }

}
