# Crud en laravel

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## En el back end:
Routes
- Get, Post, Put, Delete
```
Route:get('/note',[NoteController::class,'index'])->name('note.index')
Route:post('/note/create',[NoteController::class,'create'])->name('note.create')
Route:put('/note/edit/{id}',[NoteController::class,'edit'])->name('note.edit')
Route:delete('/note/destroy/{id}',[NoteController::class,'destroy'])->name('note.destroy')
```
- Resources para reemplazar un crud
```
Route::resource('/note',NoteController::class);
Route::resource('/post',PostController::class);
```

Consultas con el orm a la bd
```
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
```

- Recuperar
```
  $notes = Note::all();
```

- Crear
```
  // Note::create($request->all());
  // $note->save();

  $done = (bool)$request->input('done');
  Note::create([
      'title' => $request->title,
      'description' => $request->description,
      'done' => $done
      ]);

  

  return redirect()->route('note.index');
```

- Actualizar
```
  $note = Note::findOrFail($id);
  $done = (bool)$request->input('done');

  $note->title = $request->input('title');
  $note->description = $request->input('description');
  $note->done = $done;

  $note->save();
```

- Eliminar
```
  $note = Note::findOrFail($id);
  $note->delete();
```

Request
- Para validar los datos pasados por el formulario
```

public function rules()
    {
        return [
             'title'=>'required|max:255|min:3',
            'description'=>'required|max:255|min:3'
        ];
    }
```




## En el front end:
- Uso de directivas como ejemplo
- @Extends para el layout
- @Section para reemplazar parametros
- @forelse para recorrer listas
- {{ route( 'note.show' , $note -> id) }} para enviar el id a una determinada ruta
```
@extends('layout.layout')

@section('title','Get all')

@section('content')
  <a href="/note/create">Create new</a>

  @forelse ($notes as $note)
    <div>
      <li>
        <a
          href="{{route('note.show',$note->id)}}"
          >
          {{$note->title}}
        </a>
      </li>
      <p>{{$note->description}}</p>
      <div>
        <a href="{{route('note.edit',$note->id)}}">
        Edit</a>
      </div>
      <div>
        <a  href="{{route('note.show',$note->id)}}">
        Delete</a>
      </div>
    </div>
  @empty
    <p>Not found data</p>
  @endforelse

@endsection
```

- @if para verificar los error y si existen mostrarlos en pantalla
- @csrf para asegurar el envio del formulario
- @error para mostrar errores si existen por variable
```
@if($errors->any())
<ul>
  @foreach ($errors->all() as $error)
    <li>{{$error}}</li>
  @endforeach
@endif
</ul>
  <form method="POST" action="{{route('note.store')}}">
    <h3>Complete the fields</h3>

    {{-- Esto es para dar seguridad y es obligatorio --}}
    @csrf

    @error('title')
    <br>
    <p style="color:red"" >Titulo not valid, {{$message}} </p>
    @enderror

    @error('description')
    <br>
    <p style="color:red" >Description not valid, {{$message}} </p>
    @enderror
    <input
      type="text"
      name="title"
      placeholder="Add title"
      class="@error('title') danger  @enderror"
    >
    <input type="text" name="description" placeholder="Add description">
    <input type="checkbox" name="done">

    <div class="">
      <input type="submit" value="Submit">
    </div>
  </form>
@endsection
```


- @method('PUT') para enviar los datos con ese metodo
- @csrf para asegurar el envio del formulario
```
<form method="POST" action="{{route('note.update',$note->id)}}">
  @method('PUT')
  @csrf
  <input type="text" name="title" value="{{$note->title}}">
  <input type="text" name="description" value="{{$note->description}}">
  <input type="checkbox" name="done" value="{{$note->done}}">

  <input type="submit" value="Submit">
</form>
```