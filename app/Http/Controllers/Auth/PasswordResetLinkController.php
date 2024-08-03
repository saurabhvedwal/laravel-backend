<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    /**
     *  @OA\Post(
     *    path="/forgot-password",
     *    operationId="forgotPassword",
     *    tags={"Authentication"},
     *    summary="Forgot Password",
     *    description="Forgot Password",
     *    @OA\RequestBody(
     *      required=true,
     *      description="Forgot Password Request",
     *      @OA\JsonContent(
     *        @OA\Property(property="email",type="string",example="test@test.com"),
     *      )
     *    ),
     *    @OA\Response(
     *      response=200,
     *      description="Successful operation",
     *      @OA\JsonContent(
     *        @OA\Property(property="status",type="string",example="Validated"),
     *      )  
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
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return response()->json(['status' => __($status)]);
    }
}
