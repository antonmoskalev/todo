<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Todo;
use Illuminate\Http\Request;
use Validator;

class TodoController extends Controller
{
	public function index()
	{
		$user = Auth::user();
		$todos = $user->todos;
		
		return view('todo.index', compact('todos'));
	}
	
	public function viewCreate()
	{
		return view('todo.view');
	}
	
	public function viewUpdate()
	{
		return view('todo.view');
	}
	
	public function create(Request $request)
	{
		$todo = new Todo();
		
		return $this->save($request, $todo);
	}
	
	public function read($id)
	{
		$todo = Todo::findOrFail($id);
		
		if (!$todo->hasAccess(Auth::user())) {
			return respone()->json([], 403);
		}
		
		return response()->json(collect([
			'todo' => $todo,
			'items' => $todo->items()->get(),
		]));
	}
	
	public function update(Request $request, $id)
	{
		$todo = Todo::findOrFail($id);
		
		if (!$todo->hasAccess(Auth::user())) {
			return respone()->json([], 403);
		}
		
		return $this->save($request, $todo);
	}
	
	protected function save(Request $request, Todo $todo)
	{
		$input = $request->only('name');
		$rules = [
			'name' => 'max:255',
		];
		$validator = Validator::make($input, $rules);
		
		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}
		
		$user = Auth::user();
		$todo->name = $input['name'];
		$user->todos()->save($todo);
		
		return response(collect([
			'todo' => $todo,
		]));
	}
}