<?php

namespace App\Models;

class Model extends \Illuminate\Database\Eloquent\Model
{
	const DATA_TYPE_INTEGER = 'integer';
	const DATA_TYPE_STRING = 'string';
	const DATA_TYPE_BOOLEAN = 'boolean';
	const DATA_TYPE_ARRAY = 'array';
	const DATA_TYPE_DATE = 'date';

	protected static $schema = [];

	protected $nullable = [];
	
	/**
	 * @param  array  $attributes
	 * @return void
	 */
	public function __construct(array $attributes = [])
	{
		$this->initSchema();

		parent::__construct($attributes);
	}

	public function initSchema()
	{
		if (!empty(static::$schema)) {
			foreach (static::$schema as $key => $data) {
				if (isset($data['type'])) {
					if ($data['type'] === static::DATA_TYPE_DATE) {
						$this->dates[] = $key;
					} else {
						$this->casts[$key] = $data['type'];
					}
				}

				if (isset($data['nullable']) && $data['nullable'] === true) {
					$this->nullable[] = $key;
				}

				if (isset($data['default'])) {
					$this->setAttribute($key, $data['default']);
				}

				if (
					isset($data['fillable'])
					&& $data['fillable'] === true
					&& !in_array($key, $this->fillable, true)
				) {
					$this->fillable[] = $key;
				}
			}
		}
	}

	/**
	 * @param  string  $key
	 * @param  mixed  $value
	 * @return $this
	 */
	public function setAttribute($key, $value)
	{
		$result = parent::setAttribute($key, $value);

		if (in_array($key, $this->nullable, true) && is_string($value) && trim($value) === '') {
			$this->attributes[$key] = null;
		}

		return $result;
	}
}