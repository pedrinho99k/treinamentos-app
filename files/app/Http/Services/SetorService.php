<?php

namespace App\Servies;

use stdClass;

class SetorService
{
    protected $repository;
    public function __construct()
    {
    }

    public function getAll(string $filter = null): array

    {
        return $this->repository->getAll($filter);
    }

    public function findOne(string $id): stdClass|null
    {
        return $this->repository->findOne($id);
    }

    public function new(
        string $setor_descricao,
        string $setor_ativo
    ): stdClass {

        return $this->repository->new(
            $setor_descricao,
            $setor_ativo
        );
    }

    public function update(
        string $id,
        string $setor_descricao,
        string $setor_ativo
    ): stdClass|null {

        return $this->repository->update(
            $id,
            $setor_descricao,
            $setor_ativo
        );
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }
}
