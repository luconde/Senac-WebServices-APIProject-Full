<?php 

namespace App\Virtual;

/**
 * @OA\Schema(
 *  title = "PedidoNewRequest",
 *  description = "Requisição enviada via Body para uma inserção ou atualização de um novo Pedido",
 *  type = "object",
 *  required = {"nome_da_Marca"}
 * )
 */
class PedidoNewRequest {
    /**
     * @OA\Property(
     *  title = "data_requisitada",
     *  description = "Data do pedido.",
     * )
     * 
     * @var date
     */
    public $data_requisitada;
}