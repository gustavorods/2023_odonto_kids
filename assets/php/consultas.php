<?php
include_once 'Conectar.php';

class Consulta {
    // Propriedades da classe, correspondendo aos campos da tabela
    private $id;
    private $responsavel_id;
    private $horario;
    private $data;
    private $id_dependente;
    private $cod_tratamento;
    private $relatorio;
    private $id_medico;
    private $conn;

    // Método construtor para instanciar a conexão uma única vez
    public function __construct() {
        $this->conn = new Conectar(); // Estabelecendo a conexão
    }

    
    public function setId($id) { $this->id = $id; }
    public function setResponsavelId($responsavel_idd) { $this->responsavel_id = $responsavel_idd; }
    public function setHorario($horario) { $this->horario = $horario; }
    public function setData($data) { $this->data = $data; }
    public function setIdDependente($id_dependente) { $this->id_dependente = $id_dependente; }
    public function setCodTratamento($cod_tratamento) { $this->cod_tratamento = $cod_tratamento; }
    public function setRelatorio($relatorio) { $this->relatorio = $relatorio; }
    public function setIdMedico($id_medico) { $this->id_medico = $id_medico; }

    // Método para listar todas as consultas por ID responsavel
    function listarPorIdResponsavel() {
        try {
            $this->conn = new Conectar();

            $sql = $this->conn->prepare("
                SELECT * 
                FROM consulta 
                JOIN dependentes ON consulta.id_dependente = dependentes.id
                WHERE dependentes.id_responsavel = ? 
                AND consulta.status_consulta != 1;
            ");
            $sql->bindParam(1, $this->responsavel_id, PDO::PARAM_INT);

            $sql->execute();

            $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
            // var_dump($resultado);
            // Verificar se algum dado foi retornado
            if (count($resultado) > 0) {
                $result_cont = true;
            }
            else{
                $result_cont = false;
            }

            $this->conn = null;
            
            return $result_cont;
        } catch (PDOException $exp) {
            echo "Erro ao puxar consultas. " . $exp->getMessage();
        }
    }    

    public function recuperar_relatorio() {
        try {
            $sql = $this->conn->prepare("SELECT relatorio FROM consulta WHERE id = ?");
            $sql->bindParam(1, $this->id, PDO::PARAM_INT);
            $sql->execute();
            return $sql->fetchColumn(); // Retorna diretamente o valor do relatório
        } catch (PDOException $exp) {
            // Exibe o erro de maneira mais informativa, sem comprometer a segurança
            error_log("Erro ao recuperar relatório: " . $exp->getMessage());
            return false;
        }
    }

    // Atualização do relatório com verificação do sucesso
    public function enviar_relatorio() {
        try {
            $sql = $this->conn->prepare("UPDATE consulta SET relatorio = ? WHERE id = ?");
            $sql->bindParam(1, $this->relatorio, PDO::PARAM_STR);
            $sql->bindParam(2, $this->id, PDO::PARAM_INT);
            $sql->execute();

            // Retorna sucesso ou falha com base no número de linhas afetadas
            return $sql->rowCount() > 0;
        } catch (PDOException $exp) {
            error_log("Erro ao enviar relatório: " . $exp->getMessage());
            return false;
        }
    }

    // Fechando a conexão de forma centralizada
    public function __destruct() {
        $this->conn = null;
    }
}
?>
