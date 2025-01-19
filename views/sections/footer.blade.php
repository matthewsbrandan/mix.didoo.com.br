<section id="footer" style="
  {{ (!isset($footer->image) || !$footer->image) && $footer->background ? 'background: '.$footer->background.'; ':'' }}
  {{ innerStyle('background-image', $footer->image) }}
  {{ $footer->text_color ? 'color: '.$footer->text_color.'; ':'' }}
">
  <div class="content">
    <div>
      <a href="{{ route('home') }}">
        <img src="{{ $footer->logo }}" alt="logo" class="logo"/>
      </a>
      @isset($code->address)
        <p class="texto mt-3" style="
          {{ innerStyleIssetAttr('font-size', $footer, 'description_length') }}
        ">{{ $code->address }}</p>
      @endisset
    </div>
    <div>
      <strong style="
        {{ innerStyleIssetAttr('font-size', $footer, 'title_length') }}
      ">ACESSO RÁPIDO</strong>
      <ul>
        @include('layout.header-list',['header_list_config' => (object)[
          'style' => innerStyleIssetAttr('font-size', $footer, 'description_length')
        ]])
        <li>
          <a href="{{ route('privacy.policy') }}" target="_blank" style="
            {{ innerStyleIssetAttr('font-size', $footer, 'description_length') }}
          ">Política de Privacidade</a>
        </li>
      </ul>
    </div>
    @php
      $hasSocialNetworl = (
        isset($code->facebook) ||
        isset($code->instagram) ||
        isset($code->youtube) ||
        isset($code->twitter) ||
        isset($code->tiktok) ||
        isset($code->pinterest) ||
        isset($code->linkedin) ||
        isset($code->behance) ||
        isset($code->google_business)
      );
    @endphp
    @if(
      isset($code->whatsapp) || 
      isset($code->phone_fix) ||
      isset($code->phone_cel) ||
      isset($code->email) || 
      isset($code->email_2) || 
      $hasSocialNetworl
    )
      <div id="fale-conosco">
        <strong style="
          {{ innerStyleIssetAttr('font-size', $footer, 'title_length') }}
        ">FALE CONOSCO</strong>
        @isset($code->whatsapp)
          <a href="tel: {{ numberWhatsappFormat($code->whatsapp) }}" target="_blank" style="
            {{ innerStyleIssetAttr('font-size', $footer, 'description_length') }}
          "><b>Whatsapp:</b> {{ numberPhoneFormat($code->whatsapp) }}</a>
        @endisset
        @isset($code->phone_fix)
          <a href="tel: {{ numberWhatsappFormat($code->phone_fix) }}" target="_blank" style="
            {{ innerStyleIssetAttr('font-size', $footer, 'description_length') }}
          "><b>Telefone:</b> {{ numberPhoneFormat($code->phone_fix) }}</a>
        @endisset
        @isset($code->phone_cel)
          <a href="tel: {{ numberWhatsappFormat($code->phone_cel) }}" target="_blank" style="
            {{ innerStyleIssetAttr('font-size', $footer, 'description_length') }}
          "><b>Celular:</b> {{ numberPhoneFormat($code->phone_cel) }}</a>
        @endisset
        @isset($code->email)
          <a href="mailto:{{ $code->email }}" target="_blank" style="
            {{ innerStyleIssetAttr('font-size', $footer, 'description_length') }}
          "><b>Email:</b> {{ $code->email }}</a>
        @endisset
        @isset($code->email_2)
          <a href="mailto:{{ $code->email_2 }}" target="_blank" style="
            {{ innerStyleIssetAttr('font-size', $footer, 'description_length') }}
          "><b>Email 2:</b> {{ $code->email_2 }}</a>
        @endisset
        @if($hasSocialNetworl)
          <div class="group-icons">
            @isset($code->facebook)
              <a href="{{$code->facebook}}" target="_blank">
                @include('utils.icons.facebook',['icons' => (object)[
                  'color' => 'currentColor'
                ]])
              </a>
            @endisset
            @isset($code->instagram)
              <a href="{{$code->instagram}}" target="_blank">
                @include('utils.icons.instagram',['icons' => (object)[
                  'color' => 'currentColor'
                ]])
              </a>
            @endisset
            @isset($code->youtube)
              <a href="{{$code->youtube}}" target="_blank">
                @include('utils.icons.youtube',['icons' => (object)[
                  'color' => 'currentColor'
                ]])
              </a>
            @endisset
            @isset($code->twitter)
              <a href="{{$code->twitter}}" target="_blank">
                @include('utils.icons.twitter',['icons' => (object)[
                  'color' => 'currentColor'
                ]])
              </a>
            @endisset
            @isset($code->tiktok)
              <a href="{{$code->tiktok}}" target="_blank">
                @include('utils.icons.tiktok',['icons' => (object)[
                  'color' => 'currentColor'
                ]])
              </a>
            @endisset
            @isset($code->pinterest)
              <a href="{{$code->pinterest}}" target="_blank">
                @include('utils.icons.pinterest',['icons' => (object)[
                  'color' => 'currentColor'
                ]])
              </a>
            @endisset
            @isset($code->linkedin)
              <a href="{{$code->linkedin}}" target="_blank">
                @include('utils.icons.linkedin',['icons' => (object)[
                  'color' => 'currentColor'
                ]])
              </a>
            @endisset
            @isset($code->behance)
              <a href="{{$code->behance}}" target="_blank">
                @include('utils.icons.behance',['icons' => (object)[
                  'color' => 'currentColor'
                ]])
              </a>
            @endisset
            @isset($code->google_business)
              <a href="{{$code->google_business}}" target="_blank">
                @include('utils.icons.google_business',['icons' => (object)[
                  'color' => 'currentColor'
                ]])
              </a>
            @endisset
          </div>
        @endif
      </div>
    @endif
  </div>
  <a class="developed-by" href="https://didoo.com.br" target="_blank">
    <img src="{{ asset('images/done-with.png') }}" alt="Feito com Didoo"/>
  </a>
  @if(isset($menu) && isset($menu->mode_link_phone) && $menu->mode_link_phone === 'Exibir botão flutuante no site' && isset($code->whatsapp))
    <!-- LINK PARA CONVERSA NO WHATSAPP -->
    <a href="https://wa.me/{{ numberWhatsappFormat($code->whatsapp) }}" target="_blank" class="button-whatsapp">
      @include('utils.icons.whatsapp',['icons' => (object)[
        'color' => 'currentColor'
      ]])
    </a>
  @endisset
  @if(isset($footer->overlay) && $footer->overlay)
    <div class="overlay" style="background: {{ $footer->overlay }}"></div>
  @endif
</section>