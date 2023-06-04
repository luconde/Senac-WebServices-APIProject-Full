<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "AuthResponseException406",
 *  description = "Resposta enviada via JSON para os dados de Token",
 *  @OA\Xml(
 *      name = "AuthResponseException406"
 *  )
 * )
 */
class AuthResponseException406 {
    /**
     * @OA\Property(
     *  title = "status",
     *  description = "HTTP Status.",
     *  format = "int64",
     *  example = 406
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
     *  example = "Acesso não autorizado."
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