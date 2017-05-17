@extends('layouts.main')

@section('title', 'Авторизация')

@section('content')
	<div class="box">
		<h1>Авторизация</h1>
		
		<form id="signin-form" action="{!!route('user/signin')!!}" method="post">
			<div class="mb20">
				<label class="form-label">E-mail</label>
				<input type="text" name="email" class="form-input" />
			</div>
			<div class="mb20">
				<label class="form-label">Пароль</label>
				<input type="password" name="password" class="form-input" />
			</div>
			<div class="mb20">
				<input type="hidden" name="remember" value="0" />
				<label class="form-label">
					<input type="checkbox" name="remember" value="1" />
					Запомнить меня
				</label>
			</div>
			<div>
				<button type="submit" class="btn">Войти</button>
				<a href="{!!route('user/viewSignup')!!}" class="ml20">Регистрация</a>
			</div>
		</form>
	</div>
@endsection