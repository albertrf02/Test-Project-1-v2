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
class Users
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

    public function getUser($token)
    {
        $query = 'select * from participants where token=:token;';
        $stm = $this->sql->prepare($query);
        $stm->execute([':token' => $token]);

        if ($stm->errorCode() !== '00000') {
            $err = $stm->errorInfo();
            $code = $stm->errorCode();
            die("Error.   {$err[0]} - {$err[1]}\n{$err[2]} $query");
        }

        return $stm->fetch(\PDO::FETCH_ASSOC);
    }

    public function getCardsByUser($token)
    {
        $query = 'SELECT resguards.*
        FROM resguards
        JOIN participants ON resguards.idParticipant = participants.id
        WHERE participants.token = :token;';
        $stm = $this->sql->prepare($query);
        $stm->execute([':token' => $token]);

        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function uploadCard($id)
    {
        $query = 'INSERT INTO resguards (idParticipant, path) VALUES (:id, :path);';
        $stm = $this->sql->prepare($query);
        $stm->execute([':id' => $id, ':path' => $_FILES['card']['name']]);

        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getParticipantById($id)
    {
        $query = 'select * from participants where id=:id;';
        $stm = $this->sql->prepare($query);
        $stm->execute([':id' => $id]);

        if ($stm->errorCode() !== '00000') {
            $err = $stm->errorInfo();
            $code = $stm->errorCode();
            die("Error.   {$err[0]} - {$err[1]}\n{$err[2]} $query");
        }

        return $stm->fetch(\PDO::FETCH_ASSOC);
    }

}