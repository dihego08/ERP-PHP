<?php
namespace App\Repositories;

use PDO;
use App\Models\Proveedor;
use App\Database\DbProvider;

class ProveedorRepository
{
    private $_db;

    public function __construct()
    {
        $this->_db = DbProvider::get();
    }

    public function find(int $id): ?Proveedor
    {
        $result = null;

        $stm = $this->_db->prepare('SELECT * FROM proveedores WHERE id = :id');
        $stm->execute(['id' => $id]);

        $data = $stm->fetchObject('\\App\\Models\\Proveedor');

        if ($data) {
            $result = $data;
        }

        return $result;
    }

    public function findAll(): array
    {
        $result = [];

        // 01. Prepare query
        $stm = $this->_db->prepare('SELECT * FROM proveedores');

        // 02. Execute query
        $stm->execute();

        // 03. Fetch All
        $result = $stm->fetchAll(PDO::FETCH_CLASS, '\\App\\Models\\Proveedor');

        return $result;
    }

    public function add(Proveedor $model): void
    {
        $stm = $this->_db->prepare(
            'INSERT INTO proveedores(ruc, razon_social, direccion, telefono) VALUES (:ruc, :razon_social, :direccion, :telefono)'
        );

        $stm->execute([
            'ruc' => $model->ruc,
            'razon_social' => $model->razon_social,
            'direccion' => $model->direccion,
            'telefono' => $model->telefono,
        ]);
    }

    public function update(Proveedor $model): void
    {
        $stm = $this->_db->prepare('
            UPDATE proveedores
            SET ruc = :ruc,
                razon_social = :razon_social,
                direccion = :direccion,
                telefono = :telefono
            WHERE id = :id
        ');

        $stm->execute([
            'ruc' => $model->ruc,
            'razon_social' => $model->razon_social,
            'direccion' => $model->direccion,
            'telefono' => $model->telefono,
            'id' => $model->id,
        ]);
    }

    public function remove(int $id): void
    {
        $stm = $this->_db->prepare(
            'DELETE FROM proveedores WHERE id = :id'
        );

        $stm->execute(['id' => $id]);
    }
}
