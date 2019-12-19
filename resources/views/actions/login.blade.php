@php //$base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/'; @endphp

@extends('layout.app')

@section('title', 'Login')

@section('content')
<div class="col-lg-12">
    <div class="p-5">
@if (Session::has('message'))
   <div class="alert alert-danger">{{ Session::get('message') }}</div>
@endif
        <form class="user" method="POST" action="/login">
            @csrf
            <div class="form-group">
                <input name="email" autocomplete="false" type="email" class="form-control form-control-user" id="email"
                    aria-describedby="emailHelp" placeholder="Email">
                <small class="text-danger">{{ $errors->first('email') }}</small>
            </div>
            <div class="form-group">
                <input name="password" type="password" class="form-control form-control-user" id="password"
                    placeholder="Password">
                <small class="text-danger">{{ $errors->first('password') }}</small>
            </div>
            <button class="btn btn-primary btn-user btn-block">Login</button>
            <a href="{{ url('redirect') }}" class="btn btn-info btn-block">Login With Google</a>
        </form>
    </div>
</div>
@endsection
