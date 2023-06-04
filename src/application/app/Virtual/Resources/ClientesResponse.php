<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "ClientesResponse",
 *  description = "Resposta enviada via JSON para Lista de Clientes",
 *  @OA\Xml(
 *      name = "ClientesResponse"
 *  )
 * )
 */
class ClientesResponse {
    /**
     * @OA\Property(
     *  title = "status",
     *  description = "HTTP Status.",
     *  format = "int64",
     *  example = 200
     * )
     * 
     * @var integer
     */
    public $status;

    /**
     * @OA\Property(
     *  title = "mensagem",
     *  description = "Mensagem informativa da resposta.",
     *  format = "string",
     *  example = "Lista de clientes retornada."
     * )
     * 
     * @var string
     */
    public $mensagem;

    /**
     * @OA\Property(
     *  title = "clientes",
     *  description = "Lista de Clientes retornada.",
     * )
     * 
     * @var \App\Virtual\Models\Cliente[]
     */
    public $clientes;
}