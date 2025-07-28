<?php
namespace App\Entity;

enum TypeTransaction:string{

      case DEPOS='Depos';
      case RETRAIT='Retrait';
      case PAIEMENT='Paiement';

    

}