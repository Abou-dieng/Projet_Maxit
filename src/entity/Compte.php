<?php

namespace App\Entity;

use App\Core\Abstract\AbstractEntity;
use DateTime;

class Compte extends AbstractEntity
{
    private int $id;
    private string $numero;
    private float $solde;
    private ?DateTime $dateCreation;
    private User $user;
    private $transactions = [];
    private ?TypeCompte $typeCompte;


    public function __construct(int $id = 0, string $numero = '', float $solde = 0.0, ?DateTime $dateCreation = null, ?TypeCompte $typeCompte = null)
    {
        $this->id = $id;
        $this->numero = $numero;
        $this->solde = $solde;
        $this->dateCreation = $dateCreation;
        $this->user = new User();
        $this->typeCompte = $typeCompte;
    }
    public static function toObject(array $data): self
    {
        $compte = new self();
        $compte->setId($data['id'] ?? 0);
        $compte->setNumero($data['numeros'] ?? ''); // Correction: 'numeros' au lieu de 'numero'
        $compte->setSolde($data['solde'] ?? 0.0);
        $compte->setDateCreation(isset($data['date_creation']) ? new DateTime($data['date_creation']) : null);
        $compte->setTypeCompte(isset($data['typecompte']) ? TypeCompte::from($data['typecompte']) : null);
        $user = new User();
        $user->setId($data['user_id'] ?? 0);
        $compte->setUser($user);
        return $compte;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'numero' => $this->numero,
            'numeros' => $this->numero, // Alias pour la compatibilité avec le template
            'solde' => $this->solde,
            'dateCreation' => $this->dateCreation ? $this->dateCreation->format('Y-m-d H:i:s') : null,
            'typecompte' => $this->typeCompte ? $this->typeCompte->value : null,
            'user' => $this->user->toArray(),
            'transactions' => array_map(fn($transaction) => $transaction->toArray, $this->transactions),
        ];
    }



    /**
     * Get the value of transactions
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * Set the value of transactions
     *
     * @return  self
     */
    public function addTransactions($transaction)
    {
        $this->transactions = $transaction;

        return $this;
    }

    /**
     * Get the value of user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */
    public function setUser($user)
    {
        $this->user = $user;

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
     * Get the value of numero
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     *
     * @return  self
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get the value of solde
     */
    public function getSolde()
    {
        return $this->solde;
    }

    /**
     * Set the value of solde
     *
     * @return  self
     */
    public function setSolde($solde)
    {
        $this->solde = $solde;

        return $this;
    }

    /**
     * Get the value of dateCreation
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set the value of dateCreation
     *
     * @return  self
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get the value of typeCompte
     */
    public function getTypeCompte()
    {
        return $this->typeCompte;
    }

    /**
     * Set the value of typeCompte
     *
     * @return  self
     */
    public function setTypeCompte($typeCompte)
    {
        $this->typeCompte = $typeCompte;

        return $this;
    }
}
