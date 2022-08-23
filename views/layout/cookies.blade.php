<div id="accept-cookies" style="display: none;">
  <div class="content">
      <div class="title-card">
        <strong>Esse site usa cookies</strong>
        @include('utils.icons.cookies')
      </div>
      <p>Nós armazenamos dados temporariamente para melhorar a sua experiencia de navegação e recomendar conteúdo do seu enteresse. Ao utilizar este site você concorda com tal monitoramento.</p>
      <a href="{{ route('privacy.policy') }}" target="_blank">Politica de Privacidade</a>
      <button
        type="button"
        onclick="handleAcceptCookies()"
        class="btn btn-primary"
      >OK</button>
  </div>
</div>
<script>
  $(function(){
    let statCookies = localStorage.getItem("@cms:accepted_cookies");
    if (!statCookies || statCookies !== 'accepted') $('#accept-cookies').show('slow');
  });

  function handleAcceptCookies() {
    localStorage.setItem('@cms:accepted_cookies', 'accepted');
    $('#accept-cookies').hide('slow');
  }
</script>