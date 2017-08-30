<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.08.2017
 * Time: 14:50
 */

namespace App\Http\Controllers;

/**
 * @SWG\Swagger( schemes={"http"}, host="api.tiler.com", basePath="/api/v1" )
 */

/**
 * @SWG\Swagger(
 *   @SWG\Info( title="RESTfull api for Tiler", version="1.0.0" )
 * )
 */

/** @SWG\SecurityScheme( securityDefinition="jwt_auth", type="apiKey", in="header", name="Authorization" ) */

class ApiController extends Controller
{

}