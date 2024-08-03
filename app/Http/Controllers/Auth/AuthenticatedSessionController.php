<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    /**
     * @OA\Post(
     *  path="/login",
     *  operationId="userLogin",
     *  tags={"Authentication"},
     *  summary="Login",
     *  description="Login user with email and password",
     *  @OA\RequestBody(
     *    required=true,
     *    description="The Token Request",
     *    @OA\JsonContent(
     *      @OA\Property(property="email",type="string",example="your@email.com"),
     *      @OA\Property(property="password",type="string",example="YOUR_PASSWORD"),
     *    )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Successful operation",
     *   ),
     *  @OA\Response(
     *      response=401,
     *      description="Unauthenticated",
     *  ),
     *  @OA\Response(
     *      response=403,
     *      description="Forbidden"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="The provided credentials are incorrect.",
     *  ),
     * )
     */
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response()->noContent();
    }

    /**
     * Destroy an authenticated session.
     */
    /**
     * @OA\Post(
     *  path="/logout",
     *  operationId="userLogout",
     *  tags={"Authentication"},
     *  summary="Logout",
     *  description="Logout user",
     *  @OA\Response(
     *      response=200,
     *      description="Successful operation",
     *   ),
     *  @OA\Response(
     *      response=401,
     *      description="Unauthenticated",
     *  ),
     *  @OA\Response(
     *      response=403,
     *      description="Forbidden"
     *  )
     * )
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
