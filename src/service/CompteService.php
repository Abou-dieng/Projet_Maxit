<?php
namespace App\Service;
use App\Core\App;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Repository\CompteRepository;
use Attribute;

class CompteService {

  private static ?CompteService $instance = null;
  
    private CompteRepository $compteRepository;

   public function __construct()
   {
       $this->compteRepository=App::getDependency('compteRepository');
   }

   public static function getInstance(): CompteService
   {
       if (self::$instance === null) {
           self::$instance = new CompteService();
       }
       return self::$instance; 
   }

   public function getComptesByUser($user){

return $this->compteRepository->findByUser($user);
   }
    public function getTransactionsByCompte($compte_id) {
         return $this->compteRepository->getTransactionsByCompte($compte_id);
    }
} 