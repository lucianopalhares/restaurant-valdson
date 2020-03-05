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
                            
                            Categoria                        
                            </h4>
                        </div>
                        <div class="card-content">
                        
                            <form method="POST" action="{{ url('admin/categoria') }}" enctype="multipart/form-data">
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
                                            <label class="control-label">Nome *</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name',isset($item->name)?$item->name:' ') }}">
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
                                    <div class="col-md-8">
                                            <label class="control-label">Imagem *</label>
                                            <input type="file" name="image" value="Escolher Imagem" placeholder="Escolher Imagem">
                                        
                                    </div>
                                    <div class="col-md-4">
                                            <label class="control-label">Caminho Imagem *</label>
                                            public/uploads/category
                                    
                                    </div>
                                </div>
                                @if(isset($item->id))
                                <div class="row">
                                    <div class="col-md-12">
                                            <label class="control-label"></label>
                                            <img src="/uploads/category/{{$item->image}}" width="100px;" alt="" style="width:100px;">
                                    </div>
                                </div>   
                                @endif      
                                <a href="{{ url('admin/categoria') }}" class="btn btn-danger"><i class="material-icons">reply</i> Voltar para Lista</a>

                                @if(isset($item->id))
                                <a href="{{url('admin/categoria/create')}}" class="btn btn-secondary"><i class="material-icons">reply</i> Nova Categoria</a>
                                @endif
                                
                                @if(!isset($show))
                                <button type="submit" class="btn btn-success"><i class="material-icons">save</i> Salvar</button>
                                @else
                                <a href="{{url('admin/categoria/'.$item->id.'/edit')}}" class="btn btn-secondary">Editar</a>
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