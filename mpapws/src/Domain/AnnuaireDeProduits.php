<?php


namespace App\Domain;


interface AnnuaireDeProduits
{
    public function tousLesProduits():iterable;
}