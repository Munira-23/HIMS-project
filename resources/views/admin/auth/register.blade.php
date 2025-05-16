@extends('admin.layouts.plain')

@section('content')
<div class="register-body">
    <div class="register-wrapper">
        <div class="registerbox">
<h1>Hospital Inventory Management System</h1> 
<p class="account-subtitle">Register Here</p>
<!-- Visit codeastro.com for more projects -->
<!-- Form -->
<form action="{{route('register')}}" method="POST">
	@csrf
	<div class="form-group">
		<input class="form-control" name="name" type="text" value="{{old('name')}}" placeholder="Full Name">
	</div>
	<div class="form-group">
		<input class="form-control" name="email" type="text" value="{{old('email')}}" placeholder="Email">
	</div>
	<div class="form-group">
		<input class="form-control" name="password" type="password" placeholder="Password">
	</div>
	<div class="form-group">
		<input class="form-control" name="password_confirmation" type="password" placeholder="Confirm Password">
	</div>
	<div class="form-group mb-0">
		<button class="button" type="submit" style="background-color:#4682B4; color: white; padding: 10px; border: none; text-align: center ; ">Register</button>
	</div>
</form>
<!-- /Form -->
								
<div class="text-center dont-have">Already have an account? <a href="{{route('login')}}">Login</a></div>
@endsection