<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *  title = "AuthUserResponseException404",
 *  description = "Resposta enviada via JSON para os dados do Usuário logado.",
 *  @OA\Xml(
 *      name = "AuthUserResponseException404"
 *  )
 * )
 */
class AuthUserResponseException404 {
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
     *  title = "usuario",
     *  description = "Dados do usuário logado.",
     * )
     * 
     * @var string
     */
    public $usuario;    
}