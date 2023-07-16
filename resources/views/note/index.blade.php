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