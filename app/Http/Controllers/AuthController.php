<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function signIn(Request $request){
        if($request->isMethod('post')){
            $data = $request->validate([
                'email' => ['required', 'string', 'email:dns,rfc'],
                'password' => ['required', 'string', 'min:8'],
            ]);

            $emailExists = User::where("email", $data["email"])->first();

            if(!$emailExists){
                return response()->json([
                    'message' => 'Email not found, please sign up first.',
                ], 402);
            }

            /** @var User $auth */
            $auth = auth();

            if (!$auth->attempt($data)) {
                return response()->json([
                    'message' => 'Invalid credentials. Please try again.',
                ], 402);
            }
            $user = $auth->user();
            $token = $user->createToken($user->name)->plainTextToken;
            return response()->json([
                "message" => "Sign in successful.",
                "access_token" => $token,
                "user" => $user,
            ], 200);

        }
    }

    public function signUp(Request $request){
        if($request->isMethod('post')){
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email:dns,rfc', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            try {
                DB::beginTransaction();
                $user = User::create($data);
                DB::commit();
                return response()->json([
                    'message' => "Registration successful. You can sign in your account now.",
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage());
                return response()->json([
                    'message' => 'Registration failed. Please try again later.',
                ], 500);
            }
        }
    }

    public function signOut(Request $request){
        
        Log::error("signing out user:");
        Log::error($request->user());
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => ucfirst('Session has ended.')], 200);
    }
}
