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
                            <h4 class="title">Items da Venda ID:{{$venda->id}} em {{date('d/m/Y H:i:s', strtotime($venda->created_at))}} - Cliente: {{$venda->customer->name}}</h4>
                        </div>
                        <div class="card-content table-responsive">
                            <table id="table" class="table"  cellspacing="0" width="100%">
                                <thead class="text-primary">
                                <th>ID</th>
                                <th>Cardápio</th>
                                <th>Imagem</th>
                                <th>Valor</th>
                                <th>Restaurante</th>
                                </thead>
                                <tbody>
                                    @foreach($venda->order_items as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>@if(isset($item->item->image))<img class="img-responsive img-thumbnail" src="{{ asset('uploads/item/'.$item->item->image) }}" style="height: 100px; width: 100px" data-toggle='tooltip' data-placement='top' title='@if(isset($item->item->image))public/uploads/item/{{$item->item->image}}@endif'>@endif</td>
                                            <td>
                                              R$ {{ $item->price }}
                                            </td>
    
                                            <td>{{ $item->restaurant }}</td>
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