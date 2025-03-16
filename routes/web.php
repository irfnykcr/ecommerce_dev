<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\products;

Route::post("/admin/insertProduct", [products::class, 'insertProduct']);

function getCategories(){
	return ["hoodie", "sweat", "shirt"];
}
	

Route::get('/', function () {
    return view('index');
});
Route::get('/category/{catg?}', function (?string $catg = null) {
	return view('category', ["category"=>$catg]);
});

Route::get('/admin', function () {
	return view('admin.index');
});
Route::get('/admin/orders', function () {
	return view('admin.orders');
});
Route::get('/admin/products', function () {
	$products = DB::table('items')->get();
	$products = json_decode(json_encode($products), true);
	return view('admin.products', ["products"=>$products, "categories"=>getCategories()]);
});
