<?php

namespace App\Controllers;

class LoginController
{
    public function login($request, $response, $container)
    {
        $token = $request->get(INPUT_POST, "formData");

        if (!$token) {
            $response->setSession("logged", false);
            $response->setSession("error", "Usuari o contrasenya incorrectes");
            $response->set("error", "Aquest usuari no existeix 222222");
            $response->setJSON();
            return $response;
        }

        $modelUsers = $container->get("users");
        $user = $modelUsers->getUser($token);

        if ($user) {
            $response->setSession("logged", true);
            $response->setSession("user", $user);
            $response->set("user", $user);
            $response->setJSON();
        } else {
            $response->setSession("logged", false);
            $response->setSession("error", "Usuari o contrasenya incorrectes");
            $response->set("error", "Aquest usuari no existeix");
            $response->setJSON();
        }

        return $response;
    }

    public function logout($request, $response, $container)
    {
        $response->setSession("logged", false);
        $response->setSession("user", null);
        $response->redirect("Location: /");
        return $response;
    }
}