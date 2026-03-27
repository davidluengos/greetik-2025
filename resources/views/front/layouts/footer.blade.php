<footer class="footer footer-directory">
  <div class="container">
    <div class="row">
      <div class="col-md-3 col-sm-6 footer-col">
        <h4 class="footer-title"><i class="fa fa-briefcase footer-title-icon" aria-hidden="true"></i> Empresa</h4>
        <ul class="footer-tree">
          <li><a href="{{ route('home') }}"><i class="fa fa-angle-right footer-link-icon" aria-hidden="true"></i>Inicio</a></li>
          <li><a href="{{ route('about') }}"><i class="fa fa-angle-right footer-link-icon" aria-hidden="true"></i>Sobre Nosotros</a></li>
          <li><a href="{{ route('posts.index') }}"><i class="fa fa-angle-right footer-link-icon" aria-hidden="true"></i>Blog</a></li>
          <li><a href="{{ route('contacto') }}"><i class="fa fa-angle-right footer-link-icon" aria-hidden="true"></i>Contacto</a></li>
        </ul>
      </div>

      <div class="col-md-3 col-sm-6 footer-col">
        <h4 class="footer-title"><i class="fa fa-certificate footer-title-icon" aria-hidden="true"></i> Servicios y Productos</h4>
        <ul class="footer-tree">
          <li><a href="{{ route('servicios.index') }}"><i class="fa fa-angle-right footer-link-icon" aria-hidden="true"></i>Servicios</a></li>
          <li><a href="{{ route('portfolio.index') }}"><i class="fa fa-angle-right footer-link-icon" aria-hidden="true"></i>Portfolio</a></li>
          <li><a href="/productos/mytrainik-software-para-entrenadores-personales-y-gimnasios"><i class="fa fa-angle-right footer-link-icon" aria-hidden="true"></i>MyTrainik</a></li>
          <li><a href="/productos/reservik-software-de-reserva-de-pistas-deportivas-online"><i class="fa fa-angle-right footer-link-icon" aria-hidden="true"></i>Reservik</a></li>
        </ul>
      </div>

      <div class="col-md-3 col-sm-6 footer-col">
        <h4 class="footer-title"><i class="fa fa-shield footer-title-icon" aria-hidden="true"></i> Legal</h4>
        <ul class="footer-tree">
          <li><a href="{{ route('legal.page', ['slug' => 'aviso-legal']) }}"><i class="fa fa-angle-right footer-link-icon" aria-hidden="true"></i>Aviso Legal</a></li>
          <li><a href="{{ route('legal.page', ['slug' => 'politica-de-privacidad']) }}"><i class="fa fa-angle-right footer-link-icon" aria-hidden="true"></i>Política de Privacidad</a></li>
          <li><a href="{{ route('legal.page', ['slug' => 'politica-de-cookies']) }}"><i class="fa fa-angle-right footer-link-icon" aria-hidden="true"></i>Política de Cookies</a></li>
          <li><a href="{{ route('legal.page', ['slug' => 'terminos-y-condiciones']) }}"><i class="fa fa-angle-right footer-link-icon" aria-hidden="true"></i>Términos y Condiciones</a></li>
        </ul>
      </div>

      <div class="col-md-3 col-sm-6 footer-col">
        <h4 class="footer-title"><i class="fa fa-envelope-o footer-title-icon" aria-hidden="true"></i> Contacto rápido</h4>
        <p class="footer-text">Desarrollo web profesional para empresas y negocios.</p>
        <a class="footer-cta" href="{{ route('contacto') }}"><i class="fa fa-envelope footer-link-icon" aria-hidden="true"></i>Hablemos de tu proyecto</a>
      </div>
    </div>
  </div>
</footer>

<footer class="footer-small footer-small-contrast">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-sm-6">
        <div class="copyright">
          <p>&copy; {{ date('Y') }} Greetik. Todos los derechos reservados.</p>
        </div>
      </div>
      <div class="col-md-6 col-sm-6 text-right">
        <ul class="social-link-footer list-unstyled">
          
        </ul>
      </div>
    </div>
  </div>
</footer>
