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
    /**
     * API: Get a JWT via given credentials.
     * Digunakan oleh Postman/API atau Form Login via JS Fetch
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            // Jika request datang dari browser biasa (bukan API client yang mengharap JSON)
            // Kita bisa kembalikan error ke halaman login
            if (!request()->expectsJson()) {
                return back()->withErrors(['email' => 'Unauthorized / Wrong Credentials']);
            }
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Jika request dari browser (Form Submit biasa), tampilkan token (atau simpan di cookie idealnya)
        // Untuk saat ini kita return JSON token agar sesuai permintaan JWT Anda
        return $this->respondWithToken($token);
    }

    /**
     * API: Register a User.
     */
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

        $token = Auth::guard('api')->login($user);

        if (!request()->expectsJson()) {
            // Redirect ke home jika register dari web, tapi ini tricky karena JWT stateless.
            // Idealnya web user pakai Session, tapi karena request JWT, user akan melihat JSON Token.
            return $this->respondWithToken($token);
        }

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    /**
     * API: Get the authenticated User.
     */
    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    /**
     * API: Log the user out (Invalidate the token).
     */
    public function logout()
    {
        Auth::guard('api')->logout();

        if (!request()->expectsJson()) {
            return redirect()->route('login');
        }

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * API: Refresh a token.
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    /**
     * Helper: Get the token array structure.
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => Auth::guard('api')->user()
        ]);
    }

    // =========================================================================
    // WEB VIEWS (Metode yang Hilang & Menyebabkan Error)
    // =========================================================================

    /**
     * Menampilkan Halaman Login (Blade)
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Menampilkan Halaman Register (Blade)
     */
    public function showRegister()
    {
        return view('auth.register');
    }
}
