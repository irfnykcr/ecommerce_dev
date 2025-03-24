<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Exception;
use Illuminate\Support\Facades\Log;

class JwtAuth{

	private function returnLogin_error(string $msg){
		return redirect("/account/login?msg=$msg")->cookie('firebase_token', '', -1);
	}

    public function handle(Request $request, Closure $next){
        // $authHeader = $request->cookie('firebase_token');
        // if (!$authHeader) {
        //     return response()->json(['error' => 'Authorization header not found.'], 401);
        // }
		$token = $request->cookie('firebase_token');
        if (!$token) {
            // return response()->json(['error' => 'Authorization header not found.'], 401);
			return $this->returnLogin_error("NotFound");
        }

        // list($bearer, $token) = explode(" ", $authHeader);

        // if ($bearer !== 'Bearer') {
        //     return response()->json(['error' => 'Authorization token must be Bearer token.'], 401);
        // }

        try {
            $key = env('JWT_SECRET');
			$decoded = JWT::decode($token, new Key($key, 'HS256'));
            $request->attributes->add(['fbase_uid' => $decoded->sub]);

        } catch (ExpiredException $e) {
            Log::error('JWT Token expired: ' . $e->getMessage());
            // return response()->json(['error' => 'Token is expired.'], 401);
			return $this->returnLogin_error("TokenExpired");

        } catch (Exception $e) {
            Log::error('JWT Token decoding failed: ' . $e->getMessage());
            // return response()->json(['error' => 'Token is invalid.'], 401);
			return $this->returnLogin_error("TokenInvalid");

        }

        return $next($request);
    }
}
