@extends('layouts.partial.app')

@section('title')

@push('css')

@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('layouts.partial.msg')
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">
                            {{isset($item->id)?isset($show)?'Ver':'Editar':'Cadastrar'}}
                            
                            Restaurante                        
                            </h4>
                        </div>
                        <div class="card-content">
                        
                            <form method="POST" action="{{ route('restaurant.store') }}" enctype="multipart/form-data">
                              @csrf
                          
                                
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
                                              <option>UF</option>
                                                @foreach($ufs as $uf)
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
                                              <input {{isset($show)?"disabled='disabled'":''}} type="number" class="form-control" name="cnpj" value="{{ old('cnpj',isset($item->cnpj)?$item->cnpj:'') }}">
                                          </div>
                                      </div>
                                      <div class="col-md-3">
                                          <div class="form-group label-floating">
                                              <label class="control-label">Inscrição Estadual</label>
                                              <input {{isset($show)?"disabled='disabled'":''}} type="number" class="form-control" name="insc_est" value="{{ old('insc_est',isset($item->insc_est)?$item->insc_est:'') }}">
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
                                @if(!isset($show))
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label">Logo *</label>
                                        <input {{isset($item->id)&&strlen($item->logo)==0?"required='required'":''}} type="file" name="logo" value="Escolher Logo" placeholder="Escolher Logo">
                                    </div>
                                </div>
                                @endif
                                @if(isset($item->id))
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="control-label">Logo *</label>
                                        <img src="/frontend/images/{{$item->logo}}" width="100px;" alt="" style="width:100px;">
                                    </div>
                                </div>   
                                @endif                                  
                        
                                
                                @if(!isset($show))
                                <button type="submit" class="btn btn-success"><i class="material-icons">save</i> Salvar</button>
                                @else
                                <a href="{{url('admin/restaurant/'.$item->id.'/edit')}}" class="btn btn-secondary">Editar</a>
                                @endif
                                

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