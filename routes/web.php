<?php

use Illuminate\Support\Facades\Route;

/**
 * @OA\Info(title="Laravel API", version="0.1")
 */
/**
 * @OA\Get(
 *  path="/",
 *  operationId="getVersion",
 *  tags={"Version"},
 *  summary="App Version",
 *  description="Get App Version",
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
Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';
