<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "AuthResponse",
 *  description = "Resposta enviada via JSON para os dados de Token",
 *  @OA\Xml(
 *      name = "AuthResponse"
 *  )
 * )
 */
class AuthResponse {
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
     *  example = "Você está logado."
     * )
     * 
     * @var string
     */
    public $mensagem;

    /**
     * @OA\Property(
     *  title = "token",
     *  description = "Token de Autenticação",
     * )
     * 
     * @var string
     */
    public $token;    
}