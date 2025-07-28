<?php

namespace App\Core\Abstract;

class ErrorController
{
    public function notFound()
    {
       require_once __DIR__.'/../../../app/error/404.html.php';
    }
}
