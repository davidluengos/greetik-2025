<header class="head-section">
  <div class="navbar navbar-default navbar-static-top container">
    <div class="navbar-header">
      <button class="navbar-toggle" data-target=".navbar-collapse" data-toggle="collapse" type="button">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ url('/') }}">Gree<span>tik</span></a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li><a href="{{ route('home') }}">Inicio</a></li>
        <li><a href="{{ route('about') }}">Sobre Nosotros</a></li>

        <li><a href="{{ route('servicios.index') }}">Servicios</a></li>

        <li class="dropdown">
          <a class="dropdown-toggle" data-close-others="false" data-delay="0" data-hover="dropdown" data-toggle="dropdown"
            href="#">
            Productos <i class="fa fa-angle-down"></i>
          </a>
          <ul class="dropdown-menu">
            @foreach (($menuProjects ?? collect()) as $menuProject)
              <li>
                <a href="{{ route('productos.show', $menuProject->slug) }}">{{ $menuProject->title }}</a>
              </li>
            @endforeach
          </ul>
        </li>

        <li><a href="{{ route('portfolio.index') }}">Portfolio</a></li>
        <li><a href="{{ route('posts.index') }}">Blog</a></li>
        <li><a href="{{ route('contacto') }}">Contacto</a></li>
      </ul>
    </div>
  </div>
</header>
