<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *  title = "AuthLoginRequest",
 *  description = "Requisição enviada via Body para login.",
 *  type = "object",
 *  required = {"nome"}
 * )
 */
class AuthLoginRequest {
    /**
     * @OA\Property(
     *  title = "email",
     *  description = "Email do usuário.",
     * )
     * 
     * @var string
     */    
    private $email;

    /**
     * @OA\Property(
     *  title = "senha",
     *  description = "Senha do usuário.",
     * )
     * 
     * @var string
     */     
    private $senha;
}