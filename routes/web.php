<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\products;
use Illuminate\Support\Facades\DB;

Route::post("/admin/insertProduct", [products::class, 'insertProduct']);
Route::post("/admin/getOrders_wPage", [products::class, 'getOrders_wPage']);

// 0 = cancelled
// 1 = completed
// 2 = processing
// 3 = shipped
function getSalesInfo(){
	$r = DB::table("orders")->get(["id", "user_id", "total_price", "status", "payment", "created_at"]);
	$r = json_decode($r,true);
	$info = ["today"=>[], "this_week"=>[], "this_month"=>[], "this_year"=>[]];
	// $info = ["total_sales"=> array_sum(array_column($r, 'total_price')), "orders"=>count($r), "customers"=>5, "conversion_rate"=>3.6];
	// Get current date and time
	$now = new DateTime();
	// $today = $now->format('Y-m-d');
	$startOfWeek = (new DateTime())->modify('monday this week')->format('Y-m-d');
	$startOfLastWeek = (new DateTime())->modify('monday last week')->format('Y-m-d');
	$endOfLastWeek = (new DateTime())->modify('sunday last week')->format('Y-m-d');
	$startOfMonth = (new DateTime())->modify('first day of this month')->format('Y-m-d');
	$startOfLastMonth = (new DateTime())->modify('first day of last month')->format('Y-m-d');
	$endOfLastMonth = (new DateTime())->modify('last day of last month')->format('Y-m-d');
	$startOfYear = (new DateTime())->modify('first day of january this year')->format('Y-m-d');
	$startOfLastYear = (new DateTime())->modify('first day of january last year')->format('Y-m-d');
	$endOfLastYear = (new DateTime())->modify('last day of december last year')->format('Y-m-d');

	// Initialize all periods
	$info = [
		// "today" => [],
		"this_week" => [],
		"last_week" => [],
		"this_month" => [],
		"last_month" => [],
		"this_year" => [],
		"last_year" => []
	];

	// Process each order
	foreach ($r as $order) {
		$orderDate = substr($order['created_at'], 0, 10);
		// if ($orderDate == $today) {
		// 	$info['today'][] = $order;
		// }
		
		if ($orderDate >= $startOfWeek) {
			$info['this_week'][] = $order;
		}
		
		if ($orderDate >= $startOfLastWeek && $orderDate <= $endOfLastWeek) {
			$info['last_week'][] = $order;
		}
		
		if ($orderDate >= $startOfMonth) {
			$info['this_month'][] = $order;
		}
		
		if ($orderDate >= $startOfLastMonth && $orderDate <= $endOfLastMonth) {
			$info['last_month'][] = $order;
		}
		
		if ($orderDate >= $startOfYear) {
			$info['this_year'][] = $order;
		}
		
		if ($orderDate >= $startOfLastYear && $orderDate <= $endOfLastYear) {
			$info['last_year'][] = $order;
		}
	}

	// $periods = ['today', 'this_week', 'last_week', 'this_month', 'last_month', 'this_year', 'last_year'];
	$periods = ['this_week', 'last_week', 'this_month', 'last_month', 'this_year', 'last_year'];
	foreach ($periods as $period) {
		$periodOrders = $info[$period];
		$totalSales = array_sum(array_column($periodOrders, 'total_price'));
		$orderCount = count($periodOrders);
		$customerCount = count(array_unique(array_column($periodOrders, 'user_id')));
		
		$info[$period] = [
			'total_sales' => $totalSales,
			'orders' => $orderCount,
			'customers' => $customerCount,
			'orders_data' => $periodOrders
		];
	}

	// Calculate daily sales for this week and last week
	$thisWeekSales = array_fill(0, 7, 0);
	$lastWeekSales = array_fill(0, 7, 0);
	
	// Get start of this week and last week as DateTime objects for day calculations
	$thisWeekStart = new DateTime($startOfWeek);
	$lastWeekStart = new DateTime($startOfLastWeek);
	
	// Process orders for weekly data
	foreach ($r as $order) {
		$orderDateTime = new DateTime(substr($order['created_at'], 0, 10));
		
		// Calculate days since start of the week (0-6)
		if ($orderDateTime >= $thisWeekStart && $orderDateTime < new DateTime($startOfWeek . ' +7 days')) {
			$dayDiff = $orderDateTime->diff($thisWeekStart)->days;
			$thisWeekSales[$dayDiff] += $order['total_price'];
		}
		
		if ($orderDateTime >= $lastWeekStart && $orderDateTime < new DateTime($startOfLastWeek . ' +7 days')) {
			$dayDiff = $orderDateTime->diff($lastWeekStart)->days;
			$lastWeekSales[$dayDiff] += $order['total_price'];
		}
	}
	
	// Calculate weekly sales for this month and last month
	$thisMonthSales = array_fill(0, 4, 0);
	$lastMonthSales = array_fill(0, 4, 0);
	
	$thisMonthStart = new DateTime($startOfMonth);
	$lastMonthStart = new DateTime($startOfLastMonth);
	
	// Process orders for monthly data (dividing into 4 weeks)
	foreach ($r as $order) {
		$orderDateTime = new DateTime(substr($order['created_at'], 0, 10));
		
		if ($orderDateTime >= $thisMonthStart && $orderDateTime < new DateTime($startOfMonth . ' +1 month')) {
			$dayDiff = $orderDateTime->diff($thisMonthStart)->days;
			$weekIndex = min(3, intdiv($dayDiff, 7)); // Get week index (0-3)
			$thisMonthSales[$weekIndex] += $order['total_price'];
		}
		
		if ($orderDateTime >= $lastMonthStart && $orderDateTime <= new DateTime($endOfLastMonth)) {
			$dayDiff = $orderDateTime->diff($lastMonthStart)->days;
			$weekIndex = min(3, intdiv($dayDiff, 7)); // Get week index (0-3)
			$lastMonthSales[$weekIndex] += $order['total_price'];
		}
	}
	
	$info["this_week_sales"] = $thisWeekSales;
	$info["last_week_sales"] = $lastWeekSales;
	$info["this_month_sales"] = $thisMonthSales;
	$info["last_month_sales"] = $lastMonthSales;

	$orders_length = count($r);

	usort($r, function($a, $b) {
		return strtotime($b['created_at']) - strtotime($a['created_at']);
	});
	$recent = array_slice($r, 0, 10);
	return [$info, $recent, $orders_length];
}
function getCategories(){
	return ["hoodie", "sweat", "shirt"];
}
function getItems_soldinfo(){
	$completedOrders = DB::table('orders')->where('status', 1)->pluck('id')->toArray();
	
	$r = DB::table("ordered_items")
		->whereIn('order_id', $completedOrders)
		->get(["order_id", "item_id", "quantity"]);
		
	$groupedItems = [];
	foreach ($r as $item) {
		if (!isset($groupedItems[$item->item_id])) {
			$groupedItems[$item->item_id] = 0;
		}
		$groupedItems[$item->item_id] += $item->quantity;
	}
	
	$items = DB::table('items')->whereIn('id', array_keys($groupedItems))->get(['id', 'name', 'category']);
	$itemDetails = [];
	foreach ($items as $item) {
		$itemDetails[$item->id] = [
			'name' => $item->name,
			'category' => $item->category,
			'sold' => $groupedItems[$item->id]
		];
	}
	return $itemDetails;
}

Route::get('/', function () {
    return view('index');
});
Route::get('/category/{catg?}', function (?string $catg = null) {
	return view('category', ["category"=>$catg]);
});

Route::get('/admin', function () {

	$categories = getCategories();
	$get_sales_info_recent = getSalesInfo();
	$sales_info = $get_sales_info_recent[0];
	$recent = $get_sales_info_recent[1];
	$items_soldinfo = getItems_soldinfo();

	return view('admin.index', ["categories"=>$categories,"sales_info"=>$sales_info, "recent"=>$recent, "items_soldinfo"=>$items_soldinfo]);
});
Route::get('/admin/orders', function () {
	$get_sales_info_recent = getSalesInfo();
	$sales_info = $get_sales_info_recent[0];
	$recent = $get_sales_info_recent[1];
	$orders_length = round($get_sales_info_recent[2] / 10, 0);

	return view('admin.orders', ["sales_info"=>$sales_info, "recent"=>$recent, "orders_length"=>$orders_length]);
});
Route::get('/admin/products', function () {
	$products = DB::table('items')->get();
	$products = json_decode(json_encode($products), true);
	return view('admin.products', ["products"=>$products, "categories"=>getCategories()]);
});
