<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center mar-b-30">
        <p class="text-muted small mb-0">Documentacion legal</p>
        <ul class="list-inline site-legal-links">
          <li><a href="{{ route('legal.page', ['slug' => 'aviso-legal']) }}">Aviso legal</a></li>
          <li><span class="text-muted"> · </span></li>
          <li><a href="{{ route('legal.page', ['slug' => 'politica-de-privacidad']) }}">Privacidad</a></li>
          <li><span class="text-muted"> · </span></li>
          <li><a href="{{ route('legal.page', ['slug' => 'politica-de-cookies']) }}">Cookies</a></li>
          <li><span class="text-muted"> · </span></li>
          <li><a href="{{ route('legal.page', ['slug' => 'terminos-y-condiciones']) }}">Terminos y condiciones</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>

<footer class="footer-small">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-sm-6 pull-right">
        <ul class="social-link-footer list-unstyled">
          <li><a href="#"><i class="fa fa-facebook"></i></a></li>
          <li><a href="#"><i class="fa fa-twitter"></i></a></li>
        </ul>
      </div>
      <div class="col-md-4">
        <div class="copyright">
          <p>&copy; {{ date('Y') }} Greetik</p>
        </div>
      </div>
    </div>
  </div>
</footer>
