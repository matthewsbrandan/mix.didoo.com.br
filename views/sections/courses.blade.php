<section id="courses">
  <div class="header-courses" id="contato">
    <h1 class="text-center">{{ $courses->title->text ?? 'Nossos Cursos' }}</h1>
    <p>{{ $courses->description->text ?? '' }}</p>
  </div>
  <div>
    <div class="course-container">
      @foreach($courses->courses as $course)
        <div class="card-course">
          <img src="{{ $course->image }}"/>
          <div class="overlay"></div>
          <strong className="course-title">{{ $course->title }}</strong>
          <span className="course-value">{{ $course->value }}</span>
          <span className="course-description">{{ $course->description }}</span>
          <a href="#" target="_blank">Learn More</a>
        </div>
      @endforeach
    </div>

    <a
      href="#"
      target="_blank"
      class="general-button"
    >Learn More</a>
  </div>
</section>