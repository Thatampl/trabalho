<?php 
require_once __DIR__ . '/../config/database.php';

class Tarefa {
    private $conn; 

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    public function listar($usuario_id) {
        $tarefas = []; 
        $usuario_id = intval($usuario_id);
        $sql = "SELECT * FROM tarefas WHERE usuario_id = $usuario_id ORDER BY data_criacao DESC"; 
        $resultado = $this->conn->query($sql); 

        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $tarefas[] = $row; 
            }
        }
        return $tarefas; 
    }

    public function criar($descricao, $usuario_id) {
        $descricao = $this->conn->real_escape_string($descricao);
        $usuario_id = intval($usuario_id);
        $sql = "INSERT INTO tarefas (descricao, usuario_id) VALUES ('$descricao', $usuario_id)";
        return $this->conn->query($sql); 
    }

    public function excluir($id) {
        $id = intval($id);
        $sql = "DELETE FROM tarefas WHERE id = $id"; 
        return $this->conn->query($sql); 
    }

    public function editar($descricao, $id) {
        $id = intval($id);
        $descricao = $this->conn->real_escape_string($descricao);
        $sql = "UPDATE tarefas SET descricao = '$descricao' WHERE id = $id"; 
        return $this->conn->query($sql); 
    }
}
