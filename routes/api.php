<?php

use Illuminate\Support\Facades\Route;

Route::fallback('API\dashboard\V1\AuthController@NotFound');
