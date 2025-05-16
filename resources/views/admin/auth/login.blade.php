@extends('admin.layouts.plain')

@section('content')
<h1>Hospital Inventory Management System</h1>
<p class="account-subtitle">Login Panel</p>
@if (session('login_error'))
<x-alerts.danger :error="session('login_error')" />
<img src="logo.png" alt="hospital inventory"> 
@endif

<!-- Form -->
<form action="{{route('login')}}" method="post">
	@csrf
	<div class="form-group">
		<input class="form-control" name="email" type="text" placeholder="Email">
	</div>
	<div class="form-group">
		<input class="form-control" name="password" type="password" placeholder="Password">
	</div>
	<div class="form-group">
	<button class="button" type="submit" style="background-color:#4682B4; color: white; padding: 10px; border: none; text-align: center ; ">Login</button>
	</div>
</form>
<!-- /Form -->

<!-- Visit codeastro.com for more projects -->

<div class="text-center forgotpass"><a href="{{route('password.request')}}">Forgot Password?</a></div>
<div class="text-center dont-have">Don’t have an account? <a href="{{route('register')}}">Register</a></div>
@endsection