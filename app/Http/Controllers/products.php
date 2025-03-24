<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DateTime;

class products extends Controller{
	public function insertProduct(Request $request){
		$validated = request()->validate([
			'name' => 'required|string|max:255',
			'price' => 'required|numeric|min:0',
			'discount' => 'required|numeric|min:0',
			'category' => 'required|string',
			'stock' => 'required|integer|min:0',
			'description' => 'required|string',
			'image' => 'required|string',
			'status' => 'required|integer',
		]);
		
		$r = DB::table("items")->insert([
			'name' => $validated['name'],
			'price' => $validated['price'],
			'discount_perc' => $validated['discount'],
			'category' => $validated['category'],
			'stock' => $validated['stock'],
			'description' => $validated['description'],
			'image_url' => $validated['image'],
			'status' => $validated['status'],
		]);

		if (!$r) {
			return response()->json(["status" => "error", "message" => "Failed to add item."], 500);
		}
		
		return response()->json(["status"=>"success", "message"=>"item added."]);
	}

	public function editProduct(Request $request){
		$validated = request()->validate([
			'product_id'=>'required|string',
			'name' => 'required|string',
			'price' => 'required|string',
			'discount' => 'required|string',
			'category' => 'required|string',
			'stock' => 'required|string',
			'description' => 'required|string',
			'image' => 'required|string',
			'status' => 'required|string',
		]);
		
		$r = DB::table("items")
			->where('id', $validated['product_id'])
			->update([
				'name' => $validated['name'],
				'price' => $validated['price'],
				'discount_perc' => $validated['discount'],
				'category' => $validated['category'],
				'stock' => $validated['stock'],
				'description' => $validated['description'],
				'image_url' => $validated['image'],
				'status' => $validated['status'],
			]);

		if (!$r) {
			return response()->json(["status" => "error", "message" => "Failed to add item."], 500);
		}
		
		return response()->json(["status"=>"success", "message"=>"item edited."]);
	}

	public function insertOrder($user_id, $items, $status){
		try {
			// Begin a transaction to ensure data consistency
			DB::beginTransaction();
			
			$order_id = DB::table("orders")->insertGetId([
				'user_id' => $user_id,
				'total_price' => 0,
				'status' => $status,
			]);
			
			$order_total_price = 0;
			$item_ids = array_map('intval', array_keys($items));
			
			// Fetch all items in one query instead of inside the loop
			$price_items = DB::table("items")
				->whereIn("id", $item_ids)
				->get(['id', 'price', 'discount_perc'])
				->keyBy('id');
			$ordered_items = [];
			foreach ($items as $item_id => $quantity) {
				// Convert item_id to a zero-padded string of length 5
				$item_id = str_pad($item_id, 5, '0', STR_PAD_LEFT);
				if (!isset($price_items[$item_id])) {
					throw new \Exception("Item with ID {$item_id} not found");
				}
				
				$item = $price_items[$item_id];
				$discounted_price = $item->price * (1 - $item->discount_perc/100);
				$total_price = $discounted_price * $quantity;
				
				$ordered_items[] = [
					'order_id' => $order_id,
					'item_id' => $item_id,
					'quantity' => $quantity,
					'price' => $total_price,
				];
				
				$order_total_price += $total_price;
			}
			
			// Batch insert ordered items
			DB::table("ordered_items")->insert($ordered_items);
			
			// Update order with total price
			$r = DB::table("orders")
				->where("id", $order_id)  // Assuming column name is 'id' not 'order_id'
				->update(['total_price' => $order_total_price]);
			
			// Commit the transaction
			DB::commit();
		} catch (\Exception $e) {
			// Rollback in case of errors
			DB::rollBack();
			return ["status" => "error", "message" => "Failed to add order: " . $e->getMessage()];
		}

		if (!$r) {
			return ["status" => "error", "message" => "Failed to add order."];
		}
		
		return ["status"=>"success", "message"=>"order added."];
	}

