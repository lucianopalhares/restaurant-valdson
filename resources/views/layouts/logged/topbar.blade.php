<nav class="navbar navbar-transparent navbar-absolute">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"> Olá, {{ Auth::user()->name }} </a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                @if(Request::is('restaurante*'))
                <li>
                    <a href="{{url('admin/dashboard')}}" class="dropdown-toggle">
                        <i class="material-icons">dashboard</i> Painel Admin
                    </a>
                </li>
                @endif
                @if(Request::is('cliente*'))
                <li>
                  @if(\App\Customer::find(\Auth::user()->id)->carts->count())
                    <a href="{{url('cliente/carrinho')}}" class="dropdown-toggle">                      
                  
                      <i class="material-icons text-success">shopping_cart</i>
                      <span class="badge badge-primary">
                         {{\App\Customer::find(\Auth::user()->id)->carts->count()}}
                      </span>
                    </a>
                  @else 
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">                      
                      <i class="material-icons text-secondary">shopping_cart</i>
                      <span class="badge badge-primary">
                         0
                      </span>
                    </a>                  
                  @endif
                </li> 
                @endif
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="material-icons">exit_to_app</i>
                        Sair
                    </a>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>