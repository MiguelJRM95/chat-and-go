<?php

namespace App\Controller\Services;

class SalaHandler
{

    public function filterSalasById(array $salas, int $salaId): array
    {
        return $nombreSalas = array_filter($salas, function ($sala) use (&$salaId) {
            return $sala['id'] === $salaId;
        });
    }
}
