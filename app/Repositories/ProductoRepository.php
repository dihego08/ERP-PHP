<?php
namespace App\Repositories;

use PDO;
use App\Models\Producto;
use App\Database\DbProvider;

class ProductoRepository
{
    private $_db;

    public function __construct()
    {
        $this->_db = DbProvider::get();
    }

    public function find(int $id): ?Producto
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
        $stm = $this->_db->prepare('SELECT p.*, c.categoria FROM productos as p, categorias as c WHERE p.id_categoria = c.id');

        // 02. Execute query
        $stm->execute();

        // 03. Fetch All
        $result = $stm->fetchAll(PDO::FETCH_CLASS, '\\App\\Models\\Producto');

        return $result;
    }

    public function add(Producto $model): void
    {
        $stm = $this->_db->prepare(
            'INSERT INTO productos(nombre, precio, descripcion, id_categoria) VALUES (:nombre, :precio, :descripcion, :id_categoria)'
        );

        $stm->execute([
            'nombre' => $model->nombre,
            'precio' => $model->precio,
            'descripcion' => $model->descripcion,
            'id_categoria' => $model->id_categoria,
        ]);
    }

    public function update(Producto $model): void
    {
        $stm = $this->_db->prepare('
            UPDATE productos
            SET nombre = :nombre,
                precio = :precio,
                descripcion = :descripcion,
                id_categoria = :id_categoria
            WHERE id = :id
        ');

        $stm->execute([
            'nombre' => $model->nombre,
            'precio' => $model->precio,
            'descripcion' => $model->descripcion,
            'id_categoria' => $model->id_categoria,
            'id' => $model->id,
        ]);
    }

    public function remove(int $id): void
    {
        $stm = $this->_db->prepare(
            'DELETE FROM productos WHERE id = :id'
        );

        $stm->execute(['id' => $id]);
    }
}
