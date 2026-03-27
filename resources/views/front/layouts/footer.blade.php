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
        @if (!empty($contactPhoneHref) && !empty($contactPhone))
          <p class="footer-contact-line">
            <i class="fa fa-phone footer-link-icon" aria-hidden="true"></i>
            <a href="{{ $contactPhoneHref }}">{{ $contactPhone }}</a>
          </p>
        @endif
        @if (!empty($contactEmail))
          <p class="footer-contact-line">
            <i class="fa fa-envelope footer-link-icon" aria-hidden="true"></i>
            <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>
          </p>
        @endif
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

@if (!empty($contactWhatsappHref))
  <a href="{{ $contactWhatsappHref }}" class="whatsapp-float" target="_blank" rel="noopener" aria-label="Contactar por WhatsApp">
    <svg viewBox="0 0 32 32" aria-hidden="true" focusable="false">
      <path fill="currentColor" d="M19.11 17.2c-.28-.14-1.63-.8-1.88-.89-.25-.1-.43-.14-.62.14-.19.29-.71.89-.88 1.07-.16.18-.33.2-.61.07-.28-.14-1.2-.44-2.28-1.41-.84-.75-1.41-1.67-1.57-1.95-.16-.28-.02-.43.12-.56.12-.12.28-.33.42-.49.14-.16.19-.28.28-.47.09-.19.05-.36-.02-.5-.08-.14-.62-1.5-.85-2.06-.22-.53-.45-.46-.62-.47h-.53c-.19 0-.5.07-.76.36-.26.28-.99.96-.99 2.34s1.01 2.72 1.15 2.91c.14.19 1.97 3 4.78 4.21.67.29 1.19.46 1.6.59.67.21 1.27.18 1.75.11.53-.08 1.63-.67 1.86-1.32.23-.66.23-1.22.16-1.33-.06-.11-.25-.18-.53-.32z"/>
      <path fill="currentColor" d="M16 3.2c-7.05 0-12.8 5.75-12.8 12.8 0 2.26.59 4.48 1.71 6.44L3.2 28.8l6.53-1.68A12.74 12.74 0 0 0 16 28.8c7.05 0 12.8-5.75 12.8-12.8 0-7.05-5.75-12.8-12.8-12.8zm0 23.29c-2.03 0-4-.54-5.74-1.56l-.41-.24-3.88 1 1.04-3.78-.27-.43a10.5 10.5 0 0 1-1.62-5.48c0-5.79 4.71-10.5 10.5-10.5 2.81 0 5.45 1.09 7.43 3.08a10.44 10.44 0 0 1 3.07 7.42c0 5.79-4.71 10.5-10.5 10.5z"/>
    </svg>
  </a>
@endif
