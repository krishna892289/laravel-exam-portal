<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="">ExamPortal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-iitem">
                    <a class="nav-link active" aria-current="page" href="{{ route('dashboards') }}">Dashboard</a>
                </li>
                @auth
                    @if (auth()->user()->role == '1')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Questions
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('add_questions') }}">Add Questions</a></li>
                                <li><a class="dropdown-item" href="{{ route('view_questions') }}">View Questions</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Tests
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('assign_tests') }}">Assign Tests</a></li>
                                <li><a class="dropdown-item" href="{{ route('view_tests') }}">View Tests</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Categories
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('add_category') }}">Add Category</a></li>
                                <li><a class="dropdown-item" href="{{ route('view_categories') }}">View Category</a></li>
                            </ul>
                        </li>
                    @elseif (auth()->user()->role == '2')
                    @endif
                @endauth
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">New Registration</a>
                    </li>
                @endguest

            </ul>

            @auth
                <form action="{{ route('logout') }}" method="POST" class="d-flex ms-auto">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">Logout</button>
                </form>
            @endauth

        </div>
    </div>
</nav>
