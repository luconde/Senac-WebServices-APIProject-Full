<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Server(
 *  url = L5_SWAGGER_CONST_HOST,
 *  description = "Produção"
 * )
*/
class ControllerAuthentication extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
