<?php 

namespace App\Virtual;

/**
 * @OA\Schema(
 *  title = "ItemNewRequest",
 *  description = "Requisição enviada via Body para uma inserção ou atualização de um novo Item do Pedido",
 *  type = "object",
 *  required = {"quantidade, preco_de_lista, desconto"}
 * )
 */
class ItemNewRequest {
    /**
     * @OA\Property(
     *  title = "quantidade",
     *  description = "Quantidade do produto.",
     * )
     * 
     * @var integer
     */
    public $quantidade;

    /**
     * @OA\Property(
     *  title = "preco_de_lista",
     *  description = "Preço de lista do Produto."
     * )
     * 
     * @var double
     */
    public $preco_de_lista;     
    
    /**
     * @OA\Property(
     *  title = "taxa de desconto",
     *  description = "Taxa de desconto do preço.",
     *  example = 0.20
     * )
     * 
     * @var double
     */
    public $desconto;       
}