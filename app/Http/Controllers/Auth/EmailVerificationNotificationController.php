<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    /**
     *  @OA\Post(
     *    path="/email/verification-notification",
     *    operationId="sendEmailVerificationNotification",
     *    tags={"Authentication"},
     *    summary="Send Email Verification Notification",
     *    description="Send User Email Verification Notification",
     *    @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *      @OA\JsonContent(
     *        @OA\Property(property="status",type="string",example="verification-link-sent"),
     *      ),
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
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['status' => 'verification-link-sent']);
    }
}
