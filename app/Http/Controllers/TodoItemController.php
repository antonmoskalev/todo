<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo\Item;
use Validator;
use Auth;

class TodoItemController extends Controller
{
	public function create(Request $request)
	{
		$item = new Item();
		
		return $this->save($request, $item);
	}
	
	public function update(Request $request, $id)
	{
		$item = Item::findOrFail($id);
		
		return $this->save($request, $item);
	}
	
	protected function save(Request $request, Item $item)
	{
		$input = $request->only('todo_id', 'description', 'completed');
		$rules = [
			'todo_id' => ['required', 'exists:todos,id,user_id,'.Auth::user()->id],
			'description' => ['required', 'max:255'],
			'completed' => ['boolean'],
		];
		$validator = Validator::make($input, $rules);
		
		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}
		
		$item->todo_id = $input['todo_id'];
		$item->description = $input['description'];
		$item->completed = $input['completed'];
		$item->save();
		
		return response()->json(collect([
			'item' => $item,
		]));
	}
	
	public function delete($id)
	{
		$item = Item::findOrFail($id);
		
		if (!$item->todo->hasAccess(Auth::user())) {
			return respone()->json([], 403);
		}
		
		$item->delete();
		
		return response()->json([]);
	}
}