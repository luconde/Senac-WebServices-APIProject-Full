<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "AuthUserResponseException406",
 *  description = "Resposta enviada via JSON para os dados do Usuário logado.",
 *  @OA\Xml(
 *      name = "AuthUserResponseException406"
 *  )
 * )
 */
class AuthUserResponseException406 {
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
     *  title = "usuario",
     *  description = "Dados do usuário logado.",
     * )
     * 
     * @var string
     */
    public $usuario;    
}