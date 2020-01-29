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
                            
                            Cardápio                        
                            </h4>
                        </div>
                        <div class="card-content">
                        
                            <form method="POST" action="{{ route('item.store') }}" enctype="multipart/form-data">
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
                                              <option>Selecione</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}" {{ old('category_id') == $category->id ? "selected='selected'" : isset($item->category_id) && $item->category_id == $category->id ? "selected='selected'" : '' }}>
                                                      {{$category->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nome *</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name',isset($item->name)?$item->name:'') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Tipo de Embalagem *</label>
                                            <select required="required" class="form-control" name="type">
                                              <option>Selecione</option>
                                              <option value="Unidade" {{ old('type') == "Unidade" ? "selected='selected'" : isset($item->type) && $item->type == "Unidade" ? "selected='selected'" : '' }}>Unidade</option>
                                              <option value="Lata" {{ old('type') == "Lata" ? "selected='selected'" : isset($item->type) && $item->type == "Lata" ? "selected='selected'" : '' }}>Lata</option>
                                              <option value="Porção" {{ old('type') == "Porção" ? "selected='selected'" : isset($item->type) && $item->type == "Porção" ? "selected='selected'" : '' }}>Porção</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Descrição</label>
                                            <textarea class="form-control" name="description">{{ old('description',isset($item->description)?$item->description:' ') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Preço *</label>
                                            <input type="number" class="form-control" name="price" value="{{ old('price',isset($item->price)?$item->price:'') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                            <label class="control-label">Imagem *</label>
                                            <input type="file" name="image" value="Escolher Imagem" placeholder="Escolher Imagem">
                                    </div>
                                </div>
                                @if(isset($item->id))
                                <div class="row">
                                    <div class="col-md-12">
                                            <label class="control-label"></label>
                                            <img src="/uploads/item/{{$item->image}}" width="100px;" alt="" style="width:100px;">
                                    </div>
                                </div>   
                                @endif 
                                  
                                <a href="{{ route('item.index') }}" class="btn btn-danger"><i class="material-icons">reply</i> Voltar para Lista</a>

                                @if(isset($item->id))
                                <a href="{{url('admin/item/create')}}" class="btn btn-secondary"><i class="material-icons">reply</i> Cadastrar Novo(a)</a>
                                @endif
                                
                                @if(!isset($show))
                                <button type="submit" class="btn btn-success"><i class="material-icons">save</i> Salvar</button>
                                @else
                                <a href="{{url('admin/item/'.$item->id.'/edit')}}" class="btn btn-secondary">Editar</a>
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