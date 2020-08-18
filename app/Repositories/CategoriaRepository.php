<?php
namespace App\Repositories;

use PDO;
use App\Models\Categoria;
use App\Database\DbProvider;

class CategoriaRepository
{
    private $_db;

    public function __construct()
    {
        $this->_db = DbProvider::get();
    }

    public function find(int $id): ?Categoria
    {
        $result = null;

        $stm = $this->_db->prepare('SELECT * FROM productos WHERE id = :id');
        $stm->execute(['id' => $id]);

        $data = $stm->fetchObject('\\App\\Models\\Producto');

        if ($data) {
            $result = $data;
        }

        return $result;
    }

    public function findAll(): array
    {
        $result = [];

        // 01. Prepare query
        $stm = $this->_db->prepare('SELECT * FROM categorias');

        // 02. Execute query
        $stm->execute();

        // 03. Fetch All
        $result = $stm->fetchAll(PDO::FETCH_CLASS, '\\App\\Models\\Categoria');

        return $result;
    }

    public function add(Categoria $model): void
    {
        $stm = $this->_db->prepare(
            'INSERT INTO categorias(categoria) VALUES (:categoria)'
        );

        $stm->execute([
            'categoria' => $model->categoria,
        ]);
    }

    public function update(Categoria $model): void
    {
        $stm = $this->_db->prepare('UPDATE categorias
            SET categoria = :categoria
            WHERE id = :id
        ');

        $stm->execute([
            'categoria' => $model->categoria,
            'id' => $model->id,
        ]);
    }

    public function remove(int $id): void
    {
        $stm = $this->_db->prepare(
            'DELETE FROM categorias WHERE id = :id'
        );

        $stm->execute(['id' => $id]);
    }
}
