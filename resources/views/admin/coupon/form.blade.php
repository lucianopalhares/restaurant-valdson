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
                            
                            Cupom de Desconto                     
                            </h4>
                        </div>
                        <div class="card-content">
      
                          @if(isset($item))
                            {!! Form::open(['url' => 'admin/cupom/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}
                          
                          @else 
                            {!! Form::open(['url' => 'admin/cupom','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}
                          
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
                                            <label class="control-label">Valor do Cupom *</label>
                                            <input type="text" class="form-control" name="value" value="{{ old('value',isset($item->value)?$item->value:'') }}">
                                        </div>
                                    </div>
                                    @if(isset($item->id))
                                      <div class="col-md-6">
                                          <div class="form-group label-floating">
                                              <label class="control-label">Codigo *</label>
                                              <input type="text" disabled="disabled" class="form-control" value="{{ isset($item->code)?$item->code:'' }}">
                                          </div>
                                      </div>  
                                    @endif
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

                      
                                  
                                <a href="{{ url('admin/cupom') }}" class="btn btn-danger"><i class="material-icons">reply</i> Voltar para Lista</a>

                                @if(isset($item->id))
                                <a href="{{url('admin/cupom/create')}}" class="btn btn-secondary"><i class="material-icons">reply</i> Cadastrar Novo(a)</a>
                                @endif
                                
                                @if(!isset($show))
                                <button type="submit" class="btn btn-success"><i class="material-icons">save</i> Salvar</button>
                                @else
                                <a href="{{url('admin/cupom/'.$item->id.'/edit')}}" class="btn btn-secondary">Editar</a>
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