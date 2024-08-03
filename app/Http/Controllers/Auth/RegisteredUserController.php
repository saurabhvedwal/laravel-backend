<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    /**
     * @OA\Post(
     *  path="/register",
     *  operationId="registerUser",
     *  tags={"Authentication"},
     *  summary="Register User",
     *  description="Register User",
     *  @OA\RequestBody(
     *      required=true,
     *      description="Register User Request",
     *      @OA\JsonContent(
     *        @OA\Property(property="name",type="string",example="John Doe"),
     *        @OA\Property(property="email",type="string",example="test@test.com"),
     *        @OA\Property(property="password",type="string",example="password"),
     *      )
     *    ),
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
    public function store(Request $request): Response
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->string('password')),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
