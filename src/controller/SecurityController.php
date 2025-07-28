<?php

namespace App\Controller;

ini_set('display_errors', 1);

use App\Core\Abstract\AbstractController;
use App\Core\Validator;
use App\Service\SecurityService;
use App\Entity\User;
use App\Core\App;
use Exception;
use Throwable;

use App\Repository\UserRepository;

class SecurityController extends AbstractController
{
    private SecurityService $securityService;


    public function __construct()

    {
        parent::__construct();
        $this->securityService = App::getDependency('securityService');
    }

    public function index()
    {
        // Récupérer les messages de session
        $errors = $this->session->get('errors') ?? [];
        $success = $this->session->get('success') ?? '';

        // Nettoyer les messages de session après récupération
        $this->session->unset('errors');
        $this->session->unset('success');

        $this->renderHtml('login/login', compact('errors', 'success'));
    }

    public function login()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //$login = $_POST['login'] ?? '';
            //$password = $_POST['password'] ?? '';
            $post = [
                'login' => trim($_POST['login'] ?? ''),
                'password' => trim($_POST['password'])
            ];
            //min:8
            Validator::validate(
                $post,
                [
                    'login' => ['required', 'senegal_phone'],
                    'password' => ['required']
                ]

            );

            //  var_dump(Validator::getErrors());
            //  die();
            //    var_dump($post);
            //    die();
            if (Validator::isValid()) {
                extract($post);
                $user = $this->securityService->seConnecter($login, $password);


                if ($user) {

                    $this->session->set('user', $user->toArray());


                    header('Location: /client/index');
                    exit();
                } else {
                    Validator::addError('globalError', 'login ou motdepass incorrect');

                    $this->session->set('errors', Validator::getErrors());


                    header('Location: /login');
                    exit();
                }
            }
            $this->session->set('errors', Validator::getErrors());

            // var_dump($_SESSION['globalError']);
            // die();
            header('Location: /login');
            exit();
        }

        // Récupérer les messages de session
        $errors = $this->session->get('errors') ?? [];
        $success = $this->session->get('success') ?? '';

        // Nettoyer les messages de session après récupération
        $this->session->unset('errors');
        $this->session->unset('success');

        $this->renderHtml('login/login', compact('errors', 'success'));
    }





    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => trim($_POST['nom'] ?? ''),
                'prenom' => trim($_POST['prenom'] ?? ''),
                'login' => trim($_POST['phone'] ?? ''), // login = téléphone
                'password' => trim($_POST['password'] ?? ''),
                'phone' => trim($_POST['phone'] ?? ''),
                'adresse' => trim($_POST['adresse'] ?? ''),
                'numerosCarteIdentite' => trim($_POST['numerosCarteIdentite'] ?? ''),
                'date_naissance' => $_POST['date_naissance'] ?? null,
                'lieu_naissance' => trim($_POST['lieu_naissance'] ?? ''),
                'copie_cni' => trim($_POST['copie_cni'] ?? ''),
            ];

            // Validation simple (à adapter selon ton Validator)
            Validator::validate($data, [
                'nom' => ['required', 'min:2', 'max:50'],
                'prenom' => ['required', 'min:2', 'max:50'],
                'phone' => ['required', 'senegal_phone'],
                'password' => ['required', 'min:4'],
                'adresse' => ['required'],
                'numerosCarteIdentite' => ['required', 'min:10', 'max:20'],
                // 'copie_cni' => ['required'], // Optionnel car rempli par l'API
                'date_naissance' => ['required'],
                'lieu_naissance' => ['required'],
            ]);

            if (!Validator::isValid()) {
                $this->session->set('errors', Validator::getErrors());
                header('Location: /register');
                exit;
            }

            // Ici, tu dois appeler ton service pour enregistrer l'utilisateur
            $user = $this->securityService->register($data);

            if ($user) {
                $this->session->set('success', 'Compte créé avec succès ! Vous pouvez maintenant vous connecter.');
                header('Location: /login');
                exit;
            } else {
                $this->session->set('errors', ['globalError' => 'Erreur lors de la création du compte. Veuillez réessayer.']);
                header('Location: /register');
                exit;
            }
        }

        // GET : afficher le formulaire
        $this->renderHtml('login/register');
    }

    public function create() {}
    public function logout()
    {
        $this->session->Destroy();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Location: /login');
            exit;
        }
        header('Location: /client/index');
        exit;
    }
}
