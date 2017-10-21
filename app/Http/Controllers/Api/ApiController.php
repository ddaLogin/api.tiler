<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.08.2017
 * Time: 14:50
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * @SWG\Swagger( schemes={"http"}, host="api.tiler.com", basePath="/api/v1",
 *     @SWG\Info( title="RESTfull api for Tiler", version="1.0.0")
 * )
 */

/** @SWG\SecurityScheme(
 *     securityDefinition="passport",
 *     type="oauth2",
 *     authorizationUrl="http://api.tiler.com/oauth/token",
 *     tokenUrl="http://api.tiler.com/oauth/token",
 *     flow="password",
 * )
 */
class ApiController extends Controller
{

}