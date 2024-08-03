<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
  /**
   * Handle an incoming authentication request.
   */
  /**
   * @OA\Get(
   *  path="/api/v1/user",
   *  operationId="getUser",
   *  tags={"User"},
   *  summary="Get User Detail",
   *  description="Get User Detail",
   *  @OA\Response(
   *      response=200,
   *      description="Successful operation",
   *      @OA\JsonContent(
   *        @OA\Property(property="data",type="object",
   *          @OA\Schema(ref="#/components/schemas/User"),
   *        ),
   *      ),
   *  ),
   *  @OA\Response(
   *      response=401,
   *      description="Unauthenticated",
   *  ),
   *  @OA\Response(
   *      response=403,
   *      description="Forbidden"
   *  ),
   * )
   */
  public function getUser(Request $request): JsonResponse
  {
    $user = $request->user();
    return response()->json(['data' => $user]);
  }
}
