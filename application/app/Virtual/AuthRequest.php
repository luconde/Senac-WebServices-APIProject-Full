<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Requisicao para login",
 *      description="Requisição enviada via Body para login",
 *      type="object",
 *      required={"email", "password"}
 * )
 */

class AuthRequest
{
    /**
     * @OA\Property(
     *      title="Email",
     *      description="email",
     *      example="demo@demo.com"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="Password",
     *      description="Senha",
     *      example="Insira a senha"
     * )
     *
     * @var string
     */
    public $password;
}