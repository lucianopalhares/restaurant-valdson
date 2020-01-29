<div class="sidebar" data-color="purple" data-image="{{ asset('backend/img/sidebar-1.jpg') }}">

    <div class="logo">
        <a href="{{ route('welcome') }}" class="simple-text">
          @if($restaurant = \App\Restaurant::first())
            {{$restaurant->name}}
          @else 
            Cadastre o Restaurante
          @endif
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ Request::is('admin/dashboard*') ? 'active': '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>
            @if($restaurant = \App\Restaurant::first())
            <li class="{{ Request::is('admin/restaurant/'.$restaurant->id) ? 'active': '' }}">
                <a href="{{ url('admin/restaurant/'.$restaurant->id) }}">
                    <i class="material-icons">content_paste</i>
                    <p>Dados do Restaurante</p>
                </a>
            </li>
            @else 
            <li class="{{ Request::is('admin/restaurant/create') ? 'active': '' }}">
                <a href="{{ route('restaurant.create') }}">
                    <i class="material-icons">content_paste</i>
                    <p>Cadastrar Restaurante</p>
                </a>
            </li>            
            @endif
            <li class="{{ Request::is('admin/category*') ? 'active': '' }}">
                <a href="{{ route('category.index') }}">
                    <i class="material-icons">content_paste</i>
                    <p>Categorias</p>
                </a>
            </li>
            <li class="{{ Request::is('admin/item*') ? 'active': '' }}">
                <a href="{{ route('item.index') }}">
                    <i class="material-icons">library_books</i>
                    <p>Cardápios</p>
                </a>
            </li>
            <li class="{{ Request::is('admin/reservation*') ? 'active': '' }}">
                <a href="{{ route('reservation.index') }}">
                    <i class="material-icons">chrome_reader_mode</i>
                    <p>Reservas de Mesa</p>
                </a>
            </li>
            <li class="{{ Request::is('admin/contact*') ? 'active': '' }}">
                <a href="{{ route('contact.index') }}">
                    <i class="material-icons">message</i>
                    <p>Mensagens de Contato</p>
                </a>
            </li>
            <li class="{{ Request::is('admin/slider*') ? 'active': '' }}">
                <a href="{{ route('slider.index') }}">
                    <i class="material-icons">slideshow</i>
                    <p>Sliders</p>
                </a>
            </li>
            <li class="{{ Request::is('admin/paymentWay*') ? 'active': '' }}">
                <a href="{{ route('paymentWay.index') }}">
                    <i class="material-icons">money</i>
                    <p>Formas de Pagamento</p>
                </a>
            </li>
            <li class="{{ Request::is('admin/role*') ? 'active': '' }}">
                <a href="{{ route('role.index') }}">
                    <i class="material-icons">money</i>
                    <p>Cargos do Sistema</p>
                </a>
            </li>
        </ul>
    </div>
</div>