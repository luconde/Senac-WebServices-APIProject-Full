<?php 

namespace App\Virtual;

/**
 * @OA\Schema(
 *  title = "ClienteNewRequest",
 *  description = "Requisição enviada via Body para uma inserção ou atualização de um novo Cliente",
 *  type = "object",
 *  required = {"email"}
 * )
 */
class ClienteNewRequest {
    /**
     * @OA\Property(
     *  title = "nome",
     *  description = "Nome do Cliente.",
     * )
     * 
     * @var string
     */
    public $nome;

    /**
     * @OA\Property(
     *  title = "email",
     *  description = "Email do Cliente.",
     * )
     * 
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *  title = "telefone",
     *  description = "Telefone do Cliente.",
     * )
     * 
     * @var string
     */
    public $telefone;    

    /**
     * @OA\Property(
     *  title = "rua",
     *  description = "Rua do endereço do Cliente.",
     * )
     * 
     * @var string
     */
    public $rua;     
    
    /**
     * @OA\Property(
     *  title = "cidade",
     *  description = "Cidade do endereço do Cliente.",
     * )
     * 
     * @var string
     */
    public $cidade;      

    /**
     * @OA\Property(
     *  title = "estado",
     *  description = "Estado do endereço do Cliente.",
     * )
     * 
     * @var string
     */
    public $estado;    
    
    /**
     * @OA\Property(
     *  title = "cep",
     *  description = "Cep do endereço do Cliente.",
     * )
     * 
     * @var string
     */
    public $cep;     
}