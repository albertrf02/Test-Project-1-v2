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

                $send = $this->sendTo();
                $response->set("send", $send);

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

    public function sendTo()
    {
        //=======================================================================================================
        // Create new webhook in your Discord channel settings and copy&paste URL
        //=======================================================================================================

        $webhookurl = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/webhook.txt', true);

        //=======================================================================================================
        // Compose message. You can use Markdown
        // Message Formatting -- https://discordapp.com/developers/docs/reference#message-formatting
        //========================================================================================================

        $timestamp = date("c", strtotime("now"));

        $json_data = json_encode([
            // Message
            "content" => "S'ha registrat un nou participant:",

            // Avatar URL.
            // Uncoment to replace image set in webhook
            //"avatar_url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=512",

            // Text-to-speech
            "tts" => false,

            // File upload
            // "file" => "",

            // Embeds Array
            "embeds" => [
                [
                    // Embed Title
                    "title" => "Nom, "
                        . $_POST['name'] . " " . $_POST['surname'],

                    // Embed Type
                    "type" => "rich",

                    // Embed Description
                    "description" => "L'usuari s'ha registrat des de la IP: " . $_SERVER['REMOTE_ADDR'],

                    // URL of title link
                    "url" => "https://gist.github.com/Mo45/cb0813cb8a6ebcd6524f6a36d4f8862c",

                    // Timestamp of embed must be formatted as ISO8601
                    "timestamp" => $timestamp,

                    // Embed left border color in HEX
                    "color" => hexdec("3366ff"),

                    // Footer
                    "footer" => [
                        "text" => "GitHub.com/Mo45",
                        "icon_url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=375"
                    ],

                    // Image to send
                    "image" => [
                        "url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=600"
                    ],

                    // Thumbnail
                    //"thumbnail" => [
                    //    "url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=400"
                    //],

                    // Author
                    "author" => [
                        "name" => "krasin.space",
                        "url" => "https://krasin.space/"
                    ],

                    // Additional Fields array
                    "fields" => [
                        // Field 1
                        [
                            "name" => "Field #1 Name",
                            "value" => "Field #1 Value",
                            "inline" => false
                        ],
                        // Field 2
                        [
                            "name" => "Field #2 Name",
                            "value" => "Field #2 Value",
                            "inline" => true
                        ]
                        // Etc..
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
        // If you need to debug, or find out why you can't send message uncomment line below, and execute script.
// echo $response;
        curl_close($ch);

    }
}