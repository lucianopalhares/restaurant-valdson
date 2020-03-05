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
                    <a href="{{ url('restaurante/'.$restaurant->slug.'/promocao/create')  }}" class="btn btn-primary">Cadastrar</a>
                    @include('layouts.logged.msg')
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">Todas Promoções</h4>
                        </div>
                        <div class="card-content table-responsive">
                            <table id="table" class="table"  cellspacing="0" width="100%">
                                <thead class="text-primary">
                                <th>ID</th>
                                <th>Cardápio</th>
                                <th>Preço</th>
                                <th>Validade</th>
                                <th>Status</th>
                                <th>Ações</th>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->item->name }}</td>
                                            <td>R$ {{ $item->price }}</td>
                                            <td>{{date('d/m/Y', strtotime($item->start))}} a {{date('d/m/Y', strtotime($item->end))}}</td>
                                            <td>
                                              @if($item->active=='1')
                                                <span class="btn btn-success btn-sm"><i class="material-icons">check</i> Ativa</span>
                                                
                                              @else
                                                <span class="btn btn-danger btn-sm"><i class="material-icons">block</i> Inativa</span>
                                              @endif
                                            </td>
                                            <td>
                                              @if($item->active=='1')
                                                <a href="{{ url('restaurante/'.$restaurant->slug.'/ativar-promocao/'.$item->id)  }}" class="btn btn-warning btn-sm">Desativar</a>
                                              @else 
                                                <a href="{{ url('restaurante/'.$restaurant->slug.'/ativar-promocao/'.$item->id)  }}" class="btn btn-success btn-sm">Ativar</a>
                                              @endif
                                                                                            
                                                <a href="{{ url('restaurante/'.$restaurant->slug.'/promocao/'.$item->id.'/edit')  }}" class="btn btn-info btn-sm"><i class="material-icons">mode_edit</i></a>
                                                
                                                

                                                <form id="delete-form-{{ $item->id }}" action="{{ url('restaurante/'.$restaurant->slug.'/promocao/'.$item->id) }}" style="display: none;" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Voce quer mesmo deletar?')){
                                                    event.preventDefault();
                                                    document.getElementById('delete-form-{{ $item->id }}').submit();
                                                }else {
                                                    event.preventDefault();
                                                        }"><i class="material-icons">delete</i></button>
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