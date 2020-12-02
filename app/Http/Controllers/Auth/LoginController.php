<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * Login Controller Class
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except('login');
    }

    /**
     * Kullanıcı sisteme giriş yapar.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'E-posta adresiniz veya şifreniz yanlış, lütfen tekrar deneyin'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Kullanıcı sistemden çıkış yapar.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Hesabınızdan başarıyla çıkış yaptınız.'
        ]);
    }
}
