<style>
  #modalLoginLead{
    display: none;
    z-index: 99999;
  }
  #modalLoginLead .overlay{
    background: rgba(0,0,20,.6);
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 99999;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  #modalLoginLead .overlay .container{
    background: #fff;
    width: 100%;
    max-width: 30rem;
    height: auto;
    max-height: calc(100vh - 2rem);
    overflow-y: auto;
    padding: 2rem 3rem;
    margin: auto 1rem;
    border-radius: 5px;
    box-shadow: 0 0 60px rgba(0,0,0,.05);
    text-align: center;
    position: relative;
  }
  #modalLoginLead .overlay .container header{
    font-size: 1.75rem;
    font-weight: 600;
    display: flex;
    flex-wrap: inherit;
    justify-content: center;
    padding-bottom: 1.2rem;
  }
    
  #modalLoginLead .overlay .container section{
    font-size: 1rem;
    color: #668;
    margin-top: 1rem;
  }
  #modalLoginLead .overlay .container button.closeModal{
    position: absolute;
    right: .5rem;
    top: .1rem;
    background: transparent;
    border: 0;
    font-size: 1.2rem;
    cursor: pointer;
  }
  #modalLoginLead .form-group{
    position: relative;
    display: flex;
    align-items: center;
    gap: .3rem;
    border: 1px solid var(--gray-100);
    border-radius: 4px;
    padding-left: .6rem;
  }
  #modalLoginLead #div-login-lead-name{
    margin-bottom: .5rem;
  }
  #modalLoginLead .form-control{
    height: 3rem;
    min-width: 14rem;
    flex: 1;
    outline: none;
  }
  #modalLoginLead .form-group.has-error{
    border: 2px solid #f347;
    margin-bottom: 2rem;
  }
  #modalLoginLead .btn-submit{
    display: flex;
    width: 100%;
    align-items: center;
    justify-content: center;
    height: 3rem;
    margin-top: .5rem;
    border-radius: 4px;
    font-weight: bold;
    color: var(--gray-100);
    background: var(--primary-500);
  }
  #modalLoginLead #btn-login-lead-register{
    display: block;
    text-align: center;
    margin-top: .3rem;
  }
  #modalLoginLead #btn-login-lead-register:hover{
    text-decoration: underline;
  }
  #login-lead-result{
    display: none;
    padding: 1rem 1rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: .25rem;
  }
  #login-lead-result.alert-success{
    color: #0f5132;
    background-color: #d1e7dd;
    border-color: #badbcc;
  }
  #login-lead-result.alert-fail{
    color: var(--red-800);
    background-color: #f8d7da;
    border-color: #f5c2c7;
  }
  /* BEGIN:: LOGGED WITH */
  #logged-with {
    color: var(--gray-500);
    font-size: .8rem;
  }
  #logged-with button{
    border-radius: 99rem;
    color: var(--red-800);
    background: transparent;

    transition: .2s;
  }
  #logged-with button:hover{ background: var(--gray-200); }
  #logged-with a:hover{
    text-decoration: underline;
  }
  /* END:: LOGGED WITH */
</style>
<div id="modalLoginLead">
  <div class="overlay">
    <div class="container">
      <header>Login CMS</header>
      <section>
        <form onsubmit="return handleLeadSubmit(event)">
          <div id="login-lead-result"></div>
          <div class="form-group d-none" id="div-login-lead-name">
            <img src="{{ asset('assets/icons/person.svg', true) }}" alt="Nome"/>
            <input
              type="text"
              id="login-lead-name"
              class="form-control"
              placeholder="Nome"
            />
            <span class="error-message">O nome é obrigatório</span>
          </div>
          <div class="form-group" id="div-login-lead-email">
            <img src="{{ asset('assets/icons/mail_outline.svg', true) }}" alt="Email"/>
            <input
              type="email"
              id="login-lead-email"
              class="form-control"
              placeholder="Email"
              required
            />
            <span class="error-message">Email não encontrado!</span>
          </div>
          <button type="submit" class="btn-submit">Entrar</button>
          <a href="javscript:;" onclick="registerLead()" id="btn-login-lead-register">Não sou cadastrado</a>
        </form>
      </section>
      <button class="closeModal" type="button" onclick="$('#modalLoginLead').hide();">x</button>
    </div>
  </div>
