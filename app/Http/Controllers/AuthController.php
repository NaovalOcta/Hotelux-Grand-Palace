<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // --- FITUR LOGIN ---

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        // 1. Cek Login menggunakan Guard 'web' dulu untuk verifikasi password
        // Kita tidak langsung pakai guard('api')->attempt() karena itu kadang return token langsung
        // tanpa validasi tipe object User yang ketat, yang menyebabkan error Type Error tadi.

        if (! Auth::guard('web')->attempt($credentials)) {
            // Jika gagal login session
            if (!request()->expectsJson()) {
                return back()->withErrors(['email' => 'Unauthorized / Wrong Credentials']);
            }
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // 2. Jika sukses login session, ambil user-nya
        $user = Auth::guard('web')->user();

        // 3. Generate Token secara manual untuk user tersebut
        // Ini menghindari error JWTSubject karena kita mempassing object $user yang valid
        $token = Auth::guard('api')->login($user);

        // 4. Response
        if (!request()->expectsJson()) {
            // Jika browser, tetap redirect ke home (Session sudah terbentuk di langkah 1)
            return redirect()->route('home');
        }

        // Jika API, kembalikan token
        return $this->respondWithToken($token);
    }

    // --- FITUR REGISTER ---

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            if (!request()->expectsJson()) {
                return back()->withErrors($validator)->withInput();
            }
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'password' => Hash::make($request->get('password')),
            'role' => 'user',
        ]);

        if (!request()->expectsJson()) {
            Auth::guard('web')->login($user);
            return redirect()->route('home')->with('success', 'Registration successful!');
        }

        $token = Auth::guard('api')->login($user);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    // --- UTILITIES ---

    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        Auth::guard('web')->logout();

        if (!request()->expectsJson()) {
            return redirect()->route('login');
        }

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => Auth::guard('api')->user()
        ]);
    }
}
