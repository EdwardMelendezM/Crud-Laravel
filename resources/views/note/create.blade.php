@extends('layout.layout');

@section('title','Crear nuevo todo')

@section('content')

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