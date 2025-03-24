<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DateTime;
use Exception;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use \Firebase\JWT\JWT;

class users extends Controller{
	public function hashPassword($password){
		$pepper = getenv("PEPPER");
		$hash = \Illuminate\Support\Facades\Hash::make($password . $pepper);
		return $hash;
	}
	
	public function validatePassword($password, $hash){
		$pepper = getenv("PEPPER");
		return \Illuminate\Support\Facades\Hash::check($password . $pepper, $hash);
	}


    public function register(Request $request){
		if ($request->cookie("firebase_token")){
			return response()->json(["status"=>"error", "message" => "no"], 400);
		}
        try {
			$validated = $request->validate([
				"email" => "required|email|max:100",
				"password" => "required|string|min:6|max:255",
				"full_name" => "required|string|max:100"
			]);

			if (preg_match('/[^a-zA-Z\s]/', $validated['full_name'])) {
				return response()->json(["status" => "error", "message" => "Full name contains invalid characters.  Only letters and spaces are allowed."], 400);
			}

			if (!preg_match('/\d/', $validated["password"])){
				return response()->json(["status"=>"error", "message" => "Password must contain a numeric character"], 400);
			}

			$phone_number = "+90 5555555555";
			
			$already_exist = DB::table("users")->select("fbase_uid")
				->where("email", $validated["email"])
				->where("deleted", 0)
				->first();
			if ($already_exist){
				return response()->json(["status"=>"error", "message" => "User already exist."], 400);
			}

            $firebase_config = json_decode(env("FIREBASE_CONFIG"), true);

            $auth = (new Factory)
                ->withServiceAccount($firebase_config)
                ->createAuth();
			
            $userProperties = [
                "email" => $validated["email"],
                "password" => $validated["password"],
                "displayName" => $validated["full_name"],
            ];
			try{
				$createdUser = $auth->createUser($userProperties);
			} catch (Exception $e) {
				dd($e);
				return response()->json(["status"=>"error", "message" => "Could not create user."], 400);
			}
			$hashed_psw = $this->hashPassword($validated["password"]);
			
            $r = DB::table("users")->insert([
                "fbase_uid" => $createdUser->uid,
                "email" => $validated["email"],
                "password" => $hashed_psw,
                "full_name" => $validated["full_name"],
                "phone_number" => $phone_number,
            ]);
			if (!$r){
				return response()->json(["status"=>"error", "message" => "User already exist2."], 400);
			}

			$payload = [
				"iss" => env("JWT_ISSUER"),
				"sub" => $createdUser->uid,
				"iat" => time(),
				"exp" => time() + 60 * 60 * 24 * 7
			];
	
			$jwt = JWT::encode($payload, env("JWT_SECRET"), "HS256");
			
            return response()->json(["status"=>"success", "message" => "User registered successfully."], 200)
				->cookie("firebase_token", $jwt, 60 * 24 * 7, null, null, true, true);;
        } catch (Exception $e) {
			dd($e);
            return response()->json(["status"=>"error", "message" => $e->getMessage()], 500);
        }
    }

	public function login(Request $request){
		if ($request->cookie("firebase_token")){
			return response()->json(["status"=>"error", "message" => "no"], 400);
		}
        try {
			$validated = $request->validate([
				"email" => "required|email|max:100",
				"password" => "required|string|max:255"
			]);

			$already_exist = DB::table("users")->select("fbase_uid")
				->where("email", $validated["email"])
				->where("deleted", 0);
			if (!$already_exist){
				return response()->json(["status"=>"error", "message" => "User does not exist."], 400);
			}

            $firebase_config = json_decode(env("FIREBASE_CONFIG"), true);

            $auth = (new Factory)
                ->withServiceAccount($firebase_config)
                ->createAuth();

			try{
				$signInResult = $auth->signInWithEmailAndPassword($validated["email"], $validated["password"]);
				$firebaseUserId = $signInResult->firebaseUserId();
			} catch (Exception){
				return response()->json(["status"=>"error", "message" => "User not found2."], 404);
			}

            $user = DB::table("users")
				->where("fbase_uid", $firebaseUserId)
				->where("deleted", 0)
				->first();

            if (!$user) {
                return response()->json(["status"=>"error", "message" => "User not found."], 404);
            }

			if (!( $this->validatePassword($validated["password"], $user->password) )){
				return response()->json(["status"=>"error", "message" => "User mismatch"], 400);
			}

			$payload = [
				"iss" => env("JWT_ISSUER"),
				"sub" => $user->fbase_uid,
				"iat" => time(),
				"exp" => time() + 60 * 60 * 24 * 7
			];
	
			$jwt = JWT::encode($payload, env("JWT_SECRET"), "HS256");
	
            return response()->json(["status"=>"success", "message" => "User logged in successfully."], 200)
				->cookie("firebase_token", $jwt, 60 * 24 * 7, null, null, true, true);
        } catch (Exception $e) {
            return response()->json(["status"=>"error", "message" => "User does not exist2."], 400);
        }
    }

