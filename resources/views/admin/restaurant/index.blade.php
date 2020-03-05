@extends('layouts.logged.app')

@section('title','Items')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ url('admin/restaurante/create') }}" class="btn btn-primary">Cadastrar</a>
                    @include('layouts.logged.msg')
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">Todos Restaurantes</h4>
                        </div>
                        <div class="card-content table-responsive">
                            <table id="table" class="table"  cellspacing="0" width="100%">
                                <thead class="text-primary">
                                <th>ID</th>
                                <th>Nome</th>
                                <th>
                                  Logo
                                </th>
                                <th>Cadastrado</th>
                                <th>Editado</th>
                                <th>Ações</th>
                                </thead>
                                <tbody>
                                    @foreach($items as $key=>$item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>@if(isset($item->logo))<img class="img-responsive img-thumbnail" src="{{ asset('frontend/images/restaurants/'.$item->logo) }}" style="height: 100px; width: 100px" data-toggle='tooltip' data-placement='top' title='@if(isset($item->logo))public/frontend/images/restaurants/{{$item->logo}}@endif'>@endif</td>
                                            <td>{{date('H:m d/m/Y', strtotime($item->created_at))}}</td>
                                            <td>{{date('H:m d/m/Y', strtotime($item->updated_at))}}</td>
                                            <td>
                                                <a href="{{ url('admin/restaurante/'.$item->id.'/edit') }}" class="btn btn-info btn-sm"><i class="material-icons">mode_edit</i></a>
                                                @if(1==1)
                                                <form id="delete-form-{{ $item->id }}" action="{{ url('admin/restaurante/'.$item->id) }}" style="display: none;" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Quer mesmo deletar o Restaurante?')){
                                                    event.preventDefault();
                                                    document.getElementById('delete-form-{{ $item->id }}').submit();
                                                }else {
                                                    event.preventDefault();
                                                        }"><i class="material-icons">delete</i></button>
                                                @endif
                                                <a href="{{ url('admin/restaurante/'.$item->id) }}" class="btn btn-secondary btn-sm"><i class="material-icons">remove_red_eye</i></a>
                                                <a href="{{ url('restaurante/'.$item->slug.'/dashboard') }}" class="btn btn-warning btn-sm"><i class="material-icons">label_important</i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
                  "order": [[0, 'desc']],
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