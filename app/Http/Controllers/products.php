<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
}