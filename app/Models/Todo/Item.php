<?php

namespace App\Models\Todo;

use App\Models\Todo;

/**
 * @property integer $id
 * @property integer $todo_id
 * @property string $description
 * @property boolean $completed
 * 
 * @property Todo $todo
 */
class Item extends \App\Models\Model
{
	protected static $schema = [
		'id' => [
			'type' => self::DATA_TYPE_INTEGER,
		],
		'todo_id' => [
			'type' => self::DATA_TYPE_INTEGER,
		],
		'description' => [
			'type' => self::DATA_TYPE_STRING,
		],
		'completed' => [
			'type' => self::DATA_TYPE_BOOLEAN,
			'default' => false,
		],
	];
	
	protected $table = 'todo_items';
	public $timestamps = false;
	
	public function todo()
	{
		return $this->belongsTo(Todo::class);
	}
}