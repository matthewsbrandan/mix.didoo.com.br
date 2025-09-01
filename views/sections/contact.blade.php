<section id="contact" style="
  {{ innerStyleIssetAttr('background', $contact, 'background') }}
  {{ innerStyleIssetAttr('background-image', $contact, 'wallpaper') }}
  {{ innerStyleIssetAttr('color', $contact, 'color') }}
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
            <div class="col-lg-12 form-group text-danger text-end mb-0" style="
              font-size: .9rem;
              @isset($contact->button)
                {{ innerStyleIssetAttr('color',$contact->button,'background', null, null, true) }}
              @endisset
            ">
              * Campos Obrigatórios
            </div>
            <div class="col-lg-12 form-group">
              <label for="name">* Nome</label>
              <input
                type="text"
                name="name"
                id="contact-name"
                class="form-control"
                required
              />
            </div>
            <div class="col-lg-7 form-group">
              <label for="email">* E-mail</label>
              <input
                type="email"
                name="email"
                id="contact-email"
                class="form-control"
                required
              />
            </div>
            <div class="col-lg-5 form-group">
              <label for="phone">* Telefone / Celular</label>
              <input
                type="text"
                name="phone"
                id="contact-phone"
                class="form-control telefone"
                required
              />
            </div>
            <div class="col-lg-12 form-group">
              <label for="subject">* Assunto</label>
              <input
                type="text"
                name="subject"
                id="contact-subject"
                class="form-control"
                required
              />
            </div>
            <div class="col-lg-12 form-group">
              <label for="message">* Mensagem</label>
              <textarea
                name="message"
                id="contact-message"
                cols="4"
                class="form-control"
                required
              ></textarea>
            </div>
            <div class="col-lg-12 form-group">
              <button
                type="submit"
                class="btn btn-danger btn-block btn-lg border-0 w-100 mt-4"
                style="
                  @isset($contact->button)
                    {{ innerStyleIssetAttr('color',$contact->button,'color') }}
                    {{ innerStyleIssetAttr('background',$contact->button,'background') }}
                  @endisset
                "
              >
                {{ isset($contact->button) && isset($contact->button->text) ? 
                  $contact->button->text :
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
            @isset($code->whatsapp)
              <a href="tel: {{ numberWhatsappFormat($code->whatsapp) }}" target="_blank" style="
                {{ innerStyleIssetAttr('font-size', $code, 'description_length') }}
              "><b>Whatsapp:</b> {{ numberPhoneFormat($code->whatsapp) }}</a><br/>
            @endisset
            @isset($code->phone_fix)
              <a href="tel: {{ numberWhatsappFormat($code->phone_fix) }}" target="_blank" style="
                {{ innerStyleIssetAttr('font-size', $code, 'description_length') }}
              "><b>Telefone:</b> {{ numberPhoneFormat($code->phone_fix) }}</a><br/>
            @endisset
            @isset($code->phone_cel)
              <a href="tel: {{ numberWhatsappFormat($code->phone_cel) }}" target="_blank" style="
                {{ innerStyleIssetAttr('font-size', $code, 'description_length') }}
              "><b>Celular:</b> {{ numberPhoneFormat($code->phone_cel) }}</a><br/>
            @endisset
            @isset($code->email)
              <a href="mailto:{{ $code->email }}" target="_blank" style="
                {{ innerStyleIssetAttr('font-size', $code, 'description_length') }}
              "><b>Email:</b> {{ $code->email }}</a>
            @endisset

          </div>
          @if(
            isset($code->facebook) ||
            isset($code->instagram) ||
            isset($code->twitter)
          )
            <div class="mb-4">
              <strong class="text-uppercase">Redes Sociais</strong>
              <div class="mt-1 icones-contato">
                @isset($code->facebook)
                  <a href="{{ $code->facebook }}" target="_blank">
                    <i class="fab fa-facebook fa-2x"></i>
                  </a>&nbsp; &nbsp; 
                @endisset
                @isset($code->instagram)
                  <a href="{{ $code->instagram }}" target="_blank">
                    <i class="fab fa-instagram fa-2x"></i>
                  </a> &nbsp; &nbsp; 
                @endisset
                @isset($code->twitter)
                  <a href="{{ $code->twitter }}" target="_blank">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      role="img"
                      aria-labelledby="iconTwitterTitle"
                      version="1.1" id="X-_icon" x="0px" y="0px" viewBox="4 4 24 24"
                      width="24" height="24"
                    >
                      <g style="fill: currentColor;">
                        <polygon points="14.202 16.292 14.788 17.15 9.241 23.58 7.91 23.58" style=""/>
                        <polygon points="22.968 7.672 17.028 14.559 16.437 13.7 21.641 7.672" style=""/>
                        <path d="M 12.369 8.509 L 22.132 22.743 L 19.133 22.743 L 9.37 8.509 L 12.369 8.509 M 12.809 7.672 L 7.78 7.672 L 18.692 23.58 L 23.722 23.58 L 12.809 7.672 Z" style=""/>
                      </g>
                    </svg>
                  </a> &nbsp; &nbsp;
                @endisset
                @isset($code->youtube)
                  <a href="{{ $code->youtube }}" target="_blank">
                    <i class="fab fa-youtube fa-2x"></i>
                  </a> &nbsp; &nbsp;
                @endisset
                @isset($code->tiktok)
                  <a href="{{ $code->tiktok }}" target="_blank">
                    <i class="fab fa-tiktok fa-2x"></i>
                  </a> &nbsp; &nbsp;
                @endisset
              </div>
            </div>
          @endif
          @isset($code->address)          
            <div class="mb-4">
              <strong class="text-uppercase">Onde Estamos</strong> <br>
              <p style="max-width: 18rem;">{{ $code->address }}</p>
            </div>
          @endisset
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