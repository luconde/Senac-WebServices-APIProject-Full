<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\StoreProdutoRequest;
use App\Models\Produto;
use App\Http\Resources\ProdutoResource;

class ProdutoController extends Controller
{
    /**
     * @OA\Get(
     *  path ="/api/produtos",
     *  operationId = "getProdutosList",
     *  tags = {"Produtos"},
     *  summary = "Retorna a Lista de Produtos.",
     *  description = "Retorna o JSON da Lista de Produtos.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\Parameter(
     *      name="ordenacao",
     *      in="query",
     *      description="Ordernação dos dados",
     *      required=false,
     *      @OA\Schema(
     *          type="string"
     *      ),
     *      @OA\Examples(
     *          summary = "Ordenação ascendente por nome do produto",
     *          example = "+nome_do_produto",
     *          value = "+nome_do_produto"
      *      ),
     *      @OA\Examples(
     *          summary = "Ordenação descendente por nome do produto",
     *          example = "-nome_do_produto",
     *         value = "-nome_do_produto"
     *      ),
     *      @OA\Examples(
     *          summary = "Ordenação ascendente ano do modelo",
     *          example = "+ano_do_modelo",
     *          value = "+ano_do_modelo"
      *      ),
     *      @OA\Examples(
     *          summary = "Ordenação descendente por ano do modelo",
     *          example = "-ano_do_modelo",
     *         value = "-ano_do_modelo"
     *      ),
     *      @OA\Examples(
     *          summary = "Ordenação ascendente por preço de lista",
     *          example = "+preco_de_lista",
     *          value = "+preco_de_lista"
      *      ),
     *      @OA\Examples(
     *          summary = "Ordenação descendente por preço de lista",
     *          example = "-preco_de_lista",
     *          value = "-preco_de_lista"
     *      )
     *  ),
     *  @OA\Parameter(
     *      name="filtro",
     *      in="query",
     *      description="Filtro dos dados",
     *      required=false,
     *      @OA\Schema(
     *          type="string"
     *      ),
     *      @OA\Examples(
     *          summary = "Filtro de 'Mountain Bikes' em nome da categoria",
     *          example = "nome_da_categoria:Mountain Bikes",
     *          value = "nome_da_categoria:Mountain Bikes"
     *      )
     *  ),
     *  @OA\Parameter(
     *      name="pagina",
     *      in="query",
     *      description="Página de dados",
     *      required=false,
     *      @OA\Schema(
     *          type="integer"
     *      ),
     *      @OA\Examples(
     *          summary = "Página 1",
     *          example = "1",
     *          value = "1"
     *      )
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/ProdutosResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/ProdutosResponseException500")
     *  )
     * )
     */
    public function index(Request $request)
    {
        try {
            $blnIsPaging = false;
            $blnIsFiltering = false;
            $blnIsOrdering = false;
    
            $query = Produto::with('categoria', 'marca');
            $mensagem = __("produto.listreturn");
            $codigoderetorno = 0;
            /*
            * Realiza o processamento do filtro
            */
            //Obtem o parametro do filtro
            $filterParameter = $request -> input("filtro");
    
            // Sf nao ha nenhum parametro;
            if($filterParameter == null) {
                // Retorna todos os produtos & Default
                $mensagem = __("produto.listreturnComplete");
                $codigoderetorno = 200;            
            }
            else {
                // Obtem o nome do filtro e o criterio
                [$filterCriteria, $filterValue] = explode(":", $filterParameter);
                $blnIsFiltering = true;
    
                //Se o filtro está adequado
                if($filterCriteria == "nome_da_categoria") {
                    //Faz inner join para obter a categoria
                    $produtos = $query->join("categorias","pkcategoria","=","fkcategoria")
                        ->where("nomedacategoria","=",$filterValue);
                    $mensagem = __("produto.listreturnFilter");
                    $codigoderetorno = 200;
                }
                else {
                    //Usuario chamou um filtro que não existe, entáo nao ha nada a retornar (Error 406 - Not Accepted)
                    $produtos = [];                
                    $mensagem = __("produto.listreturnfilternotaccepted");
                    $codigoderetorno = 406;
    
                }
            }
    
            if($codigoderetorno == 200) {
                /*
                * Realiza o processamento da ordenacao        
                */
                // Se há input para ordenacao
                if($request->input('ordenacao','')) {
                    $sorts = explode(',', $request->input('ordenacao',''));
                    $blnIsOrdering = true;
    
                    foreach($sorts as $sortColumn) {
                        $sortDirection = Str::startsWith($sortColumn,'-')?'desc':'asc';
                        $sortColumn = ltrim($sortColumn, '-');
    
                        // Transforma os nomes dos parametros em nomes dos campos do Modelo
                        switch($sortColumn) {
                            case("nome_do_produto"):
                                $query->orderBy('nomedoproduto', $sortDirection);
                                break;
                            case("ano_do_modelo"):
                                $query->orderBy('anodomodelo', $sortDirection);
                                break;
                            case("preco_de_lista"):
                                $query->orderBy('precodelista', $sortDirection);
                                break;
                        }
                    }
                    $mensagem = $mensagem . __("produto.listreturnOrdering");
                }
    
                /*
                * Realiza o processamento da paginacao        
                */
                $input = $request->input('pagina');
                if($input) {
                    $page = $input;
                    $perPage = 10; // Registros por pagina
                    // Captura a referencia
                    $recordsTotal = $query->count();
                    $numberOfPages =  ceil($recordsTotal / $perPage);
                    // Estabelece os limites da pagina
                    $query->offset(($page-1) * $perPage)->limit($perPage);
                    // Executa a query
                    $produtos = $query->get();
                    // Flags
                    $mensagem = $mensagem . __("produto.listreturnPaging");
                    $blnIsPaging = true;
                } 
            }
    
            // Se o processamento foi ok, retorna com base no criterio
            if($codigoderetorno == 200) {
                $produtos = $query->get();
                if($blnIsPaging) {
                    $response = response() -> json([
                        'status' => 200,
                        'mensagem' => $mensagem,
                        'meta' => [
                            'total_numero_de_registros' => (string) $recordsTotal,
                            'numero_de_registros_por_pagina' => (string) $perPage,
                            'numero_de_paginas' => (string) $numberOfPages,
                            'pagina_atual' => $page
                        ],                       
                        'produtos' => ProdutoResource::collection($produtos)                 
                    ], 200);
                } else {
                    $response = response() -> json([
                        'status' => 200,
                        'mensagem' => $mensagem,
                        'produtos' => ProdutoResource::collection($produtos)
                    ], 200);
                }
            } 
            else {
                //Retorna o erro que ocorreu
                $response = response()->json([
                    'status' => 406,
                    'mensagem' => $mensagem,
                    'produtos' => $produtos
                ],406);            
            }
          
            return $response;

        } catch(\Exception $ex) {
            /*
            * Tratamento das exceções levantadas
            */
            $class = get_class($ex); // Pega a classe da exceção 
            switch($class) {
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'categoria' => []
                    ], 500);
                    break;
            }
        }
    }

    /**
     * @OA\Post(
     *  path ="/api/produtos",
     *  operationId = "postProduto",
     *  tags = {"Produtos"},
     *  summary = "Armazena os dados de um novo Produto.",
     *  description = "Armazena e retorna o JSON de um novo Produto.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\RequestBody(
     *      required = true,
     *      @OA\JsonContent(ref = "#/components/schemas/ProdutoNewRequest")
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/ProdutoResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/ProdutoResponseException500")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/ProdutoResponseException406")
     *  )
     * )
     */
    public function store(StoreProdutoRequest $request)
    {
        try {
            // Cria o objeto 
            $produto =new Produto();

            // Transfere os valores
            $produto->nomedoproduto = $request->nome_do_produto;
            $produto->anodomodelo = $request->ano_do_modelo;
            $produto->precodelista = $request->preco_de_lista;
            //TODO: ha um jeito melhor de armazenar o ID?
            $produto->fkmarca = $request->marca['id'];
            $produto->fkcategoria = $request->categoria['id'];
            
            // Salva
            $produto->save();
            
            // Retorna o resultado
            return response() -> json([
                'status' => 200,
                'mensagem' => __("produto.created"),
                'produto' => new ProdutoResource($produto)
            ], 200);
        } catch(\Exception $ex) {
            /*
            * Tratamento das exceções levantadas
            */
            $class = get_class($ex); // Pega a classe da exceção 
            switch($class) {
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' =>  $ex->getMessage(),
                        'categoria' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'categoria' => []
                    ], 500);
                    break;
            }            
        }
    }

    /**
     * @OA\Get(
     *  path ="/api/produtos/{id}",
     *  operationId = "getProduto",
     *  tags = {"Produtos"},
     *  summary = "Retorna os dados de um Produto.",
     *  description = "Retorna o JSON de um Produto.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\Parameter(
     *      name="id",
     *      description="Id do Produto",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/ProdutoResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/ProdutoResponseException500")
     *  ),
     * @OA\Response(
     *      response = 404,
     *      description = "Produto não encontrado.",
     *      @OA\JsonContent(ref = "#/components/schemas/ProdutoResponseException404")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/ProdutoResponseException406")
     *  )
     * )
     */
    public function show($produtoid)
    {
        try {
            /*
            * Validação da entrada para ter certeza que o valor é numerico
            */
            $validator =  Validator::make(['id' => $produtoid],
            [
                    'id' => 'integer'
            ]);
            //Caso não seja válido, levantar exceção
            if($validator->fails()) {
                throw ValidationException::withMessages(['id' => __("produto.validationidmustnumeric")]);
            }

            /*
            * Continua o fluxo para a execução
            */              
            $produto = Produto::with('categoria', 'marca')->findorFail($produtoid);

            return response() -> json([
                'status' => 200,
                'mensagem' => __("produto.returned"),
                'produto' => new ProdutoResource($produto)
            ], 200);
        } catch(\Exception $ex) {
            /*
            * Tratamento das exceções levantadas
            */
            $class = get_class($ex); // Pega a classe da exceção 
            switch($class) {
                case ModelNotFoundException::class: //Caso não exista o id na base
                    return response() -> json([
                        'status' => 404,
                        'mensagem' => __("produto.exceptionnotfound"),
                        'categoria' => []
                    ], 404);
                    break;
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' =>  $ex->getMessage(),
                        'categoria' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'categoria' => []
                    ], 500);
                    break;
            }
        }
    }

    /**
     * @OA\Patch(
     *  path ="/api/produtos/{id}",
     *  operationId = "patchProduto",
     *  tags = {"Produtos"},
     *  summary = "Atualiza os dados de um produto.",
     *  description = "Atualiza e retorna o JSON de um produto.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\Parameter(
     *      name="id",
     *      description="Id da Produto",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(ref="#/components/schemas/Produto")
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/ProdutoResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/ProdutoResponseException500")
     *  ),
     * @OA\Response(
     *      response = 404,
     *      description = "Produto não encontrado.",
     *      @OA\JsonContent(ref = "#/components/schemas/ProdutoResponseException404")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/ProdutoResponseException406")
     *  )
     * )
     */
    public function update(StoreProdutoRequest $request, $produtoid)
    {
        try {
            /*
            * Validação da entrada para ter certeza que o valor é numerico
            */
            $validator =  Validator::make(['id' => $produtoid],
            [
                'id' => 'integer'
            ]);
            //Caso não seja válido, levantar exceção
            if($validator->fails()) {
                throw ValidationException::withMessages(['id' => __("produto.validationidmustnumeric")]);
            }            

            /*
            * Continua o fluxo para a execução
            */
            // Transfere os valores
            $produto = Produto::findorFail($produtoid);
            $produto->nomedoproduto = $request->nome_do_produto;
            $produto->anodomodelo = $request->ano_do_modelo;
            $produto->precodelista = $request->preco_de_lista;
            //TODO: ha um jeito melhor de armazenar o ID?
            $produto->fkmarca = $request->marca['id'];
            $produto->fkcategoria = $request->categoria['id'];
            
            // Salva
            $produto->update();
            
            // Retorna o resultado
            return response() -> json([
                'status' => 200,
                'mensagem' => __("produto.updated")
            ], 200);            
        } catch(\Exception $ex) {
            /*
            * Tratamento das exceções levantadas
            */
            $class = get_class($ex); // Pega a classe da exceção
            switch($class) {
                case ModelNotFoundException::class: //Caso não exista o id na base
                    return response() -> json([
                        'status' => 404,
                        'mensagem' => __("produto.exceptionnotfound"),
                        'categoria' => []
                    ], 404);
                    break;
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' => $ex->getMessage(),
                        'categoria' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'categoria' => []
                    ], 500);
                    break;
            }
        }
    }

    /**
     * @OA\Delete(
     *  path ="/api/produtos/{id}",
     *  operationId = "deleteProduto",
     *  tags = {"Produtos"},
     *  summary = "Apaga os dados de um produto.",
     *  description = "Apaga e retorna o JSON de confirmação.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\Parameter(
     *      name="id",
     *      description="Id da Produto",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/ProdutoResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/ProdutoResponseException500")
     *  ),
     * @OA\Response(
     *      response = 404,
     *      description = "Produto não encontrado.",
     *      @OA\JsonContent(ref = "#/components/schemas/ProdutoResponseException404")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/ProdutoResponseException406")
     *  )
     * )
     */
    public function destroy($produtoid)
    {
        try {
            /*
            * Validação da entrada para ter certeza que o valor é numerico
            */
            $validator =  Validator::make(['id' => $produtoid],
            [
                'id' => 'integer'
            ]);
            //Caso não seja válido, levantar exceção
            if($validator->fails()) {
                throw ValidationException::withMessages(['id' => __("produto.validationidmustnumeric")]);
            }

            /*
            * Continua o fluxo para a execução
            */            
            $produto = Produto::findorFail($produtoid);

            $produto->delete();
            return response() -> json([
                'status' => 200,
                'mensagem' => __("produto.deleted"),
                'produto' => []
            ], 200);
        } catch(\Exception $ex) {
            /*
            * Tratamento das exceções levantadas
            */
            $class = get_class($ex); // Pega a classe da exceção 
            switch($class) {
                case ModelNotFoundException::class: //Caso não exista o id na base
                    return response() -> json([
                        'status' => 404,
                        'mensagem' => __("produto.exceptionnotfound"),
                        'categoria' => []
                    ], 404);
                    break;
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' => $ex->getMessage(),
                        'categoria' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'categoria' => []
                    ], 500);
                    break;
            }
        }
    }
}
