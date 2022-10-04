<section id="contact" style="
  @isset($contact)
    {{ innerStyleIssetAttr('background', $contact, 'background') }}
    {{ innerStyleIssetAttr('background-image', $contact, 'wallpaper') }}
    {{ innerStyleIssetAttr('color', $contact, 'text_color') }}
  @endisset
  @if(!isset($_GET['contato']))
    display: none;
  @endif
">
  <div class="container pt-5 pb-5" id="contato">
    <h1 class="text-center">Contato</h1>

    <div class="row mt-4">
      <div class="col-lg-6">
        <form method="post" id="form-contact">
          <div class="row">
            <div class="col-lg-12 form-group text-danger text-end mb-0" style="font-size: .9rem;">
              * Campos Obrigatórios
            </div>
            <div class="col-lg-12 form-group">
              <label for="nome">* Nome</label>
              <input type="text" name="nome" id="nome" class="form-control" required="">
            </div>
            <div class="col-lg-7 form-group">
              <label for="email">* E-mail</label>
              <input type="email" name="email" id="email" class="form-control" required="">
            </div>
            <div class="col-lg-5 form-group">
              <label for="telefone">* Telefone / Celular</label>
              <input type="text" name="telefone" id="telefone" class="form-control telefone" required="">
            </div>
            <div class="col-lg-12 form-group">
              <label for="assunto">* Assunto</label>
              <input type="text" name="assunto" id="assunto" class="form-control" required="">
            </div>
            <div class="col-lg-12 form-group">
              <label for="mensagem">* Mensagem</label>
              <textarea name="mensagem" id="mensagem" cols="4" class="form-control" required=""></textarea>
            </div>
            <div class="col-lg-12 form-group">
              <button
                type="submit"
                class="btn btn-danger btn-block btn-lg border-0 w-100 mt-4"
                style="
                  @if(isset($contact) && isset($contact->button))
                    {{ innerStyleIssetAttr('color',$contact->button,'color') }}
                    {{ innerStyleIssetAttr('background',$contact->button,'background') }}
                  @endif
                "
              >
                {{
                  isset($contact) && isset($contact->button) && isset($contact->text) ? 
                  $contact->text :
                  'Enviar Mensagem!'
                }}
              </button>
            </div>
          </div>
        </form>
      </div>

      <div class="col-lg-1 form-group"></div>

      <div class="col-lg-5 d-flex align-items-center">
        <div>
          <div class="mb-4">
            <strong class="text-uppercase">Contato</strong> <br>
            @isset($footer->whatsapp)
              <a href="tel: {{ $footer->whatsapp }}" target="_blank" style="
                {{ innerStyleIssetAttr('font-size', $footer, 'description_length') }}
              "><b>Whatsapp:</b> {{ $footer->whatsapp }}</a><br/>
            @endisset
            @isset($footer->phone_fix)
              <a href="tel: {{ $footer->phone_fix }}" target="_blank" style="
                {{ innerStyleIssetAttr('font-size', $footer, 'description_length') }}
              "><b>Telefone:</b> {{ $footer->phone_fix }}</a><br/>
            @endisset
            @isset($footer->phone_cel)
              <a href="tel: {{ $footer->phone_cel }}" target="_blank" style="
                {{ innerStyleIssetAttr('font-size', $footer, 'description_length') }}
              "><b>Celular:</b> {{ $footer->phone_cel }}</a><br/>
            @endisset
            @isset($footer->email)
              <a href="mailto:{{ $footer->email }}" target="_blank" style="
                {{ innerStyleIssetAttr('font-size', $footer, 'description_length') }}
              "><b>Email:</b> {{ $footer->email }}</a>
            @endisset

          </div>
          @if(
            isset($footer->facebook) ||
            isset($footer->instagram) ||
            isset($footer->twitter)
          )
            <div class="mb-4">
              <strong class="text-uppercase">Redes Sociais</strong>
              <div class="mt-1 icones-contato">
                @isset($footer->facebook)
                  <a href="{{ $footer->facebook }}" target="_blank">
                    <i class="fab fa-facebook fa-2x"></i>
                  </a>&nbsp; &nbsp; 
                @endisset
                @isset($footer->instagram)
                  <a href="{{ $footer->instagram }}" target="_blank">
                    <i class="fab fa-instagram fa-2x"></i>
                  </a> &nbsp; &nbsp; 
                @endisset
                @isset($footer->twitter)
                  <a href="{{ $footer->twitter }}" target="_blank">
                    <i class="fab fa-twitter fa-2x"></i>
                  </a> &nbsp; &nbsp;
                @endisset
              </div>
            </div>
          @endif
          <div class="mb-4">
            <strong class="text-uppercase">Onde Estamos</strong> <br>
            <p style="max-width: 18rem;">{{ $footer->address }}</p>
          </div>
          @if(isset($contact) &&
            isset($contact->opening_hours)
          )
            <div class="mb-4">
              <strong class="text-uppercase">Horário</strong> <br>
              <p style="max-width: 18rem;">{!! $contact->opening_hours !!}</p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>