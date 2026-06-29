<?php

require_once __DIR__ . '/app/middleware/auth.php';
require_once __DIR__ . '/app/controllers/UsuariosController.php';
require_once __DIR__ . '/app/controllers/AuthController.php';
require_once __DIR__ . '/app/controllers/PessoasController.php';
require_once __DIR__ . '/app/controllers/TiposAtendimentosController.php';
require_once __DIR__ . '/app/controllers/AtendimentosController.php';
require_once __DIR__ . '/app/controllers/FrontendController.php';

$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'login';

if ($controller === 'auth') {
    $authController = new AuthController();

    switch ($action) {
        case 'login':
            $authController->exibirLogin();
            break;

        case 'entrar':
            $authController->entrar();
            break;

        case 'dashboard':
            exigirAutenticacao();
            $authController->dashboard();
            break;

        case 'logout':
            $authController->logout();
            break;

        default:
            http_response_code(404);
            echo 'Ação de autenticacao não encontrada.';
    }
    exit;
}

exigirAutenticacao();

switch ($controller) {
    case 'usuarios':
        $obj = new UsuariosController();
        break;
    case 'pessoas':
        $obj = new PessoasController();
        break;
    case 'tipos':
        $obj = new TiposAtendimentosController();
        break;
    case 'atendimentos':
        $obj = new AtendimentosController();
        break;
    case 'frontend':
        $obj = new FrontendController();
        break;
    default:
        http_response_code(404);
        exit('Controller nao encontrado');
}

if (!method_exists($obj, $action)) {
    http_response_code(404);
    exit('Ação não encontrada.');
}

$obj->$action();