@php //$base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/'; @endphp
@php //$base_url = 'http://localhost:8000/'; @endphp

<!DOCTYPE html>
<html lang = "en">

<head>
    <title> Laravel Inventory : @yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="{{ url('css/app.css') }}" rel="stylesheet" type="text/css">
</head>

<body id="page-top">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="{{ url('') }}">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  @if (Auth::check())
  <div class="collapse navbar-collapse text-right" id="navbarNav">
    <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
    <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      {{--
        {{Auth::user()->email}}:
      --}}
      {{Cache::get('userMail')}}::{{Auth::user()->role}}
    @endif
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ url('addItems') }}">Add Item</a>
        @if (Auth::check())
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ url('logout') }}">Logout</a>
        @endif
    </div>
    </li>
    </ul> 
  </div>
</nav>

<!-- content -->
<div class="container">
    @yield('content')

</div>




<!-- Bootstrap core JavaScript-->
<script src="{{ url('js/jquery.min.js') }}"></script>
<script src="{{ url('js/popper.min.js') }}"></script>
<script src="{{ url('js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>