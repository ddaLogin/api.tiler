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
    /**
     * @SWG\Post(
     *   path="/oauth/token",
     *   summary="Authorization",
     *   tags={"Auth"},
     *   produces={"application/json"},
     *   @SWG\Parameter( name="grant_type", description="Oauth2.0 grand type - password", required=true, type="string", in="query"),
     *   @SWG\Parameter( name="client_id", description="Oauth client id", required=true, type="string", in="query"),
     *   @SWG\Parameter( name="client_secret", description="Oauth client secret", required=true, type="string", in="query"),
     *   @SWG\Parameter( name="username", description="User login", required=true, type="string", in="query"),
     *   @SWG\Parameter( name="password", description="User password", required=true, type="string", in="query"),
     *   @SWG\Response( response=200, description="Success authorization"),
     *   @SWG\Response( response=401, description="Invalid credentials"),
     *   @SWG\Response( response=422, description="Validation errors"),
     * )
     * @return \Illuminate\Http\JsonResponse
     */
}