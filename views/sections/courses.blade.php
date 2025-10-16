<section id="courses">
  <div class="header-courses" style="{{ innerStyleIssetAttr('background', $courses, 'header_bg') }}">
    <h1 style="{{ innerStyleIssetAttr('color', $courses->title, 'color') }}">{{ $courses->title->text ?? 'Nossos Cursos' }}</h1>
    <p style="{{ innerStyleIssetAttr('color', $courses->description, 'color') }}">{{ $courses->description->text ?? '' }}</p>
  </div>
  <div>
    <div class="course-container">
      @foreach($courses->courses as $course)
        <div class="card-course">
          <img src="{{ $course->image }}"/>
          <div class="overlay"></div>
          <div class="content">
            <strong
              class="course-title"
              style="{{ innerStyleIssetAttr('color', $courses, 'course_title_color') }}"
            >{{ $course->title }}</strong>
            <span
              class="course-value"
              style="{{ innerStyleIssetAttr('color', $courses, 'course_value_color') }}"
            >R$ {{ number_format($course->value,2,',','.') }}</span>
            <span
              class="course-description"
              style="{{ innerStyleIssetAttr('color', $courses, 'course_description_color') }}"
            >{{ $course->description }}</span>
            <a
              href="{{ $course->btn_link ?? '#' }}"
              target="_blank"
              style="
                {{ innerStyleIssetAttr('background', $courses->course_btn_learn_more, 'background') }}
                {{ innerStyleIssetAttr('color', $courses->course_btn_learn_more, 'color') }}
              "
            >{{ $courses->course_btn_learn_more->text ?? 'Ver mais' }}</a>
          </div>
        </div>
      @endforeach
    </div>

    @if(isset($courses->general_learn_more) && isset($courses->general_learn_more->link))
      <div class="course-footer">
        <a
          href="{{ $courses->general_learn_more->link ?? '#'}}"
          target="_blank"
          class="general-button"
          style="
            border: 1px solid black;
            {{ innerStyleIssetAttr('border-color', $courses->general_learn_more, 'border') }}
            {{ innerStyleIssetAttr('background', $courses->general_learn_more, 'background') }}
            {{ innerStyleIssetAttr('color', $courses->general_learn_more, 'color') }}
          "
        >{{ $courses->general_learn_more->text }}</a>
      </div>
    @endif
  </div>
</section>