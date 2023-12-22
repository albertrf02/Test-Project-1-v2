<?php

/**
 * Exemple per a M07.
 * @author: Dani Prados dprados@cendrassos.net
 *
 * Model pels usuaris.
 *
 **/

namespace App\Models;

/**
 * Imatges
 */
class Formulari
{

    private $sql;
    private $options = [];

    /**
     * __construct:  Crear el model tasques
     *
     * Model adaptat per PDO
     *
     * @param \App\Models\Db $conn connexió a la base de dades
     *
     **/

    public function __construct($conn, $options = ['cost' => 12])
    {
        $this->sql = $conn;
        $this->options = $options;
    }

    public function insertInscriptions($nom, $cognoms, $dataNaixement, $carrer, $numero, $ciutat, $codiPostal, $grup)
    {

        if (isset($_FILES['resguard']) && $_FILES['resguard']['error'] === 0) {
            $resguardPath = 'resguard/' . $_FILES['resguard']['name'];

            if (move_uploaded_file($_FILES['resguard']['tmp_name'], $resguardPath)) {
                $sql = "INSERT INTO participants (Nom, Cognoms, DataNaixement, Carrer, Numero, Ciutat, CP, Grup)
                        VALUES (:nom, :cognoms, :dataNaixement, :carrer, :numero, :ciutat, :codiPostal, :grup)";
                $stmt = $this->sql->prepare($sql);

                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':cognoms', $cognoms);
                $stmt->bindParam(':dataNaixement', $dataNaixement);
                $stmt->bindParam(':carrer', $carrer);
                $stmt->bindParam(':numero', $numero);
                $stmt->bindParam(':ciutat', $ciutat);
                $stmt->bindParam(':codiPostal', $codiPostal);
                $stmt->bindParam(':grup', $grup);

                if ($stmt->execute()) {
                    $resguardsql = "INSERT INTO resguard (path, idParticipants) VALUES (:path, :idParticipants)";
                    $resguardStmt = $this->sql->prepare($resguardsql);
                    $resguardStmt->bindParam(':path', $_FILES['resguard']['name']);
                    $resguardStmt->bindParam(':idParticipants', $this->sql->lastInsertId());
                    if ($resguardStmt->execute()) {
                        $userId = $this->sql->lastInsertId();
                        exit;
                    }
                }
                // ...
            } else {
                echo 'File upload failed. Debugging information: ';
                print_r($_FILES);
            }



        }
    }
}

