@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                <img src="{{asset('assets/images/bg.png')}}" alt="Imagem Ilustrativa">
                <h5>Comece agora e organize as suas tarefas!</h5>
                @guest
                    <a href="{{route('login')}}" class="btn btn-primary">Entrar! <i class="fa-solid fa-circle-arrow-right"></i></a>
                @else
                    <a href="{{route('tarefa')}}" class="btn btn-primary">Começar! <i class="fa-solid fa-circle-arrow-right"></i></a>
                @endguest
            </div>
        </div>
    </div>
@endsection