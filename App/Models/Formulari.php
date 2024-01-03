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

    public function generateRandomToken()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < 10; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    public function checkNomAndCognom($nom, $cognoms)
    {
        $query = 'select * from participants where nom=:nom and cognoms=:cognoms;';
        $stm = $this->sql->prepare($query);
        $stm->execute([':nom' => $nom, ':cognoms' => $cognoms]);

        if ($stm->errorCode() !== '00000') {
            $err = $stm->errorInfo();
            $code = $stm->errorCode();
            die("Error.   {$err[0]} - {$err[1]}\n{$err[2]} $query");
        }

        return $stm->fetch(\PDO::FETCH_ASSOC);
    }

    public function insertInscriptions($nom, $cognoms, $dataNaixement, $carrer, $numero, $ciutat, $codiPostal, $grup)
    {

        if (isset($_FILES['resguard']) && $_FILES['resguard']['error'] === 0) {
            $resguardPath = $this->generateRandomToken() . $_FILES['resguard']['name'];

            if (move_uploaded_file($_FILES['resguard']['tmp_name'], 'resguard/' . $resguardPath)) {
                $sql = "INSERT INTO participants (nom, cognoms, token, dataNaixement, carrer, numero, ciutat, cp, grup)
                        VALUES (:nom, :cognoms, :token, :dataNaixement, :carrer, :numero, :ciutat, :codiPostal, :grup)";
                $stmt = $this->sql->prepare($sql);

                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':cognoms', $cognoms);
                $stmt->bindParam(':token', $this->generateRandomToken());
                $stmt->bindParam(':dataNaixement', $dataNaixement);
                $stmt->bindParam(':carrer', $carrer);
                $stmt->bindParam(':numero', $numero);
                $stmt->bindParam(':ciutat', $ciutat);
                $stmt->bindParam(':codiPostal', $codiPostal);
                $stmt->bindParam(':grup', $grup);

                if ($stmt->execute()) {
                    $idParticipant = $this->sql->lastInsertId();
                    $resguardsql = "INSERT INTO resguards (path, idParticipant) VALUES (:path, :idParticipant)";
                    $resguardStmt = $this->sql->prepare($resguardsql);
                    $resguardStmt->bindParam(':path', $resguardPath);
                    $resguardStmt->bindParam(':idParticipant', $idParticipant);

                    if ($resguardStmt->execute()) {
                        return $idParticipant;
                    } else {
                        echo "No s'ha pogut pujar el resguard";
                    }
                }
            }
        }
    }
}
