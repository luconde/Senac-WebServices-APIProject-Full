<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *  title = "Pedido",
 *  description = "Modelo da Pedido.",
 *  @OA\Xml(
 *      name = "Pedido"
 *  )
 * )
 */
class Pedido {
    /**
     * @OA\Property(
     *  title = "id",
     *  description = "Id do Pedido.",
     *  format = "int64",
     *  example = 1
     * )
     * 
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *  title = "data do pedido",
     *  description = "Data que o pedido foi realizado.",
     *  example = "2016-08-01"
     * )
     * 
     * @var string
     */
    public $data_do_pedido;

    /**
     * @OA\Property(
     *  title = "cliente do pedido",
     *  description = "Cliente que realizou o pedido.",
     * )
     * 
     * @var \App\Virtual\Models\Cliente
     */
    public $cliente;

    /**
     * @OA\Property(
     *  title = "lista de itens do pedido",
     *  description = "Lista de Itens do pedido.",
     * )
     * 
     * @var \App\Virtual\Models\Item[]
     */
    public $itens;    
}