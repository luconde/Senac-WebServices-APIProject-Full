<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *  title = "Marca",
 *  description = "Modelo da Marca.",
 *  @OA\Xml(
 *      name = "Marca"
 *  )
 * )
 */
class Marca {
    /**
     * @OA\Property(
     *  title = "id",
     *  description = "Id da Marca.",
     *  format = "int64",
     *  example = 1
     * )
     * 
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *  title = "nome da marca",
     *  description = "Nome da Marca.",
     *  example = "Electra"
     * )
     * 
     * @var string
     */
    public $nome_da_marca;
}