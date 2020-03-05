@extends('layouts.partial.app')

@section('title')

@push('css')

@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">{{ $item->subject }}</h4>
                        </div>
                        <div class="card-content">
                           <div class="row">
                               <div class="col-md-12">
                                   <strong>Nome: {{ $item->name }}</strong><br>
                                   <b>Email: {{ $item->email }}</b> <br>
                                   <strong>Messagem: </strong><hr>

                                   <p>{{ $item->message }}</p><hr>

                               </div>
                           </div>
                            <a href="{{ route('contact.index') }}" class="btn btn-danger">Voltar para Lista</a>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush