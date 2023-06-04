<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *  title = "Produto",
 *  description = "Modelo do Produto.",
 *  @OA\Xml(
 *      name = "Produto"
 *  )
 * )
 */
class Produto {
    /**
     * @OA\Property(
     *  title = "id",
     *  description = "Id do produto.",
     *  format = "int64",
     *  example = 1
     * )
     * 
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *  title = "nome do produto",
     *  description = "Nome do Produto.",
     *  example = "Surly Straggler - 2016"
     * )
     * 
     * @var string
     */
    public $nome_da_produto;

    /**
     * @OA\Property(
     *  title = "ano do modelo",
     *  description = "Ano do modelo do Produto.",
     *  example = "2016"
     * )
     * 
     * @var integer
     */
    public $ano_do_modelo;    

    /**
     * @OA\Property(
     *  title = "preço de lista",
     *  description = "Preço de lista do Produto.",
     *  example = "2016"
     * )
     * 
     * @var double
     */
    public $preco_de_lista;       
    
    /**
     * @OA\Property(
     *  title = "moeda de preço de lista",
     *  description = "Moeda do preço de lista do produto.",
     *  example = "USD"
     * )
     * 
     * @var string
     */
    public $moeda;

    /**
     * @OA\Property(
     *  title = "categoria do produto",
     *  description = "Categoria do produto.",
     * )
     * 
     * @var \App\Virtual\Models\Categoria
     */
    public $categoria;    

    /**
     * @OA\Property(
     *  title = "marca do produto",
     *  description = "Marca do produto.",
     * )
     * 
     * @var \App\Virtual\Models\Marca
     */
    public $marca;       
}