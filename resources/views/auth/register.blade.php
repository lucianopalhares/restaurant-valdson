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
                            <h4 class="title">Cadastro de Cliente</h4>
                        </div>
                        <div class="card-content">
                            <form method="POST" action="{{ url('salvar-cliente') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nome *</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Celular *</label>
                                            <input type="number" class="form-control" name="mobile" value="{{ old('mobile') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Endereço *</label>
                                            <input type="text" class="form-control" name="address" value="{{ old('address') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Bairro *</label>
                                            <input type="text" class="form-control" name="district" value="{{ old('district') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Cidade *</label>
                                            <input type="text" class="form-control" name="city" value="{{ old('city') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Estado *</label>
                                            <select required="required" class="form-control" name="state">
                                              <option value=" ">UF</option>
                                                @foreach(states() as $uf)
                                                    <option value="{{$uf['code']}}" {{ old('state') == $uf['code'] ? "selected='selected'" : '' }}>
                                                      {{$uf['code']}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Email</label>
                                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Senha</label>
                                            <input type="password" class="form-control" name="password" value="{{ old('password') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Repetir Senha</label>
                                            <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Salvar</button>
                                <a href="{{url('/login')}}" class="btn btn-xs btn-secondary">Voltar e Entrar</a>
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