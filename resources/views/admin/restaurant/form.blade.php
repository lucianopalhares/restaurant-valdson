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
                            
                            Restaurante                        
                            </h4>
                        </div>
                        <div class="card-content">
                        
                          @if(isset($item))
                            {!! Form::open(['url' => 'admin/restaurante/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}
                          
                          @else 
                            {!! Form::open(['url' => 'admin/restaurante','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}
                          
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
                                    <div class="col-md-8">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nome *</label>
                                            <input {{isset($show)?"disabled='disabled'":''}} required="required" type="text" class="form-control" name="name" value="{{ old('name',isset($item->name)?$item->name:'') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Hoŕario Abertura *</label>
                                            <input {{isset($show)?"disabled='disabled'":''}} type="number" class="form-control" name="opening_hours_start" value="{{ old('opening_hours_start',isset($item->opening_hours_start)?$item->opening_hours_start:'') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Hoŕario Fechamento *</label>
                                            <input {{isset($show)?"disabled='disabled'":''}} type="number" class="form-control" name="opening_hours_end" value="{{ old('opening_hours_end',isset($item->opening_hours_end)?$item->opening_hours_end:'') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Endereço *</label>
                                            <input {{isset($show)?"disabled='disabled'":''}} type="text" class="form-control" name="address" value="{{ old('address',isset($item->address)?$item->address:'') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nº </label>
                                            <input {{isset($show)?"disabled='disabled'":''}} type="text" class="form-control" name="number" value="{{ old('number',isset($item->number)?$item->number:'') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Bairro * </label>
                                            <input {{isset($show)?"disabled='disabled'":''}} required="required" type="text" class="form-control" name="district" value="{{ old('district',isset($item->district)?$item->district:'') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Cidade * </label>
                                            <input {{isset($show)?"disabled='disabled'":''}} required="required" type="text" class="form-control" name="city" value="{{ old('city',isset($item->city)?$item->city:'') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
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
                                    <div class="col-md-2">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Telefone Fixo</label>
                                            <input {{isset($show)?"disabled='disabled'":''}} type="number" class="form-control" name="phone" value="{{ old('phone',isset($item->phone)?$item->phone:'') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Celular *</label>
                                            <input {{isset($show)?"disabled='disabled'":''}} type="number" class="form-control" name="mobile" value="{{ old('mobile',isset($item->mobile)?$item->mobile:'') }}">
                                        </div>
                                    </div>
                                      <div class="col-md-2">
                                          <div class="form-group label-floating">
                                              <label class="control-label">WhatsApp</label>
                                              <input {{isset($show)?"disabled='disabled'":''}} type="number" class="form-control" name="whatsapp" value="{{ old('whatsapp',isset($item->whatsapp)?$item->whatsapp:'') }}">
                                          </div>
                                      </div>
                                      <div class="col-md-3">
                                          <div class="form-group label-floating">
                                              <label class="control-label">CNPJ</label>
                                              <input required="required" {{isset($show)?"disabled='disabled'":''}} type="number" class="form-control" name="cnpj" value="{{ old('cnpj',isset($item->cnpj)?$item->cnpj:'') }}">
                                          </div>
                                      </div>
                                      <div class="col-md-3">
                                          <div class="form-group label-floating">
                                              <label class="control-label">Inscrição Estadual</label>
                                              <input required="required" {{isset($show)?"disabled='disabled'":''}} type="number" class="form-control" name="insc_est" value="{{ old('insc_est',isset($item->insc_est)?$item->insc_est:'') }}">
                                          </div>
                                      </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Sobre Nós</label>
                                            <textarea rows="6" {{isset($show)?"disabled='disabled'":''}} class="form-control" name="about_us">{{ old('about_us',isset($item->about_us)?$item->about_us:'') }}</textarea>
                                          
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Taxa</label>
                                            <input {{isset($show)?"disabled='disabled'":''}} type="number" class="form-control" name="tax" value="{{ old('tax',isset($item->tax)?$item->tax:'') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Valor Minimo </label>
                                            <input {{isset($show)?"disabled='disabled'":''}} type="number" class="form-control" name="value_min" value="{{ old('value_min',isset($item->value_min)?$item->value_min:'') }}">
                                        </div>
                                    </div>
                                      <div class="col-md-3">
                                          <div class="form-group label-floating">
                                              <label class="control-label">Tempo de Entrega</label>
                                              <input {{isset($show)?"disabled='disabled'":''}} type="text" class="form-control" name="delivery_time" value="{{ old('delivery_time',isset($item->delivery_time)?$item->delivery_time:'') }}">
                                          </div>
                                      </div>
                                      <div class="col-md-4">
                                          <div class="form-group label-floating">
                                              <label class="control-label">Forma de Pagamento</label>
                                              <select {{isset($show)?"disabled='disabled'":''}} class="form-control" name="payment_way_id">
                                                <option value=" ">Selecione</option>
                                                  @foreach($payment_ways as $payment_way)                                               
                                                      <option value="{{$payment_way->id}}" {{ old('payment_way_id') == $payment_way->id ? "selected='selected'" : isset($item->payment_way_id) && $item->payment_way_id == $payment_way->id ? "selected='selected'" : '' }}>
                                                        {{$payment_way->name}}
                                                      </option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Info</label>
                                            <textarea rows="2" {{isset($show)?"disabled='disabled'":''}} class="form-control" name="info">{{ old('info',isset($item->info)?$item->info:'') }}</textarea>
                                          
                                        </div>
                                    </div>
                                </div>
                                
                                @if(!isset($show))
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label">Logo *</label>
                                        <input {{isset($item->id)&&strlen($item->logo)==0?"required='required'":''}} type="file" name="logo" value="Escolher Logo" placeholder="Escolher Logo">
                                    </div>

                                    <div class="col-md-6">
                                            <label class="control-label">Caminho Logo *</label>
                                            public/frontend/images/restaurants

                                    </div>
                                </div>  
                                @endif
                                @if(isset($item->id))
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label">Logo *</label>
                                        <img src="/frontend/images/restaurants/{{$item->logo}}" width="100px;" alt="" style="width:100px;">
                                    </div>  
                                    <div class="col-md-6">
                                            <label class="control-label">Caminho Logo *</label>
                                            public/frontend/images/restaurants/{{$item->logo}}

                                    </div>
                                </div>     
                                @endif                                  
                   
                                
                                <a href="{{url('admin/restaurante')}}" class="btn btn-danger"><i class="material-icons">reply</i> Voltar para Lista</a>

                                @if(isset($item->id))
                                <a href="{{url('admin/restaurante/create')}}" class="btn btn-secondary"><i class="material-icons">reply</i> Cadastrar Novo(a)</a>
                                @endif
                                
                                @if(!isset($show))
                                <button type="submit" class="btn btn-success"><i class="material-icons">save</i> Salvar</button>
                                @else
                                <a href="{{url('admin/restaurante/'.$item->id.'/edit')}}" class="btn btn-secondary">Editar</a>
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