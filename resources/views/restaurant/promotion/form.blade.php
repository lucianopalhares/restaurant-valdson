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
                            
                            Promoção de Cardápio                        
                            </h4>
                        </div>
                        <div class="card-content">
      
                          @if(isset($item))
                            {!! Form::open(['url' => 'restaurante/'.$restaurant->slug.'/promocao/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}
                          
                          @else 
                            {!! Form::open(['url' => 'restaurante/'.$restaurant->slug.'/promocao','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}
                          
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
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Item do Cardápio *</label>
                                            <select required="required" class="form-control" name="item_id">
                                              <option value=" ">Selecione</option>
                                                @foreach($menus as $menu)
                                                    <option value="{{$menu->id}}" {{ old('item_id') == $menu->id ? "selected='selected'" : isset($item->item_id) && $item->item_id == $menu->id ? "selected='selected'" : '' }}>
                                                      {{$menu->name}} <small><i>(preço normal: R$ {{$menu->price}})</i></small>
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Data Inicio *</label>
                                            <input type="text" class="form-control" name="start" value="{{ old('start',isset($item->start)?date("d/m/Y", strtotime($item->start)):'') }}" placeholder="99/99/9999">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Data Fim *</label>
                                            <input type="text" class="form-control" name="end" value="{{ old('end',isset($item->end)?date("d/m/Y", strtotime($item->end)):'') }}" placeholder="99/99/9999">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Valor da Promoção *</label>
                                            <input type="text" class="form-control" name="price" value="{{ old('price',isset($item->price)?$item->price:'') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Status * <i>(válida apenas a última promoção ativa de cada item do cardápio)</i></label>
                                            <select class="form-control" name="active">
                                              <option value="1" {{ old('active') == "1" ? "selected='selected'" : isset($item->active) && $item->active == "1" ? "selected='selected'" : '' }}>Ativo</option>
                                              <option value="0" {{ old('active') == "0" ? "selected='selected'" : isset($item->active) && $item->active == "0" ? "selected='selected'" : '' }}>Não Ativo</option>
                                            </select>
                                        </div>
                                    </div>  
                                </div>
                      
                                  
                                <a href="{{ url('restaurante/'.$restaurant->slug.'/promocao') }}" class="btn btn-danger"><i class="material-icons">reply</i> Voltar para Lista</a>

                                @if(isset($item->id))
                                <a href="{{url('restaurante/'.$restaurant->slug.'/promocao/create')}}" class="btn btn-secondary"><i class="material-icons">reply</i> Cadastrar Novo(a)</a>
                                @endif
                                
                                @if(!isset($show))
                                <button type="submit" class="btn btn-success"><i class="material-icons">save</i> Salvar</button>
                                @else
                                <a href="{{url('restaurante/'.$restaurant->slug.'/promocao/'.$item->id.'/edit')}}" class="btn btn-secondary">Editar</a>
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