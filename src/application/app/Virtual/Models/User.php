<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Usuario",
 *     description="Modelo do Usuario",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */
class User
{

    /**
     * @OA\Property(
     *     title="id",
     *     description="Id do usuário.",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *      title="nome",
     *      description="Nome do Usuario.",
     *      example="John Doe"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="email",
     *      description="Email do usuario.",
     *      example="demo@demo.com"
     * )
     *
     * @var string
     */
    public $email;

}