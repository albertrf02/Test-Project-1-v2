<?php

namespace App\Controllers;

class ViewsController
{
    public function index($request, $response, $container)
    {
        $error = $request->get("SESSION", "error");
        $response->set("error", $error);
        $response->setSession("error", "");
        $response->SetTemplate("index.php");
        return $response;
    }
}