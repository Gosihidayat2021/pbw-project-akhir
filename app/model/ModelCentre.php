<?php
require_once 'Model.php';

class ModelCentre
{
    private $id, $label, $adresse;

    public function __construct($id = NULL, $label = NULL, $adresse = NULL)
    {
        if (!is_null($id)) {
            $this->id = $id;
            $this->label = $label;
            $this->adresse = $adresse;
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed|null
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed|null $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed|null
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed|null $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }


    public static function getAll()
    {
        try {
            $database = Model::getInstance();
            $query = "select * from centre";
            $statement = $database->prepare($query);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_CLASS, "ModelCentre");
            return $results;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }
    }

    public static function getOne($id)
    {
        try {
            $database = Model::getInstance();
            $query = "select * from centre where id = :id";
            $statement = $database->prepare($query);
            $statement->execute([
                'id' => $id
            ]);
            $results = $statement->fetchAll(PDO::FETCH_CLASS, "ModelCentre");
            return $results;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }
    }

    public static function getAllWithAtLeastOneShot()
    {
        try {
            $database = Model::getInstance();
            $query = "SELECT id, label, adresse FROM stock join centre on centre_id = id where quantite > 0 group by centre_id";
            $statement = $database->prepare($query);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_CLASS, "ModelCentre");
            return $results;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }
    }

    public static function getAllWithAtLeastOneShotWithVaccine($vaccin_id)
    {
        try {
            $database = Model::getInstance();
            $query = "SELECT id, label, adresse FROM stock join centre on centre_id = id where quantite > 0 and vaccin_id = :id group by centre_id";
            $statement = $database->prepare($query);
            $statement->execute(['id' => $vaccin_id]);
            $results = $statement->fetchAll(PDO::FETCH_CLASS, "ModelCentre");
            return $results;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }
    }

    public static function insert($label, $adresse)
    {
        try {
            $database = Model::getInstance();


            $query = "select max(id) from centre";
            $statement = $database->query($query);
            $tuple = $statement->fetch();
            $id = $tuple['0'];
            $id++;


            $query = "insert into centre value (:id, :label, :adresse)";
            $statement = $database->prepare($query);
            $statement->execute([
                'id' => $id,
                'label' => $label,
                'adresse' => $adresse
            ]);
            return $label;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return -1;
        }
    }

}