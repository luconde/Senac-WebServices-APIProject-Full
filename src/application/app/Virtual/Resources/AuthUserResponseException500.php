<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "AuthUserResponseException500",
 *  description = "Resposta enviada via JSON para os dados do Usuário logado.",
 *  @OA\Xml(
 *      name = "AuthUserResponseException500"
 *  )
 * )
 */
class AuthUserResponseException500 {
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
     *  title = "usuario",
     *  description = "Dados do usuário logado.",
     * )
     * 
     * @var string
     */
    public $usuario;    
}