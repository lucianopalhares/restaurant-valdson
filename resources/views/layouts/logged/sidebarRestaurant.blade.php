<div class="sidebar" data-color="purple" data-image="{{ asset('backend/img/sidebar-1.jpg') }}">

    <div class="logo">
        <a href="{{ url('restaurante/'.$restaurant->slug.'/dashboard') }}" class="simple-text">
          <i class="material-icons">home</i> {{$restaurant->name}}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ Request::is('restaurante/'.$restaurant->slug.'/dashboard*') ? 'active': '' }}">
                <a href="{{ url('restaurante/'.$restaurant->slug.'/dashboard') }}">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="{{ Request::is('restaurante/'.$restaurant->slug.'/cardapio*') ? 'active': '' }}">
                <a href="{{ url('restaurante/'.$restaurant->slug.'/cardapio') }}">
                    <i class="material-icons">library_books</i>
                    <p>Cardápios</p>
                </a>
            </li>
            <li class="{{ Request::is('restaurante/'.$restaurant->slug.'/promocao*') ? 'active': '' }}">
                <a href="{{ url('restaurante/'.$restaurant->slug.'/promocao') }}">
                    <i class="material-icons">library_books</i>
                    <p>Promoções</p>
                </a>
            </li>
            <li class="{{ Request::is('restaurante/'.$restaurant->slug.'/restaurante_categoria*') ? 'active': '' }}">
                <a href="{{ url('restaurante/'.$restaurant->slug.'/restaurante_categoria') }}">
                    <i class="material-icons">library_books</i>
                    <p>Categorias do Restaurante</p>
                </a>
            </li>
        </ul>
    </div>
</div>