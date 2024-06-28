@extends('layouts.app')

@section('content')
    <tarefa :auth="{{ Auth::user() }}"></tarefa>
@endsection