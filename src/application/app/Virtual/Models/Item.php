<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *  title = "Item",
 *  description = "Modelo de Item do Pedido.",
 *  @OA\Xml(
 *      name = "Item"
 *  )
 * )
 */
class Item {
    /**
     * @OA\Property(
     *  title = "id",
     *  description = "Id do peido.",
     *  format = "int64",
     *  example = 1
     * )
     * 
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *  title = "quantidade",
     *  description = "Quantidade de produtos.",
     *  example = 1
     * )
     * 
     * @var integer
     */
    public $quantidade;

    /**
     * @OA\Property(
     *  title = "preco",
     *  description = "Preço de compra do item.",
     *  example = 599.99
     * )
     * 
     * @var double
     */
    public $preco;    

    /**
     * @OA\Property(
     *  title = "moeda de preço de compra",
     *  description = "Moeda do preço de compra.",
     *  example = "USD"
     * )
     * 
     * @var string
     */
    public $moeda;

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

    /**
     * @OA\Property(
     *  title = "produto comprado",
     *  description = "Dados do produto comprado.",
     * )
     * 
     * @var \App\Virtual\Models\Produto
     */
    public $produto;   

}