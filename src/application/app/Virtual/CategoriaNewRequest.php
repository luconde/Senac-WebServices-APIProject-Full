<?php 

namespace App\Virtual;

/**
 * @OA\Schema(
 *  title = "CategoriaNewRequest",
 *  description = "Requisição enviada via Body para uma inserção ou atualização de uma Categoria",
 *  type = "object",
 *  required = {"nome_da_categoria"}
 * )
 */
class CategoriaNewRequest {
    /**
     * @OA\Property(
     *  title = "nome_da_categoria",
     *  description = "Nome da categoria.",
     * )
     * 
     * @var string
     */
    public $nome_da_categoria;
}