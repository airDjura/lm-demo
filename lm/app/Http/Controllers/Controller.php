<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 *  @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="nexTome",
 *         description="Api description...",
 *         termsOfService="",
 *         @OA\Contact(
 *             email="airdjura@gmail.com"
 *         ),
 *         @OA\License(
 *             name="Private License",
 *             url="URL to the license"
 *         )
 *     ),
 *     @OA\PathItem(
 *          path="/api"
 *     ),
 *     @OA\ExternalDocumentation(
 *         description="Find out more about my website",
 *         url="http://nex-to.me"
 *     )
 *  )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
