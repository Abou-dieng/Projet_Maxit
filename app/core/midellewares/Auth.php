<?php
namespace App\Core\Midellwares;

use App\Core\Session;


class Auth{

       private Session $session;
          public function __construct()
          {
               $this->session=Session::getInstance();
          } 
     public function __invoke()
     {
        
        //dd( $this->session->get('user'));
          if (!isset($_SESSION['user'])){
           header("Location: /login");
           exit;
          }
     }

}



