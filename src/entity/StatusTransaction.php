<?php
namespace App\Entity;
 enum StatusTransaction:string {
 case ANNULER = 'Annuler';
 case EN_COURS = 'En_cours';
 case TERMINE = 'Termine';
 }