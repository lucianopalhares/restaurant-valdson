@extends('layouts.logged.app')

@section('title','Dashboard')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
              @include('layouts.logged.msg')
              
              @if(\Auth::user()->hasAnyRoles('Cliente'))
                <div class="col-lg-3 col-md-6 col-sm-6">
                  
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="orange">
                            <i class="material-icons">open_in_browser</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Restaurantes</p>
                            <h3 class="title">
                            </h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons text-danger">info</i>
                                <a href="{{url('admin/restaurante')}}">Todos Restaurantes</a>
                            </div>
                        </div>
                    </div>
                </div>
            
                @endif
                <!--
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="green">
                            <i class="material-icons">slideshow</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Sliders</p>
                            <h3 class="title"></h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">date_range</i> <a href="">Get More Details...</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="red">
                            <i class="material-icons">info_outline</i>
                        </div>
                        <div class="card-content">
                            <p class="category">Reservas</p>
                            <h3 class="title"></h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">local_offer</i> Reservas sem Confirmar
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="blue">
                            <i class="fa fa-twitter"></i>
                        </div>
                        <div class="card-content">
                            <p class="category">Contatos</p>
                            <h3 class="title">t</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">update</i> Acabado de Atualizar
                            </div>
                        </div>
                    </div>
                </div>
              -->
            </div>
  
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                  "language": {
                  "lengthMenu": "Mostrar _MENU_ items por pagina",
                  "zeroRecords": "Nada encontrado",
                  "info": "Mostrando pagina _PAGE_ of _PAGES_",
                  "infoEmpty": "Sem datos disponiveis",
                  "infoFiltered": "(filtrado de _MAX_ total items)",
                  "search" : "Buscar",
                  "paginate": {
                    "previous": "Anterior",
                    "next": "Próximo"
                  }
              }
            });
        } );
    </script>
@endpush