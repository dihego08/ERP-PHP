<?php
namespace App\Services;

use App\Models\Proveedor;
use App\Repositories\ProveedorRepository;
use App\Container;
use PDOException;

class ProveedorService
{
    private $_productRepository;
    private $_logger;

    public function __construct()
    {
        $this->_productRepository = new ProveedorRepository;
        $this->logger = Container::get('logger');
    }

    public function getAll(): array
    {
        $result = [];

        try {
            $result = $this->_productRepository->findAll();
        } catch (PDOException $ex) {
            $this->logger->error($ex->getMessage());
        }

        return $result;
    }

    public function get(int $id): ?Proveedor
    {
        $result = null;

        try {
            $result = $this->_productRepository->find($id);
        } catch (PDOException $ex) {
            $this->logger->error($ex->getMessage());
        }

        return $result;
    }

    public function create(Proveedor $model): array
    {
        try {
            $result = $this->_productRepository->add($model);
            return array('Result' => "OK");
        } catch (PDOException $ex) {
            $this->logger->error($ex->getMessage());
        }
    }

    public function update(Proveedor $model): array
    {
        try {
            $result = $this->_productRepository->update($model);
            return array('Result' => "OK");
        } catch (PDOException $ex) {
            $this->logger->error($ex->getMessage());
        }
    }

    public function delete(int $id): array
    {
        try {
            $result = $this->_productRepository->remove($id);
            return array('Result' => "OK");
        } catch (PDOException $ex) {
            $this->logger->error($ex->getMessage());
        }
    }
}
