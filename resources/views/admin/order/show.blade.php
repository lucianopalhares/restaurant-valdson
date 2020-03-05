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
                            <h4 class="title">Detalhes da Venda</h4>
                        </div>
                        <div class="card-content">
                          
      <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Produtos</span>
            <span class="badge badge-secondary badge-pill">{{$item->items->count()}}</span>

          </h4>
          <ul class="list-group mb-3">
            @foreach ($item->order_items as $order_item) 
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                  <h6 class="my-0">{{$order_item->name}}</h6>
                  <small class="text-muted">{{$order_item->description}}</small>
                </div>
                <span class="text-muted">
                  R$ {{ $order_item->price }}
                </span>
              </li>
            @endforeach
            <li class="list-group-item d-flex justify-content-between">
              <span>Total:</span>
              <strong>R$ {{$item->total}}</strong>
            </li>            
            @if($item->coupon()->exists())
              <li class="list-group-item d-flex justify-content-between bg-light">
                <div class="text-success">
                  <h6 class="my-0">Cupom de Desconto (<strong>{{strtoupper($item->coupon_code)}}</strong>)</h6>
                  <small></small>
                </div>
                <span class="text-success">-R$ {{$item->coupon_value}} </span>
              </li>
            @endif
              <li class="list-group-item d-flex justify-content-between">
                <span>Total Final:</span>
                <strong>R$ {{$item->total_final}}</strong>
              </li>

              <li class="list-group-item d-flex justify-content-between">
                <span>Status:</span>
                <strong>
                @if($item->status=='0')
                  <span class="text-danger">Cancelada</span>
                @elseif($item->status=='1')
                  <span class="text-success">Ativa</span>
                @elseif($item->status=='1')
                  <span class="text-warning">Solicitação de Cancelamento</span>
                @endif  
                </strong> 
              </li>           
          </ul>


        </div>
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Dados da Venda</h4>
          <form class="needs-validation" method="post" action="" novalidate>
  
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="name">Nome do Cliente *</label>
                <input type="text" disabled="disabled" class="form-control" id="name" name="name" placeholder="" value="{{$item->customer->name}}" required>

              </div>
              <div class="col-md-6 mb-3">
                <label for="mobile">Celular *</label>
                <input type="number" disabled="disabled" class="form-control" id="mobile" name="mobile" placeholder="" value="{{$item->customer->mobile}}" required>

              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="address">Endereço *</label>
                <input type="text" disabled="disabled" class="form-control" id="address" name="address" placeholder="" value="{{$item->customer->address}}" required>

              </div>
              <div class="col-md-6 mb-3">
                <label for="district">Bairro *</label>
                <input type="text" disabled="disabled" class="form-control" id="district" name="district" placeholder="" value="{{$item->customer->district}}" required>

              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="city">Cidade *</label>
                <input type="text" disabled="disabled" class="form-control" id="city" name="city" placeholder="" value="{{$item->customer->city}}" required>

              </div>
              <div class="col-md-6 mb-3">
                <label for="state">Estato *</label>
                <input type="text" disabled="disabled" class="form-control" id="state" name="state" placeholder="" value="{{$item->customer->state}}" required>

              </div>
            </div>
            
            <div class="mb-3">
              <label for="email">Email <span class="text-muted">*</span></label>
              <input type="email" disabled="disabled" class="form-control" id="email" name="email" placeholder="email@email.com" value="{{$item->customer->email}}">

            </div>


            <hr class="mb-4">

            <h4 class="mb-3">Forma de Pagamento</h4>

            <div class="d-block my-3">
                <div class="custom-control custom-radio">                
                  <label class="custom-control-label">{{$item->paymentWay->name}}</label>
                </div>
            </div>

            <hr class="mb-4">
          </form>
        </div>
      </div>
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
    



