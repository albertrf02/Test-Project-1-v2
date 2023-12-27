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

    public function formulari($request, $response, $container)
    {
        $modelFormulari = $container->get("formulari");

        if ((isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['birthdate']) && isset($_POST['address']) && isset($_POST['number']) && isset($_POST['city']) && isset($_POST['postalcode']) && isset($_POST['group']))) {

            $nom = $_POST['name'];
            $cognoms = $_POST['surname'];
            $dataNaixement = $_POST['birthdate'];
            $carrer = $_POST['address'];
            $numero = $_POST['number'];
            $ciutat = $_POST['city'];
            $codiPostal = $_POST['postalcode'];
            $grup = $_POST['group'];

            $result = $modelFormulari->insertInscriptions($nom, $cognoms, $dataNaixement, $carrer, $numero, $ciutat, $codiPostal, $grup);

            if ($result) {
                $response->redirect('Location: /comprovant');
                $response->set("result", $_POST);
            } else {
                $response->setSession("error", "No s'ha pogut registrar");
                $response->redirect("index.php");
            }
        }

        $response->setTemplate("formulari.php");
        return $response;
    }

    public function comprovant($request, $response, $container)
    {
        $modelUsers = $container->get("users");
        $lastInscription = $modelUsers->getLastInscription();
        $response->set("lastInscription", $lastInscription);
        $response->setTemplate("comprovant.php");
        return $response;
    }

    public function login($request, $response, $container)
    {
        $response->setTemplate("login.php");
        $user = $request->get("SESSION", "user");
        $response->set("user", $user);
        return $response;
    }
}