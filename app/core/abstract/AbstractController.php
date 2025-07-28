<?php
namespace App\Core\Abstract;

use App\Core\Session;


abstract class AbstractController
{
     protected Session $session;
     protected $layout = 'security.layout';


    public function __construct()
    {
        $this->session=Session::getInstance();
       
    } 

    abstract public function index();
    abstract public function create();

    public function renderHtml($view, $data = [])
    {
        ob_start();
        extract($data);
        require_once __DIR__ . '/../../../templates/' . $view . '.php';
        $content = ob_get_clean();

        require_once __DIR__ . '/../../../templates/layouts/' . $this->layout . '.php';
    }

    public function redirect($url)
    {
        header("Location: $url");
        exit;
    }
}