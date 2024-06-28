@extends('layouts.app')

@section('content')
    <user :auth="{{ Auth::user() }}"></user>
@endsection