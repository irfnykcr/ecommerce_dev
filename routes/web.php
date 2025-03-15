<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
Route::get('/category/{catg?}', function (?string $catg = null) {
	return view('category', ["category"=>$catg]);
});
