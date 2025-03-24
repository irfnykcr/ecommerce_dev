<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\products;
use App\Http\Controllers\users;
use App\Http\Middleware\JwtAuth;

Route::post("/account/register", [users::class, 'register']);
Route::post("/account/login", [users::class, 'login']);
Route::post("/account/updateInfo", [users::class, 'updateInfo'])->middleware(JwtAuth::class);

Route::post("/admin/insertProduct", [products::class, 'insertProduct'])->middleware(JwtAuth::class);
Route::post("/admin/editProduct", [products::class, 'editProduct'])->middleware(JwtAuth::class);
Route::post("/admin/getOrders_wPage", [products::class, 'getOrders_wPage'])->middleware(JwtAuth::class);
Route::post("/admin/getOrderedItems_Order_id", [products::class, 'getOrderedItems_Order_id'])->middleware(JwtAuth::class);

// 0 = cancelled
// 1 = completed
// 2 = processing
// 3 = shipped

// 0 = disabled
// 1 = active
// 2 = out of stock

Route::get('/', function (Request $request) {
    return view('index');
});
Route::get('/category/{catg?}', function (?string $catg = null) {
	return view('category', ["category"=>$catg]);
});

Route::get('/account/login', function (Request $request) {
	if ($request->cookie("firebase_token") || $request->session()->get("fbase_uid")){
		return redirect("/account");
	}
	return view('account.login');
});

Route::get('/account/logout', function (Request $request) {
	session()->forget("fbase_uid");
	return redirect("/account/login")->cookie('firebase_token', '', -1);
});

Route::middleware([JwtAuth::class])->group(function () {
	// User account 
	Route::get('/account', function (Request $request) {
		$fbase_uid = $request->session()->get("fbase_uid");
		$info = DB::table("users")
			->where("fbase_uid", $fbase_uid)
			->first(["user_id", "email", "full_name", "phone_number"]);
		$info = json_decode(json_encode($info), true);
		$user_id = $info["user_id"];

		$adresses = DB::table("adresses")
			->where("user_id", $user_id)
			->get(["adress_id", "user_id", "adres_baslik", "adres", "adres_extra", "ulke", "il", "ilce"]);
		$adresses = json_decode(json_encode($adresses), true);
		return view('account.index', ["info"=>$info, "adresses"=>$adresses]);
	});

	//admin panel
	Route::get('/admin', function (Request $request) {
		$productsController = new products();
	
		$categories = $productsController->getCategories();
		$get_sales_info_recent = $productsController->getSalesInfo();
		$sales_info = $get_sales_info_recent[0];
		$recent = $get_sales_info_recent[1];
		$items_soldinfo = $productsController->getItems_soldinfo();
	
		return view('admin.index', ["categories"=>$categories,"sales_info"=>$sales_info, "recent"=>$recent, "items_soldinfo"=>$items_soldinfo]);
	});
	Route::get('/admin/orders', function (Request $request) {
		$productsController = new products();
	
		$get_sales_info_recent = $productsController->getSalesInfo();
		$sales_info = $get_sales_info_recent[0];
		$recent = $get_sales_info_recent[1];
		$orders_length = round($get_sales_info_recent[2] / 10, 0);
	
		return view('admin.orders', ["sales_info"=>$sales_info, "recent"=>$recent, "orders_length"=>$orders_length]);
	});
	Route::get('/admin/products', function (Request $request) {
		$productsController = new products();
	
		$products = DB::table('items')->get();
		$products = json_decode(json_encode($products), true);
	
		$categories = $productsController->getCategories();
	
		return view('admin.products', ["products"=>$products, "categories"=>$categories]);
	});
});



