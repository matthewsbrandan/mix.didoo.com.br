<section id="footer" style="
  {{ (!isset($footer->image) || !$footer->image) && $footer->background ? 'background: '.$footer->background.'; ':'' }}
  {{ innerStyle('background-image', $footer->image) }}
  {{ $footer->text_color ? 'color: '.$footer->text_color.'; ':'' }}
">
  <div class="content">
    <div>
      <img src="{{ $footer->logo }}" alt="logo" class="logo"/>
      <hr/>
      <p class="texto" style="
        {{ innerStyleIssetAttr('font-size', $footer, 'description_length') }}
      ">{{ $footer->address }}</p>
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
    @if(
      isset($footer->email) || 
      isset($footer->whatsapp) || 
      isset($footer->facebook) || 
      isset($footer->instagram) || 
      isset($footer->youtube) || 
      isset($footer->twitter)
    )
      <div id="contato">
        <strong style="
          {{ innerStyleIssetAttr('font-size', $footer, 'title_length') }}
        ">FALE CONOSCO</strong>
        @isset($footer->whatsapp)
          <a href="tel: {{ $footer->whatsapp }}" target="_blank" style="
            {{ innerStyleIssetAttr('font-size', $footer, 'description_length') }}
          "><b>Whatsapp:</b> {{ $footer->whatsapp }}</a>
        @endisset
        @isset($footer->phone_fix)
          <a href="tel: {{ $footer->phone_fix }}" target="_blank" style="
            {{ innerStyleIssetAttr('font-size', $footer, 'description_length') }}
          "><b>Telefone:</b> {{ $footer->phone_fix }}</a>
        @endisset
        @isset($footer->phone_cel)
          <a href="tel: {{ $footer->phone_cel }}" target="_blank" style="
            {{ innerStyleIssetAttr('font-size', $footer, 'description_length') }}
          "><b>Celular:</b> {{ $footer->phone_cel }}</a>
        @endisset
        @isset($footer->email)
          <a href="mailto:{{ $footer->email }}" target="_blank" style="
            {{ innerStyleIssetAttr('font-size', $footer, 'description_length') }}
          "><b>Email:</b> {{ $footer->email }}</a>
        @endisset
        @isset($footer->email_2)
          <a href="mailto:{{ $footer->email_2 }}" target="_blank" style="
            {{ innerStyleIssetAttr('font-size', $footer, 'description_length') }}
          "><b>Email 2:</b> {{ $footer->email_2 }}</a>
        @endisset
        <div class="group-icons">
          @isset($footer->facebook)
            <a href="{{$footer->facebook}}" target="_blank">
              @include('utils.icons.facebook',['icons' => (object)[
                'color' => 'currentColor'
              ]])
            </a>
          @endisset
          @isset($footer->instagram)
            <a href="{{$footer->instagram}}" target="_blank">
              @include('utils.icons.instagram',['icons' => (object)[
                'color' => 'currentColor'
              ]])
            </a>
          @endisset
          @isset($footer->youtube)
            <a href="{{$footer->youtube}}" target="_blank">
              @include('utils.icons.youtube',['icons' => (object)[
                'color' => 'currentColor'
              ]])
            </a>
          @endisset
          @isset($footer->twitter)
            <a href="{{$footer->twitter}}" target="_blank">
              @include('utils.icons.twitter',['icons' => (object)[
                'color' => 'currentColor'
              ]])
            </a>
          @endisset
          @isset($footer->tiktok)
            <a href="{{$footer->tiktok}}" target="_blank">
              @include('utils.icons.tiktok',['icons' => (object)[
                'color' => 'currentColor'
              ]])
            </a>
          @endisset
          @isset($footer->pinterest)
            <a href="{{$footer->pinterest}}" target="_blank">
              @include('utils.icons.pinterest',['icons' => (object)[
                'color' => 'currentColor'
              ]])
            </a>
          @endisset
          @isset($footer->linkedin)
            <a href="{{$footer->linkedin}}" target="_blank">
              @include('utils.icons.linkedin',['icons' => (object)[
                'color' => 'currentColor'
              ]])
            </a>
          @endisset
          @isset($footer->behance)
            <a href="{{$footer->behance}}" target="_blank">
              @include('utils.icons.behance',['icons' => (object)[
                'color' => 'currentColor'
              ]])
            </a>
          @endisset
          @isset($footer->google_business)
            <a href="{{$footer->google_business}}" target="_blank">
              @include('utils.icons.google_business',['icons' => (object)[
                'color' => 'currentColor'
              ]])
            </a>
          @endisset
        </div>
      </div>
    @endif
  </div>
  <a class="developed-by" href="https://didoo.com.br" target="_blank">
    <img src="{{ asset('images/done-with.png') }}" alt="Feito com Didoo"/>
  </a>
  @isset($footer->whatsapp)
    <!-- LINK PARA CONVERSA NO WHATSAPP -->
    <a href="https://wa.me/{{ numberWhatsappFormat($footer->whatsapp) }}" target="_blank" class="button-whatsapp">
      @include('utils.icons.whatsapp',['icons' => (object)[
        'color' => 'currentColor'
      ]])
    </a>
  @endisset
  @if(isset($footer->overlay) && $footer->overlay)
    <div class="overlay" style="background: {{ $footer->overlay }}"></div>
  @endif
</section>