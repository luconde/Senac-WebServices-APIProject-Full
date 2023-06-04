<?php 

namespace App\Virtual;

/**
 * @OA\Schema(
 *  title = "MarcaNewRequest",
 *  description = "Requisição enviada via Body para uma inserção ou atualização de uma Marca",
 *  type = "object",
 *  required = {"nome_da_Marca"}
 * )
 */
class MarcaNewRequest {
    /**
     * @OA\Property(
     *  title = "nome_da_Marca",
     *  description = "Nome da Marca.",
     * )
     * 
     * @var string
     */
    public $nome_da_marca;
}