	public function updateInfo(Request $request){
		try{
			$validated = $request->validate([
				"full_name" => "required|string|max:100",
				"email" => "required|email|max:100",
				"phone_number" => "required|string|max:20"
			]);

			if (preg_match('/[^a-zA-Z\s]/', $validated['full_name'])) {
				return response()->json(["status" => "error", "message" => "Full name contains invalid characters.  Only letters and spaces are allowed."], 400);
			}

			$fbase_uid = $request->session()->get("fbase_uid");

			$r = DB::table("users")
				->where("fbase_uid", $fbase_uid)
				->update([
					"full_name" => $validated["full_name"],
					"email" => $validated["email"],
					"phone_number" => $validated["phone_number"]
				]);
			if (!$r){
				return response()->json(["status"=>"error", "message" => "Something went wrong."], 200);
			}
			return response()->json(["status"=>"success", "message" => "User info updated successfully."], 200);


		} catch (Exception $e){
			return response()->json(["status"=>"error", "message" => $e->getMessage()], 200);
		}
	}

	// public function _register(Request $request){
	// 	if ($request->session()->has("login_68474a12-b04b-424d")) {
	// 		return Response()->json(["status"=>"error", "message"=>"already logged in"], 400);
	// 	}
	// 	$validated = request()->validate([
	// 		'full_name' => 'required|string|max:50',
	// 		'email' => 'required|string|max:100',
	// 		'password' => 'required|string|max:64',
	// 		'fbase_uid' => 'required|string|max:64',
	// 	]);

	// 	// `user_id`, `fbase_uid`, `username`, `email`, `password`, `full_name`, `phone_number`
	// 	$phone_number = "+905555555555";
	// 	$hashedPswd = $this->hashPassword($validated['password']);
	// 	$user_id = DB::table("users")
	// 		->insertGetId([
	// 		'fbase_uid' => $validated['fbase_uid'],
	// 		'email' => $validated['email'],
	// 		'password' => $hashedPswd,
	// 		'full_name' => $validated['full_name'],
	// 		'phone_number' => $phone_number,
	// 		]);
	// 	$request->session()->put("login_68474a12-b04b-424d", $user_id);
	// 	return Response()->json(["status" => "success", "message" => "Registration successful"]);
	// }
	// public function _login(Request $request){
	// 	if ($request->session()->has("login_68474a12-b04b-424d")) {
	// 		return Response()->json(["status"=>"error", "message"=>"already logged in"], 400);
	// 	}
	// 	$validated = request()->validate([
	// 		'email' => 'required|string|max:100',
	// 		'password' => 'required|string|max:64',
	// 		'fbase_uid' => 'required|string|max:64',
	// 	]);

	// 	$user = DB::table("users")
	// 		->where('email', $validated['email'])
	// 		->where('fbase_uid', $validated['fbase_uid'])
	// 		->first();
		
	// 	if (!$user) {
	// 		return Response()->json(["status" => "error", "message" => "User not found"], 404);
	// 	}
		
	// 	$passwordData = json_decode($user->password);
	// 	$hash = $passwordData[0];
	// 	$salt = $passwordData[1];
		
	// 	if (!$this->validatePassword($validated['password'], $salt, $hash)) {
	// 		return Response()->json(["status" => "error", "message" => "Invalid credentials"], 401);
	// 	}
		
	// 	$request->session()->put("login_68474a12-b04b-424d", $user->user_id);
		
	// 	return Response()->json(["status" => "success", "message" => "Login successful"]);
	// }
}