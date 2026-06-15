<?php

require_once __DIR__ . '/app/controllers/UsuariosController.php';
require_once __DIR__ . '/app/controllers/AuthController.php';
require_once __DIR__ . '/app/middleware/auth.php';

$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'login';

switch ($controller) {
    case 'auth':
        $authController = new AuthController();

        switch ($action) {
            case 'login':
                $usuarioController->exibirLogin();
                break;

            case 'entrar':
                $usuarioController->entrar();
                break;

            case 'dashboard':
                $usuarioController->dashboard();
                break;

            case 'logout':
                $usuarioController->logout();
                break;

            default:
                http_response_code(404);
                echo 'Ação de autenticacao não encontrada.';
        }
        break;

    case 'usuarios':
        exigirAutenticacao();
        $usuarioController = new UsuariosController();

        switch ($action) {
            case 'listar':
                $usuarioController->listar();
                break;

            case 'buscarPorId':
                $usuarioController->buscarPorId();
                break;

            case 'criar':
                $usuarioController->criar();
                break;

            case 'atualizar':
                $usuarioController->atualizar();
                break;

            case 'excluir':
                $usuarioController->excluir();
                break;

            default:
                http_response_code(404);
                echo 'Ação de usuários não encontrada.';
        }
        break;

    default:
        http_response_code(404);
        echo 'Controller nao encontrado';
}