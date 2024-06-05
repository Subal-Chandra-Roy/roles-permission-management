<nav class="navbar navbar-expand-lg navbar-light bg-light shadow sticky-top">
  <div class="container fluid">
    <div class="d-flex  justify-content-between">
      <a class="navbar-brand" href="{{url('/')}}">Home</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        @guest
        <li class="nav-item">
          <a class="nav-link fw-bold" href="{{url('/login')}}">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-bold" href="{{url('/register')}}">Register</a>
        </li>
        @else
        <li class="nav-item dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ Auth::user()->name }}
          </button>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
            </li>
            <li>
              <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); 
                                            this.closest('form').submit();">
                  Logout
                </a>
              </form>
            </li>
          </ul>
        </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>