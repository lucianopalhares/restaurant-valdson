@extends('layouts.partial.app')

@section('title','Slider')

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
                            
                            Slider                             
                            </h4>
                        </div>
                        <div class="card-content">
                            <form method="POST" action="{{ route('slider.store') }}" enctype="multipart/form-data">
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
                                            <label class="control-label">Titulo *</label>
                                            <input required="required" type="text" class="form-control" name="title" value="{{ old('title',isset($item->title)?$item->title:'') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Sub-Titulo *</label>
                                            <input required="required" type="text" class="form-control" name="sub_title" value="{{ old('sub_title',isset($item->sub_title)?$item->sub_title:'') }}">
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
                                            <img src="/uploads/slider/{{$item->image}}" width="100px;" alt="" style="width:100px;">
                                    </div>
                                </div>   
                                @endif 
                                <a href="{{ route('slider.index') }}" class="btn btn-danger">Voltar para Lista</a>
                                <button type="submit" class="btn btn-primary">Salvar</button>
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