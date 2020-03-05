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
                            <h4 class="title">Carrinho de Compras</h4>
                        </div>
                        <div class="card-content">
                          
      <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Seus Produtos</span>
            <span class="badge badge-secondary badge-pill">{{$items->count()}}</span>
            <a href="{{url('cliente/esvaziar-carrinho')}}" class="badge badge-danger"><i class="material-icons text-danger">delete</i>Apagar Carrinho</a>
          </h4>
          <ul class="list-group mb-3">
            @foreach ($items as $item) 
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                  <h6 class="my-0">{{$item->item->name}}</h6>
                  <small class="text-muted">{{$item->item->description}}</small>
                </div>
                <span class="text-muted">
                  @if($item->item->promotion()->exists())                                                
                    R$ {{ $item->item->promotion->price }}                                                
                  @else 
                    R$ {{ $item->item->price }}
                  @endif
                </span>
              </li>
            @endforeach
            <li class="list-group-item d-flex justify-content-between">
              <span>Total:</span>
              <strong>R$ {{$totalOrder}}</strong>
            </li>            
            @if($coupon)
              <li class="list-group-item d-flex justify-content-between bg-light">
                <div class="text-success">
                  <h6 class="my-0">Cupom de Desconto (<strong>{{strtoupper($coupon->code)}}</strong>)</h6>
                  <small></small>
                </div>
                <span class="text-success">-R$ {{$coupon->value}} </span>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                <span>Total Final:</span>
                <strong>R$ {{$totalOrder-$coupon->value}}</strong>
              </li>
            @endif

          </ul>

          <form class="card p-2" method="get" action="{{url('cliente/carrinho')}}">
            <div class="input-group">
              <input type="text" class="form-control" name="coupon" value="{{$coupon?strtoupper($coupon->code):''}}" placeholder="Cupom de Desconto">
              <div class="input-group-append">
                <button type="submit" class="btn btn-secondary">Aplicar Desconto</button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Dados da Compra</h4>
          <form class="needs-validation" method="post" action="{{url('cliente/finalizar-compra')}}" novalidate>
            @csrf
            
            <input type="hidden" name="coupon_id" value="{{$coupon?strtoupper($coupon->id):''}}">
            <input type="hidden" name="total" value="{{$totalOrder}}">
            <input type="hidden" name="total_final" value="{{$coupon?$totalOrder-$coupon->value:$totalOrder}}">
            
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="name">Nome *</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{ old('name',\Auth::user()->name)}}" required>

              </div>
              <div class="col-md-6 mb-3">
                <label for="mobile">Celular *</label>
                <input type="number" class="form-control" id="mobile" name="mobile" placeholder="" value="{{ old('mobile',\Auth::user()->mobile)}}" required>

              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="address">Endereço *</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="" value="{{ old('address',\Auth::user()->address)}}" required>

              </div>
              <div class="col-md-6 mb-3">
                <label for="district">Bairro *</label>
                <input type="text" class="form-control" id="district" name="district" placeholder="" value="{{ old('district',\Auth::user()->district)}}" required>

              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="city">Cidade *</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="" value="{{ old('city',\Auth::user()->city)}}" required>

              </div>
              <div class="col-md-6 mb-3">
                <label for="district">Estado *</label>
                <select class="form-control" name="state" id="state" required>
                    <option value=" ">UF</option>
                    @foreach(states() as $uf)
                        <option value="{{$uf['code']}}" {{ old('state') == $uf['code'] ? "selected='selected'" : \Auth::user()->state == $uf['code'] ? "selected='selected'" : ''}}</option>
                          {{$uf['code']}}
                        </option>
                    @endforeach
                </select>
              </div>
            </div>
            
            <div class="mb-3">
              <label for="email">Email <span class="text-muted">*</span></label>
              <input type="email" class="form-control" id="email" name="email" placeholder="email@email.com" value="{{ old('email',\Auth::user()->email)}}">

            </div>


            <hr class="mb-4">

            <h4 class="mb-3">Forma de Pagamento</h4>

            <div class="d-block my-3">
              @foreach($paymentWays as $paymentWay)
                <div class="custom-control custom-radio">
                  <input name="payment_way_id" value="{{$paymentWay->id}}" type="radio" class="custom-control-input" checked required>
                  <label class="custom-control-label" for="credit">{{$paymentWay->name}}</label>
                </div>
              @endforeach
            </div>

            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Continuar e Finalizar</button>
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
    



