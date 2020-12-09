<?php


namespace App\Domain;

/**
 * Interface AnnuaireProducteur
 * @package App\Domain
 */
interface AnnuaireProducteur
{
    /**
     * @return iterable
     */
    public function tousLesProducteurs(): iterable;
}