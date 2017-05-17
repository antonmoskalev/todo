<?php

namespace App\Models;

use App\Models\Todo\Item;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * 
 * @property User $user
 * @property Item[] $items
 */
class Todo extends Model
{
	protected static $schema = [
		'id' => [
			'type' => self::DATA_TYPE_INTEGER,
		],
		'user_id' => [
			'type' => self::DATA_TYPE_INTEGER,
		],
		'name' => [
			'type' => self::DATA_TYPE_STRING,
			'nullable' => true,
		],
	];
	
	public $timestamps = false;
	
	public function getNameAttribute($value)
	{
		return (!empty($value)) ? $value : 'Без названия';
	}
	
	public function user()
	{
		return $this->belongsTo(User::class);
	}
	
	public function items()
	{
		return $this->hasMany(Item::class);
	}
	
	public function hasAccess(User $user)
	{
		return $this->user_id === $user->id;
	}
}