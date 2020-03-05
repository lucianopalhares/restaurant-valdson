@extends('layouts.logged.app')

@section('title','Promoções')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    
                    @include('layouts.logged.msg')
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">Minhas Compras</h4>
                        </div>
                        <div class="card-content table-responsive">
                            <table id="table" class="table"  cellspacing="0" width="100%">
                                <thead class="text-primary">
                                <th>ID</th>
                                <th>Valor</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th>Ações</th>
                                </thead>
                                <tbody>
                                    @foreach($items as $key=>$item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>R$ {{ $item->total_final }}</td>   
                                            <td>{{date('d/m/Y H:i:s', strtotime($item->created_at))}}</td>
                                            <td>
                                              @if($item->status=='0')
                                                <span class="badge badge-danger">Cancelada</span>
                                              @elseif($item->status=='1')
                                                <span class="badge badge-success">Ativa</span>
                                              @elseif($item->status=='2')
                                                <span class="badge badge-warning">Cancelando..</span>
                                              @endif
                                            </td> 
                                            <td>
                                                <a href="{{url('cliente/compra/'.$item->id)}}" class="btn btn-info btn-sm"><i class="material-icons">subject</i> Ver Items</a>
                                                  <a href="{{url('cliente/cancelar-compra/'.$item->id)}}" class="btn btn-danger btn-sm"><i class="material-icons">block</i> Solicitar Cancelamento</a>
                                        
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