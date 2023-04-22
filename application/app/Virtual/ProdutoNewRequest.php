<?php 

namespace App\Virtual;

/**
 * @OA\Schema(
 *  title = "ProdutoNewRequest",
 *  description = "Requisição enviada via Body para uma inserção ou atualização de um Produto",
 *  type = "object",
 *  required = {"nome_do_produto, ano_do_modelo, preco_de_lista"}
 * )
 */
class ProdutoNewRequest {
    /**
     * @OA\Property(
     *  title = "nome_do_produto",
     *  description = "Nome do Produto."
     * )
     * 
     * @var string
     */
    public $nome_do_produto;

    /**
     * @OA\Property(
     *  title = "ano_do_modelo",
     *  description = "Ano do modelo do Produto."
     * )
     * 
     * @var integer
     */
    public $ano_do_modelo;    

    /**
     * @OA\Property(
     *  title = "preco_de_lista",
     *  description = "Preço de lista do Produto."
     * )
     * 
     * @var double
     */
    public $preco_de_lista;        
}