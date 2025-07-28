<?php
namespace App\Entity;
use App\Core\Abstract\AbstractEntity;

 class transaction extends AbstractEntity {
    private int $id;
    private string $typetransaction ;
    private float $montant;
    private string $date;
    private Compte $compte;

    

public function __construct(int $id = 0, string $typetransaction = '', float $montant = 0.0, string $date = '') {
        $this->id = $id;
        $this->typetransaction = $typetransaction;
        $this->montant = $montant;
        $this->date = $date;
        $this->compte = new Compte();   
    }
    public static function toObject(array $data): self {
        $transaction = new self();
        $transaction->setId($data['id'] ?? 0);
        $transaction->setTypetransaction($data['typetransaction'] ?? '');
        $transaction->setMontant($data['montant'] ?? 0.0);
        $transaction->setDate($data['date'] ?? '');
        
      

        $compte = new Compte();
        $compte->setId($data['compte_id'] ?? 0);
        $transaction->compte = $compte;

        return $transaction;
    }
    public function toArray(): array {
        return [
            'id' => $this->getId(),
            'typetransaction' => $this->getTypetransaction(),
            'montant' => $this->getMontant(),
            'date' => $this->getDate(),
            'compte' => $this->getCompte()->toArray(),
        ];
    }

 
    /**
     * Get the value of compte
     */ 
    public function getCompte()
    {
        return $this->compte;
    }

    /**
     * Set the value of compte
     *
     * @return  self
     */ 
    public function setCompte($compte)
    {
        $this->compte = $compte;

        return $this;
    }

    /**
     * Get the value of typetransaction
     */ 
    public function getTypetransaction()
    {
        return $this->typetransaction;
    }

    /**
     * Set the value of typetransaction
     *
     * @return  self
     */ 
    public function setTypetransaction($typetransaction)
    {
        $this->typetransaction = $typetransaction;

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
     * Get the value of montant
     */ 
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set the value of montant
     *
     * @return  self
     */ 
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }
 }