<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class products extends Controller{
	public function insertProduct(){
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
}