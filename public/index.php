<?php

use function PHPSTORM_META\map;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../route/route.web.php';
require_once __DIR__ . '/../app/config/bootstrap.php';
use App\Core\Router;
use Symfony\Component\Yaml\Yaml;

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Correction Chrome DevTools 404
if (preg_match('#^/\.well-known/appspecific/com\.chrome\.devtools\.json$#', $_SERVER['REQUEST_URI'])) {
    header('Content-Type: application/json');
    echo json_encode([]);
    exit;
}

Router::resolve($routes);
 //$pdo = App\Core\Database::getConnection();
  //$stmt = $pdo->prepare("SELECT * FROM users");

  //$stmt->execute();
  //$users = $stmt->fetchAll();
 // var_dump($users);

    //       $deps=Yaml::parseFile(__DIR__.'/../app/config/service.yml');
    //  var_dump($deps);
    //      die;