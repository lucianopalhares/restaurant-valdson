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
                            <h4 class="title">Cardápio Geral</h4>
                        </div>
                        <div class="card-content table-responsive">
                            <table id="table" class="table"  cellspacing="0" width="100%">
                                <thead class="text-primary">
                                <th>ID</th>
                                <th>Cardápio</th>
                                <th>Imagem</th>
                                <th>Valor</th>
                                <th>Restaurante</th>
                                <th>Ações</th>
                                </thead>
                                <tbody>
                                    @foreach($items as $key=>$item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>@if(isset($item->image))<img class="img-responsive img-thumbnail" src="{{ asset('uploads/item/'.$item->image) }}" style="height: 100px; width: 100px" data-toggle='tooltip' data-placement='top' title='@if(isset($item->image))public/uploads/item/{{$item->image}}@endif'>@endif</td>
                                            <td>
                                              @if($item->promotion()->exists())
                                                <strike>R$ {{ $item->price }}</strike> 
                                                
                                                R$ {{ $item->promotion->price }}
                                                
                                                até {{date('d/m/Y', strtotime($item->promotion->end))}}
                                              @else 
                                                R$ {{ $item->price }}
                                              @endif
                                            </td>
    
                                            <td>{{ $item->restaurant->name }}</td>
                                            <td>
                                                <a href="{{url('cliente/adicionar-carrinho/'.$item->id)}}" class="btn btn-info btn-sm"><i class="material-icons">add_shopping_cart</i> Adicionar</a>
                                        
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