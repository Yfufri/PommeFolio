<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/app/controllers/' . $class . '.php',
        __DIR__ . '/app/models/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});


$action = $_GET['action'] ?? 'home';

// mapping simple action -> contrôleur/méthode
switch ($action) {
    case 'home':
        (new HomeController())->index();
        break;

    case 'voyage-paris':
        $controller = new CultureController();
        $controller->voyageParis();
        break;

    case 'but':
        (new ButController())->index();
        break;
    case 'but-competence':
        (new ButController())->competence();
        break;

    case 'culture':
        (new CultureController())->index();
        break;

    case 'login':
        (new AuthController())->loginForm();
        break;
    case 'login-submit':
        (new AuthController())->login();
        break;
    case 'logout':
        (new AuthController())->logout();
        break;

    // admin
    case 'admin':
        (new AdminController())->index();
        break;

    case 'admin-competences':
        (new AdminController())->competencesList();
        break;
    case 'admin-competences-create':
        (new AdminController())->competencesCreateForm();
        break;
    case 'admin-competences-store':
        (new AdminController())->competencesStore();
        break;
    case 'admin-competences-edit':
        (new AdminController())->competencesEditForm();
        break;
    case 'admin-competences-update':
        (new AdminController())->competencesUpdate();
        break;
    case 'admin-competences-delete':
        (new AdminController())->competencesDelete();
        break;
    case 'admin-competences-manage':
        (new AdminController())->competencesManage();
        break;

    case 'admin-ac-create':
        (new AdminController())->acCreateForm();
        break;
    case 'admin-ac-store':
        (new AdminController())->acStore();
        break;
    case 'admin-ac-edit':
        (new AdminController())->acEditForm();
        break;
    case 'admin-ac-update':
        (new AdminController())->acUpdate();
        break;
    case 'admin-ac-delete':
        (new AdminController())->acDelete();
        break;

    case 'admin-illustrations':
        (new AdminController())->illustrationsManage();
        break;
    case 'admin-illustrations-store':
        (new AdminController())->illustrationsStore();
        break;
    case 'admin-illustrations-delete':
        (new AdminController())->illustrationsDelete();
        break;

    default:
        (new ErrorController())->notFound();
        break;
}