<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *  title = "AuthRegisterRequest",
 *  description = "Requisição enviada via Body para uma inserção de um novo login",
 *  type = "object",
 *  required = {"nome"}
 * )
 */
class AuthRegisterRequest {
    /**
     * @OA\Property(
     *  title = "nome",
     *  description = "Nome do usuário.",
     * )
     * 
     * @var string
     */    
    private $nome;

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