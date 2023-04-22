<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *  title = "Cliente",
 *  description = "Modelo de Cliente.",
 *  @OA\Xml(
 *      name = "Cliente"
 *  )
 * )
 */
class Cliente {
    /**
     * @OA\Property(
     *  title = "id",
     *  description = "Id do cliente.",
     *  format = "int64",
     *  example = 1
     * )
     * 
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *  title = "nome do cliente",
     *  description = "Nome do Cliente.",
     *  example = "John Smith"
     * )
     * 
     * @var string
     */
    public $nome;

    /**
     * @OA\Property(
     *  title = "telefone do cliente",
     *  description = "Telefone do Cliente.",
     *  example = "555-5555"
     * )
     * 
     * @var string
     */
    public $telefone;    

    /**
     * @OA\Property(
     *  title = "email do cliente",
     *  description = "Email do Cliente.",
     *  example = "demo@demo.com"
     * )
     * 
     * @var string
     */
    public $email;        

    /**
     * @OA\Property(
     *  title = "rua do endereço do cliente",
     *  description = "Rua do Endereço do Cliente.",
     *  example = "Avenida Xpto"
     * )
     * 
     * @var string
     */
    public $rua;      
    
    /**
     * @OA\Property(
     *  title = "cidade do endereço do cliente",
     *  description = "Cidade do Endereço do Cliente.",
     *  example = "São Paulo"
     * )
     * 
     * @var string
     */
    public $cidade;    
    
    /**
     * @OA\Property(
     *  title = "estado do endereço do cliente",
     *  description = "Estado do Endereço do Cliente.",
     *  example = "SP"
     * )
     * 
     * @var string
     */
    public $estado;      
    
    /**
     * @OA\Property(
     *  title = "cep do endereço do cliente",
     *  description = "CEP do Endereço do Cliente.",
     *  example = "11111-111"
     * )
     * 
     * @var string
     */
    public $cep;       
}