</div>
<script>
  let postLead = null; /* { id, name, thumbnail? } */
  const loginLeadApiUrl = "{{ route('api.postlead.login') }}";
  const registerLeadApiUrl = "{{ route('api.postlead.store') }}";

  function handleLeadSubmit(event){
    event.preventDefault();
    if($('#modalLoginLead .btn-submit').html() == 'Entrar'){
      const data = {
        email: $('#login-lead-email').val(),
        owner_id: '{{ $post->user_id }}'
      };
      $.post(loginLeadApiUrl, data).done(function(data){
        if(data.result){
          handleStorageLead(data.response);

          $('#login-lead-result').html('Logado com Sucesso')
            .removeClass('alert-fail')
            .addClass('alert-success')
            .show('slow');

          $('#modalLoginLead').hide();
        }
        else{
          $('#div-login-lead-email').addClass('has-error');
          $('#div-login-lead-email .error-message').html(data.response);
          setTimeout(function(){ $('#div-login-lead-email').removeClass('has-error'); }, 3500);
        }
      }).catch(function(){
        $('#login-lead-result').html('Houve um erro ao enviar o seu login')
          .removeClass('alert-success')
          .addClass('alert-fail')
          .show('slow');
        setTimeout(function(){ $('#login-lead-result').hide('slow'); }, 3500);
      });
    }else{
      const data = {
        name: $('#login-lead-name').val(),
        email: $('#login-lead-email').val(),
        owner_id: '{{ $post->user_id }}'
      };
      $.post(registerLeadApiUrl, data).done(function(data){
        if(data.result){
          handleStorageLead(data.response);
          
          $('#login-lead-result').html('Cadastrado com Sucesso')
            .removeClass('alert-fail')
            .addClass('alert-success')
            .show('slow');

          $('#modalLoginLead').hide();
        }
        else{
          $('#login-lead-result').html(data.response)
            .removeClass('alert-success')
            .addClass('alert-fail')
            .show('slow');
          setTimeout(function(){ $('#login-lead-result').hide('slow'); }, 5500);
        }
      }).catch(function(){
        $('#login-lead-result').html('Houve um erro ao enviar o seu cadastro')
          .removeClass('alert-success')
          .addClass('alert-fail')
          .show('slow');
        setTimeout(function(){ $('#login-lead-result').hide('slow'); }, 5500);
      });
    }
  }

  function registerLead(){
    if($('#btn-login-lead-register').html() === 'Não sou cadastrado'){
      $('#btn-login-lead-register').html('x');
      $('#div-login-lead-name').removeClass('d-none');
      $('#login-lead-name').attr('required','required').focus();
      $('#modalLoginLead .btn-submit').html('Cadastrar');
    }else{
      $('#btn-login-lead-register').html('Não sou cadastrado');
      $('#div-login-lead-name').addClass('d-none');
      $('#login-lead-name').attr('required',undefined);
      $('#modalLoginLead .btn-submit').html('Entrar');
    }
  }

  function handleStorageLead(lead = null, refreshComments = true){
    if(lead){
      localStorage.setItem('@cms:postLead',JSON.stringify(lead));
      postLead = lead;
      $('#logged-with').html(`
        <span>logado com ${lead.email}</span>
        <button type="button" onclick="handleStorageLead()">x</button>
      `);
    }else{
      localStorage.setItem('@cms:postLead',null);
      postLead = null;
      $('#logged-with').html(`
        <a href="javascript:;" onclick="$('#modalLoginLead').show();">Faça login clicando aqui!</a>
      `);
    }
    if(refreshComments){
      $('.container-comments').html(`<p class="empty">Sem comentários...</p>`);
      loadComments();
    }
  }
  $(function(){
    handleStorageLead(JSON.parse(localStorage.getItem('@cms:postLead') ?? null) ?? null, false);
  });

</script>