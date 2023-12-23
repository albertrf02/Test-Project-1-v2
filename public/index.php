<?php

namespace App;

use App\Controllers\ViewsController;

use Emeset\Contracts\Routers\Router;

error_reporting(E_ERROR | E_WARNING | E_PARSE);
include "../vendor/autoload.php";

header("Access-Control-Allow-Origin: *");

/* Creem els diferents models */
$contenidor = new Container(__DIR__ . "/../App/config.php");

$app = new \Emeset\Emeset($contenidor);

$app->get("/", [ViewsController::class, "index"]);
$app->get("/formulari", [ViewsController::class, "formulari"]);
$app->post("/formulariPost", [ViewsController::class, "formulari"]);
$app->get("/comprovant", [ViewsController::class, "comprovant"]);





$app->route(Router::DEFAULT_ROUTE, "\App\Controllers\ErrorController:error404");

$app->execute();