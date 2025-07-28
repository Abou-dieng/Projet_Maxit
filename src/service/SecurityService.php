<?php

namespace App\Service;

use App\Core\App;
use App\Entity\Compte;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Entity\Role; // N'oublie pas d'importer la classe Role
use App\Entity\TypeCompte;

class SecurityService
{
    private static ?SecurityService $securityService = null;
    private UserRepository $userRepository;

    private function __construct()
    {
        $this->userRepository = App::getDependency('userRepository');
    }

    public static function getInstance(): SecurityService
    {
        if (self::$securityService === null) {
            self::$securityService = new SecurityService();
        }
        return self::$securityService;
    }
    public function seConnecter(string $login, string $password)
    {

        $user = $this->userRepository->findByLogin($login);
        //    if (!$user || $user->getPassword() !== $password) {
        //        return null;
        //    }
        if (!$user || !password_verify($password, $user->getPassword())) {
            // var_dump('Mot de passe incorrect');die();
            return null;
        }
        return $user;
    }
    public function register(array $data): ?User
    {
        $existingUser = $this->userRepository->findByLogin($data['login']);
        if ($existingUser) {
            return null;
        }

        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $user = new User();
        $user->setNom($data['nom']);
        $user->setPrenom($data['prenom']);
        $user->setLogin($data['login']);
        $user->setPassword($hashedPassword);
        $user->setAdresse($data['adresse']);
        $user->setNin($data['numerosCarteIdentite']);

        // Ajouter la date de naissance et le lieu de naissance
        if (isset($data['date_naissance']) && !empty($data['date_naissance'])) {
            $user->setDateNaissance(new \DateTime($data['date_naissance']));
        }
        if (isset($data['lieu_naissance']) && !empty($data['lieu_naissance'])) {
            $user->setLieuNaissance($data['lieu_naissance']);
        }
        if (isset($data['copie_cni']) && !empty($data['copie_cni'])) {
            $user->setCopieCni($data['copie_cni']);
        }

        // var_dump($user);die();
        // Gestion du rôle
        $role = new Role();
        $role->setId(1); // ID 1 = Client (rôle par défaut)
        $user->setRole($role);

        $savedUser = $this->userRepository->insert($user);
        if (!$savedUser) {
            return null;
        }

        // Mettre à jour l'ID de l'utilisateur avec l'ID retourné par la base
        $user->setId($savedUser);

        $compte = new Compte();
        $compte->setUser($user);
        $compte->setSolde(0);
        // Générer un numéro de compte unique (utilise le numéro de téléphone)
        $numeroCompte = $user->getLogin();
        $compte->setNumero($numeroCompte);
        $compte->setTypeCompte(TypeCompte::PRINCIPAL);
        $compteSaved = App::getDependency('compteRepository')->insert($compte);
        if (!$compteSaved) {
            return null;
        }

        return $user;
    }
}
