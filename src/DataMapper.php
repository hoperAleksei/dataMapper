<?php

require_once 'Data.php';
require_once 'Repository.php';

class DataMapper
{
    private PDO $dbh;

    public function __construct($dbh)
    {
        $this->dbh = $dbh;
    }

    public function save(Data $data)
    {
        if ($data->id) {
            if (!empty($this->find(new Data(null,$data->id)))) {
                $sql = "UPDATE data SET message = :message WHERE id = :id";
            } else {
                $sql = "INSERT INTO data (message, id) VALUES (:message, :id)";
            }

            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':id', $data->id);
        } else {
            $sql = "INSERT INTO data (message) VALUES (:message)";
            $sth = $this->dbh->prepare($sql);
        }
        $sth->bindParam(':message', $data->message);
        $sth->execute();
    }

    public function delete($id) {
            $sql = "DELETE FROM data WHERE id = ?";
            $sth = $this->dbh->prepare($sql);
            $sth->execute([$id]);
    }

    public function find(Data $data) {
        if ($data->id AND $data->message) {
            $sql = "SELECT * FROM data WHERE id = ? AND message = ?";
            $sth = $this->dbh->prepare($sql);
            $sth->execute([$data->id, $data->message]);
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        } else if ($data->id) {
            $sql = "SELECT * FROM data WHERE id = ?";
            $sth = $this->dbh->prepare($sql);
            $sth->execute([$data->id]);
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        } else if ($data->message) {
            $sql = "SELECT * FROM data WHERE message = ?";
            $sth = $this->dbh->prepare($sql);
            $sth->execute([$data->message]);
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $sql = "SELECT * FROM data";
            $sth = $this->dbh->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        }
        return $result;
    }
}