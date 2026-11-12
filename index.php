<?php
session_start();

require_once __DIR__ . '/app/controller/controller.php';

$acao = $_GET['action'] ?? 'index';

/*
 * A tela inicial continua sendo o login.
 * Para abrir a lista de tarefas, use index.php?action=tarefas.
 */
$usuarioController = new UsuarioController();
$tarefaController = new tarefaController();

switch ($acao) {
    // Autenticação e área do usuário
    case 'autenticar':
        $usuarioController->autenticar();
        break;

    case 'painel':
        $usuarioController->painel();
        break;

    case 'logout':
        $usuarioController->logout();
        break;

    // Tarefas
    case 'tarefas':
        $tarefaController->index();
        break;

    case 'Criar':
        $tarefaController->criar();
        break;

    case 'excluir':
        $tarefaController->excluir();
        break;

    case 'editar':
        $tarefaController->editar();
        break;

    // Página inicial/login
    case 'index':
    default:
        $usuarioController->index();
        break;
}
?>
