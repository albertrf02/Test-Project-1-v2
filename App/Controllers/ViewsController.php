<?php

namespace App\Controllers;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

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
        $response->set("error", "");

        if ((isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['birthdate']) && isset($_POST['address']) && isset($_POST['number']) && isset($_POST['city']) && isset($_POST['postalcode']) && isset($_POST['group']))) {

            $nom = $_POST['name'];
            $cognoms = $_POST['surname'];
            $dataNaixement = $_POST['birthdate'];
            $carrer = $_POST['address'];
            $numero = $_POST['number'];
            $ciutat = $_POST['city'];
            $codiPostal = $_POST['postalcode'];
            $grup = $_POST['group'];

            $exisitingUser = $modelFormulari->checkNomAndCognom($nom, $cognoms);


            if (!$exisitingUser) {
                $response->set("error", "");
                $idParticipant = $modelFormulari->insertInscriptions($nom, $cognoms, $dataNaixement, $carrer, $numero, $ciutat, $codiPostal, $grup);
                $response->setSession("idParticipant", $idParticipant);
                $response->redirect("Location: /comprovant");
            } else {
                $response->set("error", "Ja has participat una vegada, inicia sessió per tornar a participar.");
            }
        }

        $response->setTemplate("formulari.php");
        return $response;
    }

    public function comprovant($request, $response, $container)
    {
        $modelUsers = $container->get("users");
        $modelFormulari = $container->get("formulari");

        $idParticipant = ($_SESSION["idParticipant"]);
        $participant = $modelUsers->getParticipantById($idParticipant);
        $response->set("participant", $participant);

        $qrfilename = $modelFormulari->generateRandomToken() . '.png';
        $response->set("qrfilename", $qrfilename);

        $urltoken = 'http://' . $_SERVER['HTTP_HOST'] . '/login?token=' . $participant['token'];
        $response->set("urltoken", $urltoken);

        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($urltoken)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(150)
            ->margin(10)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->validateResult(false)
            ->build();

        $result->saveToFile($_SERVER['DOCUMENT_ROOT'] . '/qr/' . $qrfilename);


        $response->setTemplate("comprovant.php");
        return $response;
    }

    public function login($request, $response, $container)
    {
        if (isset($_GET['token'])) {
            $token = $_GET['token'];
        } else {
            $token = "";
        }
        $response->set("token", $token);

        $response->setTemplate("login.php");
        return $response;
    }

    public function taules($request, $response, $container)
    {
        $modelUsers = $container->get("users");
        $user = $request->get("SESSION", "user");
        $token = $user["token"];
        $userCards = $modelUsers->getCardsByUser($token);
        $response->set("userCards", $userCards);

        $response->setTemplate("taules.php");
        return $response;
    }

    public function uploadCard($request, $response, $container)
    {
        $modelUsers = $container->get("users");
        $user = $request->get("SESSION", "user");

        if (isset($_FILES['card']) && $_FILES['card']['error'] === 0) {
            $modelUsers->uploadCard($user["id"]);
            $response->redirect("Location: /taules");
        }

        return $response;
    }
}