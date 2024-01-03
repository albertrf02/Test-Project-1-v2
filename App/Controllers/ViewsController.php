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

                $token = $modelFormulari->generateRandomToken();

                $resguardPath = 'resguard/';
                $filename = $modelFormulari->generateRandomToken() . $_FILES['resguard']['name'];
                $filePath = $resguardPath . $filename;

                error_log($filePath);

                if (move_uploaded_file($_FILES['resguard']['tmp_name'], $filePath)) {
                    $idParticipant = $modelFormulari->insertInscriptions($nom, $cognoms, $dataNaixement, $carrer, $numero, $ciutat, $codiPostal, $grup, $token, $filename);
                    $response->setSession("idParticipant", $idParticipant);

                    $send = $this->sendTo($nom, $cognoms, $ciutat, $carrer, $grup, $filePath);
                    $response->set("send", $send);


                    $response->redirect("Location: /comprovant");
                } else {
                    echo 'Ha fallat la pujada del resguard';
                }
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
        $modelFormulari = $container->get("formulari");
        $user = $request->get("SESSION", "user");

        if (isset($_FILES['card']) && $_FILES['card']['error'] === 0) {
            $resguardPath = 'resguard/';

            $filename = $modelFormulari->generateRandomToken() . $_FILES['card']['name'];

            $filePath = $resguardPath . $filename;

            if (move_uploaded_file($_FILES['card']['tmp_name'], $filePath)) {
                $modelUsers->uploadCard($user["id"], $filename);
                $response->redirect("Location: /taules");
            } else {
                echo 'Failed to move the uploaded file.';
            }
        }

        return $response;
    }

    public function sendTo($nom, $cognoms, $ciutat, $carrer, $grup, $filePath)
    {

        $webhookurl = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/webhook.txt', true);

        $timestamp = date("c", strtotime("now"));

        $json_data = json_encode([
            // Message
            "content" => "S'ha registrat un nou participant:",

            // Text-to-speech
            "tts" => false,

            // Embeds Array
            "embeds" => [
                [
                    // Embed Title
                    "title" => "Nom: "
                        . $nom . " " . $cognoms,

                    // Embed Type
                    "type" => "rich",

                    // Embed Description
                    "description" => "L'usuari s'ha registrat des de la IP:" . $_SERVER['REMOTE_ADDR'],

                    // Timestamp of embed must be formatted as ISO8601
                    "timestamp" => $timestamp,

                    // Embed left border color in HEX
                    "color" => hexdec("3366ff"),

                    // Footer
                    "footer" => [
                        "text" => "Albert Rocas",
                        "icon_url" => "https://github.com/fluidicon.png"
                    ],

                    // Image to send
                    "image" => [
                        "url" => "http://{$_SERVER['HTTP_HOST']}/{$filePath}"
                    ],

                    // Additional Fields array
                    "fields" => [
                        // Field 1
                        [
                            "name" => "Ciutat: " . $ciutat,
                            "value" => "Carrer: " . $carrer,
                            "inline" => false
                        ]
                    ]
                ]
            ]

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


        $ch = curl_init($webhookurl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        curl_close($ch);

    }
}