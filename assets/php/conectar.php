<?php
class conectar extends PDO
{
    private static $instancia;
    private $query;
    private $host = "127.0.0.1";
    private $usuario = "root";
    private $senha = "";
    private $db = "odontoKids";

    public function __construct()
    {
        parent::__construct("mysql:host=$this->host;dbname=$this->db", "$this->usuario", "$this->senha");
    }
    public static function getInstance(){
        if(!isset(self::$instancia)){
            try {
                self::$instancia = new conectar();
                echo 'Conectado com sucesso!!!';
            }
            catch(Exception $e){
                echo 'Erro ao conectar';
                exit();
            }
        }
        return self::$instancia;
    }
    public function sql($query, $params = [])
    {
        $stmt = self::$instancia->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
}
?>