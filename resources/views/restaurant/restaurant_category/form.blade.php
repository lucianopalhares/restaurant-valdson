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
                            {{isset($item->id)?isset($show)?'Ver':'Editar':'Adicionar'}}
                            
                            Categoria neste Restaurante                        
                            </h4>
                        </div>
                        <div class="card-content">
                        
                            <form method="POST" action="{{ url('restaurante/'.$restaurant->slug.'/restaurante_categoria') }}" enctype="multipart/form-data">
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
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Categoria *</label>
                                            <select required="required" class="form-control" name="category_id">
                                              <option value=" ">Selecione</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}" {{ old('category_id') == $category->id ? "selected='selected'" : isset($item->category_id) && $item->category_id == $category->id ? "selected='selected'" : '' }}>
                                                      {{$category->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                  
                                <a href="{{ url('restaurante/'.$restaurant->slug.'/restaurante_categoria') }}" class="btn btn-danger"><i class="material-icons">reply</i> Voltar para Lista</a>

                                @if(isset($item->id))
                                <a href="{{url('restaurante/'.$restaurant->slug.'/restaurante_categoria/create')}}" class="btn btn-secondary"><i class="material-icons">reply</i> Cadastrar Novo(a)</a>
                                @endif
                                
                                @if(!isset($show))
                                <button type="submit" class="btn btn-success"><i class="material-icons">save</i> Salvar</button>
                                @else
                                <a href="{{url('restaurante/'.$restaurant->slug.'/restaurante_categoria/'.$item->id.'/edit')}}" class="btn btn-secondary">Editar</a>
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