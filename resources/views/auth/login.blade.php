@extends('layouts.logged.app')

@section('title','Login')

@push('css')

@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-md-offset-1">
                    @include('layouts.logged.msg')
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">Entrar</h4>
                        </div>
                        <div class="card-content">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Email</label>
                                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Senha</label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Entrar</button>
                                <a href="{{url('/cadastro-cliente')}}" class="btn btn-xs btn-secondary">Não é Cadastrado? Cadastre-se como Cliente</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush