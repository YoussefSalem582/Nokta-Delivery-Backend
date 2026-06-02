<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    description: "Nokta API Server OpenApi description for Nokta Ride-hailing & Delivery API",
    title: "Nokta API Documentation",
    contact: new OA\Contact(email: "admin@nokta.com")
)]
#[OA\Server(
    url: L5_SWAGGER_CONST_HOST,
    description: "Nokta API Server"
)]
#[OA\SecurityScheme(
    securityScheme: "apiAuth",
    type: "http",
    name: "Token based Based",
    in: "header",
    bearerFormat: "JWT",
    scheme: "bearer",
    description: "Login with email and password to get the authentication token"
)]
abstract class Controller
{
    //
}
