<div class="sidebar" data-color="purple" data-image="{{ asset('backend/img/sidebar-1.jpg') }}">

    <div class="logo">
        <a href="{{ url('cliente/dashboard') }}" class="simple-text">
        <i class="material-icons">verified_user</i>  PAINEL do CLIENTE
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ Request::is('cliente/dashboard*') ? 'active': '' }}">
                <a href="{{ url('cliente/dashboard') }}">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="{{ Request::is('cliente/promocoes*') ? 'active': '' }}">
                <a href="{{ url('cliente/promocoes') }}">
                    <i class="material-icons">touch_app</i>
                    <p>Promoções do Momento</p>
                </a>
            </li>            
            <li class="{{ Request::is('cliente/menu*') ? 'active': '' }}">
                <a href="{{ url('cliente/menu') }}">
                    <i class="material-icons">menu_book</i>
                    <p>Menu Geral</p>
                </a>
            </li>   
            <li class="{{ Request::is('cliente/compras*') ? 'active': '' }}">
                <a href="{{ url('cliente/compras') }}">
                    <i class="material-icons">store</i>
                    <p>Minhas Compras</p>
                </a>
            </li>    
        </ul>
    </div>
</div>