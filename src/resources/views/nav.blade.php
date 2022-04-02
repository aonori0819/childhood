<nav class="navbar navbar-expand navbar-dark blue-gradient fixed-bottom">

    <a class="navbar-brand" href={{ url('/') }}><img src="/images/teddybear_small.svg" height="32px" > childhood</a>

    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/') }}"><i class="fas fa-home"></i></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('filters.index') }}"><i class="far fa-calendar-alt"></i></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('users.show', ['user' => Auth::user()]) }}"><i class="fas fa-user-circle"></i></a>
      </li>

    </ul>

  </nav>
