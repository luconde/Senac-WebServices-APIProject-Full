<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "AuthResponseException500",
 *  description = "Resposta enviada via JSON para os dados de Token",
 *  @OA\Xml(
 *      name = "AuthResponseException500"
 *  )
 * )
 */
class AuthResponseException500 {
    /**
     * @OA\Property(
     *  title = "status",
     *  description = "HTTP Status.",
     *  format = "int64",
     *  example = 500
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
     *  example = "Erro Interno."
     * )
     * 
     * @var string
     */
    public $mensagem;

    /**
     * @OA\Property(
     *  title = "token",
     *  description = "Token de Autenticação"
     * )
     * 
     * @var string
     */
    public $token;    
}