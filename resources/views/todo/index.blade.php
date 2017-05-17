@extends('layouts.main')

@section('content')
	<div class="mb20">
		<a href="{!!route('todo/viewCreate')!!}" class="btn btn-block">Создать список</a>
	</div>

	@forelse ($todos as $todo)
		<div class="mb5">
			<a href="{!!route('todo/viewUpdate', ['id' => $todo->id])!!}" class="todo-button">{{$todo->name}}</a>
		</div>
	@empty
		<div>Нет списков...</div>
	@endforelse
@endsection