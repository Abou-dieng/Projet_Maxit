<?php
namespace App\Entity;
use App\Core\Abstract\AbstractEntity;
use DateTime;

 class User  extends AbstractEntity {
    private int $id;
    private string $prenom;
    private string $nom;
    private string $login;
    private string $password;
    private Role $role;
    private string $adresse;
    private array $comptes = [];
    private string  $nin;
    private string $copie_cni;
    private ?DateTime $dateNaissance;
    private string $lieuNaissance;

 public function  __construct(int $id = 0, string $prenom = '', string $nom = '', string $login = '', string $password = '', string $adresse = '', string $nin = '', string $copie_cni = '', ?DateTime $dateNaissance = null, string $lieuNaissance = '') {

        $this->id = $id;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->login = $login;
        $this->password = $password;
        $this->role = new Role;
        $this->adresse = $adresse;
        $this->nin = $nin;
        $this->copie_cni = $copie_cni;
        $this->dateNaissance = $dateNaissance;
        $this->lieuNaissance = $lieuNaissance;
    }
    public function toArray(): array {
        return [
            'id' => $this->getId(),
            'prenom' => $this->getPrenom(),
            'nom' => $this->getNom(),
            'login' => $this->getLogin(),
            'password' => $this->getPassword(),
            'role' => $this->getRole()->toArray(),
            'adresse' => $this->getAdresse(),
            'nin' => $this->getNin(),
            'copie_cni' => $this->getCopieCni(),
            'date_naissance' => $this->dateNaissance ? $this->dateNaissance->format('Y-m-d H:i:s') : null,
            'lieu_naissance' => $this->getLieuNaissance(),
            'comptes' => array_map(fn($compte) => $compte->toArray(), $this->comptes),
        ];
    }
    public static function toObject(array $data): self {
        $user = new self();
        $user->setId($data['id'] ?? 0);
        $user->setPrenom($data['prenom'] ?? '');
        $user->setNom($data['nom'] ?? '');
        $user->setLogin($data['login'] ?? '');
        $user->setPassword($data['password'] ?? '');
        $role = new Role();
        $role->setId($data['role_id'] ?? 0);
        $user->setRole($role);
        $user->setAdresse($data['adresse'] ?? '');
        $user->setNin($data['nin'] ?? '');
        $user->setCopieCni($data['copie_cni'] ?? '');
        return $user;
    }
 



    /**
     * Get the value of comptes
     */ 
    public function getComptes()
    {
        return $this->comptes;
    }

    /**
     * Set the value of comptes
     *
     * @return  self
     */ 
    public function addCompte($compte)
    {
        $this->comptes[] = $compte;

        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

   
   

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of prenom
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of login
     */ 
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set the value of login
     *
     * @return  self
     */ 
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    

    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     *
     * @return  self
     */ 
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get the value of copie_cni
     */ 
    public function getCopieCni()
    {
        return $this->copie_cni;
    }

    /**
     * Set the value of copie_cni
     *
     * @return  self
     */ 
    public function setCopieCni($copie_cni)
    {
        $this->copie_cni = $copie_cni;

        return $this;
    }

    /**
     * Get the value of photoverso
     */ 
  

    /**
     * Get the value of nin
     */ 
    public function getNin()
    {
        return $this->nin;
    }

    /**
     * Set the value of nin
     *
     * @return  self
     */ 
    public function setNin($nin)
    {
        $this->nin = $nin;

        return $this;
    }

    /**
     * Get the value of dateNaissance
     */ 
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set the value of dateNaissance
     *
     * @return  self
     */ 
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get the value of lieuNaissance
     */ 
    public function getLieuNaissance()
    {
        return $this->lieuNaissance;
    }

    /**
     * Set the value of lieuNaissance
     *
     * @return  self
     */ 
    public function setLieuNaissance($lieuNaissance)
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }
}

