<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class NewPasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    /**
     *  @OA\Post(
     *    path="/reset-password",
     *    operationId="resetPassword",
     *    tags={"Authentication"},
     *    summary="Reset Password",
     *    description="Reset Password",
     *    @OA\RequestBody(
     *      required=true,
     *      description="Change Password Request",
     *      @OA\JsonContent(
     *        @OA\Property(property="token",type="string",example="fe57ee544f7c4692d7be26eac8568b01211e2bc9"),
     *        @OA\Property(property="email",type="string",example="test@test.com"),
     *        @OA\Property(property="password",type="string",example="password"),
     *      )
     *    ),
     *    @OA\Response(
     *      response=200,
     *      description="Successful operation",
     *    ),
     *    @OA\Response(
     *        response=401,
     *        description="Unauthenticated",
     *    ),
     *    @OA\Response(
     *        response=403,
     *        description="Forbidden"
     *    )
     *  )
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->string('password')),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return response()->json(['status' => __($status)]);
    }
}
