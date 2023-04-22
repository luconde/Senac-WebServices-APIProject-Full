<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "AuthUserResponse",
 *  description = "Resposta enviada via JSON para os dados do Usuário logado.",
 *  @OA\Xml(
 *      name = "AuthUserResponse"
 *  )
 * )
 */
class AuthUserResponse {
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
     *  title = "usuario",
     *  description = "Dados do usuário logado.",
     * )
     * 
     * @var \App\Virtual\Models\User
     */
    public $usuario;    
}