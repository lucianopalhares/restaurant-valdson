@extends('layouts.logged.app')

@section('title')

@push('css')

@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('layouts.logged.msg')
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">
                            {{isset($item->id)?isset($show)?'Ver':'Editar':'Cadastrar'}}
                            
                            Cliente                        
                            </h4>
                        </div>
                        <div class="card-content">
                        
      
                          @if(isset($item))
                            {!! Form::open(['url' => 'admin/cliente/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}
                          
                          @else 
                            {!! Form::open(['url' => 'admin/cliente','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}
                          
                          @endif 
                                
                                @if(isset($item->id))
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">ID *</label>
                                            <input disabled="disabled" type="text" class="form-control" value="{{ $item->id }}">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="{{$item->id}}" name="id" />
                                @endif
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nome *</label>
                                            <input {{isset($show)?"disabled='disabled'":''}} required="required" type="text" class="form-control" name="name" value="{{ old('name',isset($item->name)?$item->name:'') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Celular *</label>
                                            <input {{isset($show)?"disabled='disabled'":''}} type="number" class="form-control" name="mobile" value="{{ old('mobile',isset($item->mobile)?$item->mobile:'') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Endereço *</label>
                                            <input {{isset($show)?"disabled='disabled'":''}} type="text" class="form-control" name="address" value="{{ old('address',isset($item->address)?$item->address:'') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                                  
                                    <div class="col-md-5">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Bairro * </label>
                                            <input {{isset($show)?"disabled='disabled'":''}} required="required" type="text" class="form-control" name="district" value="{{ old('district',isset($item->district)?$item->district:'') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Cidade * </label>
                                            <input {{isset($show)?"disabled='disabled'":''}} required="required" type="text" class="form-control" name="city" value="{{ old('city',isset($item->city)?$item->city:'') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">UF *</label>
                                            <select {{isset($show)?"disabled='disabled'":''}} required="required" class="form-control" name="state">
                                              <option value=" ">UF</option>
                                                @foreach(states() as $uf)
                                                    <option value="{{$uf['code']}}" {{ old('state') == $uf['code'] ? "selected='selected'" : isset($item->state) && $item->state == $uf['code'] ? "selected='selected'" : '' }}>
                                                      {{$uf['code']}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Email *</label>
                                            <input {{isset($show)?"disabled='disabled'":''}} required="required" type="email" class="form-control" name="email" value="{{ old('email',isset($item->email)?$item->email:'') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Senha *</label>
                                            <input {{isset($show)?"disabled='disabled'":''}} {{isset($item)?'':"required='required'"}} type="password" class="form-control" name="password" value="{{ old('password') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Repetir Senha *</label>
                                            <input {{isset($show)?"disabled='disabled'":''}} {{isset($item)?'':"required='required'"}} type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">
                                        </div>
                                    </div>
                                </div>                        
                                
                                
                                <a href="{{url('admin/cliente')}}" class="btn btn-danger"><i class="material-icons">reply</i> Voltar para Lista</a>

                                @if(isset($item->id))
                                <a href="{{url('admin/cliente/create')}}" class="btn btn-secondary"><i class="material-icons">reply</i> Cadastrar Novo(a)</a>
                                @endif
                                
                                @if(!isset($show))
                                <button type="submit" class="btn btn-success"><i class="material-icons">save</i> Salvar</button>
                                @else
                                <a href="{{url('admin/cliente/'.$item->id.'/edit')}}" class="btn btn-secondary">Editar</a>
                                @endif
                                
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush