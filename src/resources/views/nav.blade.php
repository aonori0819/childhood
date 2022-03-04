<nav class="navbar navbar-expand navbar-dark blue-gradient fixed-bottom">

    <a class="navbar-brand" href={{ url('/') }}><i class="fa-solid fa-otter"></i> childhood</a>

    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <a class="nav-link" href="{{ url('/') }}"><i class="fas fa-home"></i></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href=""><i class="far fa-calendar-alt"></i></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href=""><i class="fas fa-user-circle"></i></a>
      </li>

      <li class="nav-item">
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <input type="submit" value="&#xf2f5;" class="fas">
        </form>
      </li>

    </ul>

  </nav>
