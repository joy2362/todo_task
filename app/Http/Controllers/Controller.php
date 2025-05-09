<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *    title="TODO",
 *    description="API documentation for TODO",
 *    version="1.0.0",
 *    @OA\Contact(
 *      email="abdullahzahidjoy@gmail.com"
 *    )
 * ),
 *  @OA\Components(
 *     @OA\Header(
 *         header="Accept",
 *         description="Accepted response format",
 *         @OA\Schema(
 *             type="string",
 *             default="application/json"
 *         )
 *     )
 * ),
 * @oa\tag(
 *     name="Auth",
 *     description="Authentication endpoints"
 * ),
 */
abstract class Controller
{
}
