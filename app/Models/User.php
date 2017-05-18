<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * @property integer $id
 * @property string $email
 * @property string $password_hash
 * @property string $remember_token
 * @property boolean $confirmed
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property Todo[] $todos
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;
	
	protected static $schema = [
		'id' => [
			'type' => self::DATA_TYPE_INTEGER,
		],
		'email' => [
			'type' => self::DATA_TYPE_STRING,
		],
		'password_hash' => [
			'type' => self::DATA_TYPE_STRING,
		],
		'remember_token' => [
			'type' => self::DATA_TYPE_STRING,
			'nullable' => true,
		],
		'confirmed' => [
			'type' => self::DATA_TYPE_BOOLEAN,
			'default' => false,
		],
		'name' => [
			'type' => self::DATA_TYPE_STRING,
			'nullable' => true,
		],
		'created_at' => [
			'type' => self::DATA_TYPE_DATE,
		],
		'updated_at' => [
			'type' => self::DATA_TYPE_DATE,
		],
	];
	
	public function todos()
	{
		return $this->hasMany(Todo::class);
	}
	
	public function getAuthPassword()
    {
        return $this->password_hash;
    }
}