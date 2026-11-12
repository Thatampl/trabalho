
<?php

require_once __DIR__ . '/../model/tarefa.php';
require_once __DIR__ . '/../model/usuario.php';

class tarefaController {

    private $tarefaModel;

    public function __construct() {
        $this->tarefaModel = new Tarefa();
    }

    public function index() {

        if (!isset($_SESSION['id'])) {
            header("Location: index.php");
            exit;
        }

        $tarefas = $this->tarefaModel->listar($_SESSION['id']);

        include __DIR__ . '/../view/listar.php';
    }

    public function criar() {

        if (!isset($_SESSION['id'])) {
            header("Location: index.php");
            exit;
        }

        if (
            isset($_POST['descricao']) &&
            !empty(trim($_POST['descricao']))
        ) {
            $this->tarefaModel->criar(
                $_POST['descricao'],
                $_SESSION['id']
            );
        }

        header("Location: index.php?action=tarefas");
        exit;
    }

    public function excluir() {

        if (!isset($_SESSION['id'])) {
            header("Location: index.php");
            exit;
        }

        if (isset($_GET['id'])) {
            $this->tarefaModel->excluir(
                $_GET['id'],
                $_SESSION['id']
            );
        }

        header("Location: index.php?action=tarefas");
        exit;
    }

    public function editar() {

        if (!isset($_SESSION['id'])) {
            header("Location: index.php");
            exit;
        }

        if (
            isset($_POST['descricao']) &&
            !empty(trim($_POST['descricao'])) &&
            isset($_POST['id'])
        ) {
            $this->tarefaModel->editar(
                $_POST['descricao'],
                $_POST['id'],
                $_SESSION['id']
            );
        }

        header("Location: index.php?action=tarefas");
        exit;
    }
}

class UsuarioController {

    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuario();
    }

    public function index() {

        if (isset($_SESSION['id'])) {
            header("Location: index.php?action=painel");
            exit;
        }

        include __DIR__ . '/../view/login.php';
    }

    public function autenticar() {

        if (!isset($_POST['email'], $_POST['senha'])) {
            header("Location: index.php");
            exit;
        }

        $email = trim($_POST['email']);
        $senha = $_POST['senha'];

        if (empty($email) || empty($senha)) {
            $erro = "Preencha corretamente seu email ou senha";

            include __DIR__ . '/../view/login.php';
            exit;
        }

        $usuario = $this->usuarioModel->buscarPorEmail($email);

        if ($usuario && $senha === $usuario['senha']) {

            session_regenerate_id(true);

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            header("Location: index.php?action=painel");
            exit;
        }

        $erro = "E-mail ou senha incorretos";

        include __DIR__ . '/../view/login.php';
    }

    public function painel() {

        if (!isset($_SESSION['id'])) {
            header("Location: index.php");
            exit;
        }

        include __DIR__ . '/../view/painel.php';
    }

    public function logout() {

        $_SESSION = [];
        session_destroy();

        header("Location: index.php");
        exit;
    }
}

?>
