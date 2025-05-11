<?php
include_once 'config/Database.php';
include_once 'clsPlanesDAO.php';
include_once 'models/clsPlanes.php';

class PlanesDAOImp implements PlanesDAO
{
    private static $instance = NULL;
    private $conn;

    public static function getInstance()
    {
        if (self::$instance == NULL) {
            self::$instance = new PlanesDAOImp();
        }
        return self::$instance;
    }

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll($limit = NULL, $conditions = NULL, $joins = NULL)
    {
        $array = [];
        $sql = "SELECT planes_id, placa, plan_descripcion, plan_valor
                FROM planes $joins " . (($conditions != NULL) ? " WHERE $conditions " : '')
                . (($limit != NULL) ? " LIMIT $limit " : '');
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll();
        } catch (PDOException $exc) {
            die('Error getAll() clsPlanesDAOImp:<br/>' . $exc->getMessage());
        }
        
        foreach ($rows as $row) {
            $objPlanes = new Planes(
                $row['placa'],
                $row['plan_descripcion'],
                $row['plan_valor']
            );

            $objPlanes->setId($row['planes_id']);
            $array[] = $objPlanes;
        }
        return $array;
    }
}
?>
