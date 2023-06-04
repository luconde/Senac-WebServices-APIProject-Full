<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "AuthResponseException404",
 *  description = "Resposta enviada via JSON para os dados de Token",
 *  @OA\Xml(
 *      name = "AuthResponseException404"
 *  )
 * )
 */
class AuthResponseException404 {
    /**
     * @OA\Property(
     *  title = "status",
     *  description = "HTTP Status.",
     *  format = "int64",
     *  example = 404
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
     *  example = "Não encontrado."
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