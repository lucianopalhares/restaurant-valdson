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
                            <h4 class="title">Vendas</h4>
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
                                                <span class="btn btn-danger btn-sm">Cancelada</span>
                                              @elseif($item->status=='1')
                                                <span class="btn btn-success btn-sm">Ativa</span>
                                              @elseif($item->status=='2')
                                                <span class="btn btn-warning btn-sm">Solicitação para Cancelar</span>
                                              @endif
                                            </td> 
                                            <td>
                                                <a href="{{url('admin/vendas/'.$item->id)}}" class="btn btn-primary btn-sm"><i class="material-icons">remove_red_eye</i> Visualizar</a>
                                                <a href="{{url('admin/items-venda/'.$item->id)}}" class="btn btn-info btn-sm"><i class="material-icons">subject</i> Ver Items</a>
                                                @if($item->status!='1')
                                                  <a href="{{url('admin/status-venda/'.$item->id)}}" class="btn btn-success btn-sm"><i class="material-icons">check</i> Ativar</a>
                                                @else
                                                  <a href="{{url('admin/status-venda/'.$item->id)}}" class="btn btn-danger btn-sm"><i class="material-icons">block</i> Cancelar</a>
                                                @endif
                                                
                                        
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