<?php

return [
	'defaults' => [
        'guard' => env('AUTH_GUARD', 'api'),
    ],
	'guards' => [
        'session' => [
			'driver' => 'session',
			'provider' => 'eloquent'
		],
    ],
    'providers' => [
        'eloquent' => [
			'driver' => 'eloquent',
			'model' => 'App\Models\User',
		],
    ],
    'passwords' => [
        //
    ],
];