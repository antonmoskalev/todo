@extends('layouts.main')

@section('title', 'Регистрация')

@section('content')
	<div class="box">
		<h1>Регистрация</h1>
		
		<form id="signup-form" action="{!!route('user/signup')!!}" method="post">
			<div class="mb20">
				<label class="form-label">E-mail</label>
				<input type="text" name="email" class="form-input" />
			</div>
			<div class="mb20">
				<label class="form-label">Пароль</label>
				<input type="password" name="password" id="password" class="form-input" />
			</div>
			<div class="mb20">
				<label class="form-label">Повторите пароль</label>
				<input type="password" name="same_password" class="form-input" />
			</div>
			<div>
				<button type="submit" class="btn">Зарегистрироваться</button>
				<a href="{!!route('user/viewSignin')!!}" class="ml20">Авторизация</a>
			</div>
		</form>
	</div>
@endsection