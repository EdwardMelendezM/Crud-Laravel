@extends('layout.layout')

@section('title','Edit')

@section('content')

<form method="POST" action="{{route('note.update',$note->id)}}">
  @method('PUT')
  @csrf
  <input type="text" name="title" value="{{$note->title}}">
  <input type="text" name="description" value="{{$note->description}}">
  <input type="checkbox" name="done" value="{{$note->done}}">

  <input type="submit" value="Submit">
</form>

@endsection