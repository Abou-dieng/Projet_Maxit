<?php
namespace App\Entity;
 use App\Core\Abstract\AbstractEntity;

class Role extends AbstractEntity {
    private int $id;
    private string $nom;

 public function __construct(int $id = 0, 
        string $nom = ''
    ){
        $this->id = $id;
        $this->nom = $nom;
    }
 public function toArray(): array {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
        ];
    }
    public static function toObject(array $data): self {
        $role = new self();
        $role->id = $data['id'] ?? 0;
        $role->nom = $data['nom'] ?? '';
        return $role;
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
}