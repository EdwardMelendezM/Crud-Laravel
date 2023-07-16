@extends('layout.layout')
@section('title','Todo')

@section('content')
  
  <form method="POST" action="{{route('note.delete',$note->id)}}">
    @csrf
    @method('DELETE')
    <h3>{{$note->title}}</h3>
    <h3>{{$note->description}}</h3>
    <h3>{{$note->done}}</h3>

    <input type="submit" value="DELETE">
  </form>

@endsection