	function getSalesInfo(){
		$r = DB::table("orders")->get(["id", "user_id", "total_price", "status", "payment", "created_at"]);
		$r = json_decode($r,true);
		$info = ["today"=>[], "this_week"=>[], "this_month"=>[], "this_year"=>[]];
		// $now = new DateTime();
		$startOfWeek = (new DateTime())->modify('monday this week')->format('Y-m-d');
		$startOfLastWeek = (new DateTime())->modify('monday last week')->format('Y-m-d');
		$endOfLastWeek = (new DateTime())->modify('sunday last week')->format('Y-m-d');
		$startOfMonth = (new DateTime())->modify('first day of this month')->format('Y-m-d');
		$startOfLastMonth = (new DateTime())->modify('first day of last month')->format('Y-m-d');
		$endOfLastMonth = (new DateTime())->modify('last day of last month')->format('Y-m-d');
		$startOfYear = (new DateTime())->modify('first day of january this year')->format('Y-m-d');
		$startOfLastYear = (new DateTime())->modify('first day of january last year')->format('Y-m-d');
		$endOfLastYear = (new DateTime())->modify('last day of december last year')->format('Y-m-d');
	
		$info = [
			// "today" => [],
			"this_week" => [],
			"last_week" => [],
			"this_month" => [],
			"last_month" => [],
			"this_year" => [],
			"last_year" => []
		];
	
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
	
		$thisWeekSales = array_fill(0, 7, 0);
		$lastWeekSales = array_fill(0, 7, 0);
		
		$thisWeekStart = new DateTime($startOfWeek);
		$lastWeekStart = new DateTime($startOfLastWeek);
		
		foreach ($r as $order) {
			$orderDateTime = new DateTime(substr($order['created_at'], 0, 10));
	
			if ($orderDateTime >= $thisWeekStart && $orderDateTime < new DateTime($startOfWeek . ' +7 days')) {
				$dayDiff = $orderDateTime->diff($thisWeekStart)->days;
				$thisWeekSales[$dayDiff] += $order['total_price'];
			}
			
			if ($orderDateTime >= $lastWeekStart && $orderDateTime < new DateTime($startOfLastWeek . ' +7 days')) {
				$dayDiff = $orderDateTime->diff($lastWeekStart)->days;
				$lastWeekSales[$dayDiff] += $order['total_price'];
			}
		}
		
		$thisMonthSales = array_fill(0, 4, 0);
		$lastMonthSales = array_fill(0, 4, 0);
		
		$thisMonthStart = new DateTime($startOfMonth);
		$lastMonthStart = new DateTime($startOfLastMonth);
		
		foreach ($r as $order) {
			$orderDateTime = new DateTime(substr($order['created_at'], 0, 10));
			
			if ($orderDateTime >= $thisMonthStart && $orderDateTime < new DateTime($startOfMonth . ' +1 month')) {
				$dayDiff = $orderDateTime->diff($thisMonthStart)->days;
				$weekIndex = min(3, intdiv($dayDiff, 7));
				$thisMonthSales[$weekIndex] += $order['total_price'];
			}
			
			if ($orderDateTime >= $lastMonthStart && $orderDateTime <= new DateTime($endOfLastMonth)) {
				$dayDiff = $orderDateTime->diff($lastMonthStart)->days;
				$weekIndex = min(3, intdiv($dayDiff, 7)); 
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
	
	public function getOrders_wPage(Request $request){
		$validated = $request->validate([
			'page' => 'required|integer|min:1',
		]);
		//each page contains total of 10 orders
		$offset = ($validated["page"] - 1) * 10;
		$r = DB::table("orders")
			->offset($offset)
			->limit(10)
			->get(["id", "user_id", "total_price", "status", "payment", "created_at"]);
		$r = json_decode($r,true);
		return Response()->json($r);
	}

	public function getOrderedItems_Order_id(Request $request){
		$validated = $request->validate([
			'order_id' => 'required|string|min:1',
		]);

		$r = DB::table("ordered_items")
			->where("order_id",$validated["order_id"])
			->get(["id", "item_id", "quantity", "price", "created_at", "updated_at"]);
		// Get item names for the ordered items
		$r = $r->toArray();
		$itemIds = array_column($r, 'item_id');
		$items = DB::table('items')
			->whereIn('id', $itemIds)
			->pluck('name', 'id');

		// Add item name to each ordered item
		foreach ($r as &$orderedItem) {
			$orderedItem->item_name = $items[$orderedItem->item_id] ?? 'Unknown Item';
		}
		return Response()->json($r);
	}
}