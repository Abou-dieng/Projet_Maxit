<?php

namespace App\Controller;

use App\Core\Abstract\AbstractController;
use App\Core\App;
use App\Core\Session;
use App\Entity\compte;
use App\Repository\CompteRepository;
use App\Entity\User;
use App\Service\CompteService;
use Symfony\Component\Yaml\Yaml;

class ClientController extends AbstractController
{
    protected $layout = 'client.layout';
    private CompteService $compteService;

    public function __construct()
    {

        parent::__construct();
        $this->compteService = App::getDependency('compteService');
    }
    public function index()
    {
        $user = $this->session->get('user');
        $user = User::toObject($user);

        $listComptes = $this->compteService->getComptesByUser($user);

        $comptePrincipal = null;
        $comptesSecondaires = [];
        foreach ($listComptes as $compte) {
            if ($compte->getTypeCompte() && $compte->getTypeCompte()->value === 'Principal') {
                $comptePrincipal = $compte;
            } else {
                $comptesSecondaires[] = $compte;
            }
        }

        // Récupérer les transactions du compte principal
        $transactions = [];
        if ($comptePrincipal) {
            $transactions = CompteRepository::getInstance()->getTransactionsByCompte($comptePrincipal->getId());
        }

        $data = [
            'comptePrincipal' => $comptePrincipal ? $comptePrincipal->toArray() : null,
            'comptesSecondaires' => array_map(fn($compte) => $compte->toArray(), $comptesSecondaires),
            'transactions' => $transactions
        ];

        $this->session->set('comptePrincipal', $data['comptePrincipal']);
        $this->session->set('comptesSecondaires', $data['comptesSecondaires']);
        $this->renderHtml('client/index', $data);
    }
    public function create()
    {
        $oldLayout = $this->layout;
        $this->layout = 'security.layout';
        $this->renderHtml('login/register');
        $this->layout = $oldLayout;
    }

    public function showTransactions()
    {
        $user = $this->session->get('user');
        if (!$user) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            header('Location: /login');
            exit;
        }
        $user = User::toObject($user);
        $listComptes = $this->compteService->getComptesByUser($user);
        $comptePrincipal = null;
        $comptesSecondaires = [];
        foreach ($listComptes as $compte) {
            if ($compte->getTypeCompte() && $compte->getTypeCompte()->value === 'Principal') {
                $comptePrincipal = $compte;
                var_dump($compte);
                die();
            } else {
                $comptesSecondaires[] = $compte;
            }
        }

        // Gestion du changement de compte
        $selectedCompteId = $_GET['compte_id'] ?? ($comptePrincipal ? $comptePrincipal->getId() : null);
        $selectedCompte = null;
        foreach ($listComptes as $compte) {
            if ($compte->getId() == $selectedCompteId) {
                $selectedCompte = $compte;
                break;
            }
        }
        $transactions = [];
        if ($selectedCompte) {
            $transactions = CompteRepository::getInstance()->getTransactionsByCompte($selectedCompte->getId());
        }

        // Pour les filtres et pagination (préparation, à compléter selon besoin)
        $statuts = ['Termine', 'Annuler', 'En cours'];
        $types = ['Depot', 'Retrait', 'Transfert', 'Paiement', 'Facture'];

        $this->renderHtml('client/transactions', [
            'comptePrincipal' => $comptePrincipal ? $comptePrincipal->toArray() : null,
            'comptesSecondaires' => array_map(fn($c) => $c->toArray(), $comptesSecondaires),
            'selectedCompte' => $selectedCompte ? $selectedCompte->toArray() : null,
            'selectedCompteId' => $selectedCompteId,
            'transactions' => $transactions,
            'statuts' => $statuts,
            'types' => $types,
            // 'pagination' => $pagination, // à ajouter si besoin
        ]);
    }
}
