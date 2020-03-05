<div class="sidebar" data-color="purple" data-image="{{ asset('backend/img/sidebar-1.jpg') }}">

    <div class="logo">
        <a href="{{ url('admin/dashboard') }}" class="simple-text">
        <i class="material-icons">lock</i>  PAINEL ADMIN
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ Request::is('admin/dashboard*') ? 'active': '' }}">
                <a href="{{ url('admin/dashboard') }}">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>
            
            <li class="{{ Request::is('admin/restaurante*') ? 'active': '' }}">
                <a href="{{ url('admin/restaurante') }}">
                    <i class="material-icons">open_in_browser</i>
                    <p>Restaurantes</p>
                </a>
            </li>
            <li class="{{ Request::is('admin/formaPagamento*') ? 'active': '' }}">
                <a href="{{ url('admin/formaPagamento') }}">
                    <i class="material-icons">content_paste</i>
                    <p>Formas de Pagamento</p>
                </a>
            </li>
            <li class="{{ Request::is('admin/cargo*') ? 'active': '' }}">
                <a href="{{ url('admin/cargo') }}">
                    <i class="material-icons">library_books</i>
                    <p>Cargos</p>
                </a>
            </li>
            <li class="{{ Request::is('admin/categoria*') ? 'active': '' }}">
                <a href="{{ url('admin/categoria') }}">
                    <i class="material-icons">content_paste</i>
                    <p>Categorias</p>
                </a>
            </li>
            <li class="{{ Request::is('admin/cupom*') ? 'active': '' }}">
                <a href="{{ url('admin/cupom') }}">
                    <i class="material-icons">aspect_ratio</i>
                    <p>Cupoms</p>
                </a>
            </li>
            <li class="{{ Request::is('admin/cliente*') ? 'active': '' }}">
                <a href="{{ url('admin/cliente') }}">
                    <i class="material-icons">accessibility</i>
                    <p>Clientes</p>
                </a>
            </li>
            <li class="{{ Request::is('admin/vendas*') ? 'active': '' }}">
                <a href="{{ url('admin/vendas') }}">
                    <i class="material-icons">attach_money</i>
                    <p>Vendas</p>
                </a>
            </li>
        </ul>
    </div>
</div>