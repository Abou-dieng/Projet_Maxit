<?php
use App\Controller\SecurityController;
use App\Controller\ClientController;
use App\Core\Abstract\ErrorController;
use App\Core\midelleware\Midelleware;

$routes = [
'/' => [
    'controller' => SecurityController::class,
    'action' => 'index',
],
'/login' => [
    'controller' => SecurityController::class,
    'action' => 'login',
],
'/register' => [
    'controller' => SecurityController::class,
    'action' => 'register',
],
'/account' => [
    'controller' => ClientController::class,
    'action' => 'index',
],
'/login/register' => [
    'controller' => ClientController::class,
    'action' => 'create',
],
'/error/404' => [
    'controller' => ErrorController::class,
    'action' => 'notFound',
],
'/client/index' => [
    'controller' => ClientController::class,
    'action' => 'index',
    'midellewares'=>['auth']
],
'/client/transactions' => [
    'controller' => ClientController::class,
    'action' => 'showTransactions',
    // 'midellewares'=>['auth']
],
// ...existing code...
'/logout' => [
    'controller' => SecurityController::class,
    'action' => 'logout',
],


];
