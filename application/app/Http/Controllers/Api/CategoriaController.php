<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    /**
     * @OA\Get(
     *  path ="/api/categorias",
     *  operationId = "getCategoriasList",
     *  tags = {"Categorias"},
     *  summary = "Retorna a Lista de Categorias.",
     *  description = "Retorna o JSON da Lista de Categorias.",
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
     *          summary = "Ordenação ascedente por nome da categoria",
     *          example = "+nome_da_categoria",
     *          value = "+nome_da_categoria"
     *      ),
     *      @OA\Examples(
     *          summary = "Ordenação descendente por nome da categoria",
     *          example = "-nome_da_categoria",
     *          value = "-nome_da_categoria"
     *      )
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/CategoriasResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/CategoriasResponseException500")
     *  )
     * )
     */
    public function index(Request $request)
    {
        try {
            // Captura a coluna para ordenacao
            $sortParameter = $request->input('ordenacao','nome_da_categoria');
            $sortDirection = Str::startsWith($sortParameter,'-') ? 'desc':'asc';
            $sortColumn = ltrim($sortParameter,'-');

            // Determina se faz a query ordenada ou aplica o default
            if($sortColumn == 'nome_da_categoria') {
                $categorias = Categoria::orderBy('nomedacategoria', $sortDirection)->get();
            }
            else {
                $categorias = Categoria::all();
            }
            
            return response() -> json([
                    'status' => 200,
                    'mensagem' => __("categoria.listreturn"),
                    'categorias' => CategoriaResource::collection($categorias)
            ], 200);
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
                        'categorias' => []
                    ], 500);
                    break;
            }
        }
    }

    /**
     * @OA\Post(
     *  path ="/api/categorias",
     *  operationId = "postCategoria",
     *  tags = {"Categorias"},
     *  summary = "Armazena os dados de uma nova Categoria.",
     *  description = "Armazena e retorna o JSON de uma nova Categoria.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\RequestBody(
     *      required = true,
     *      @OA\JsonContent(ref = "#/components/schemas/CategoriaNewRequest")
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/CategoriaResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/CategoriaResponseException500")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/CategoriaResponseException406")
     *  )
     * )
     */
    public function store(StoreCategoriaRequest $request)
    {
        try {
            // Cria o objeto 
            $categoria =new Categoria();

            // Transfere os valores
            $categoria->nomedacategoria = $request->nome_da_categoria;

            // Salva
            $categoria->save();

            // Retorna o resultado
            return response() -> json([
                'status' => 200,
                'mensagem' => __("categoria.created"),
                'categoria' => new CategoriaResource($categoria)
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
     *  path ="/api/categorias/{id}",
     *  operationId = "getCategoria",
     *  tags = {"Categorias"},
     *  summary = "Retorna os dados de uma Categoria.",
     *  description = "Retorna o JSON de uma Categoria.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\Parameter(
     *      name="id",
     *      description="Id da Categoria",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/CategoriaResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/CategoriaResponseException500")
     *  ),
     * @OA\Response(
     *      response = 404,
     *      description = "Categoria não encontrada.",
     *      @OA\JsonContent(ref = "#/components/schemas/CategoriaResponseException404")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/CategoriaResponseException406")
     *  )
     * )
     */
    public function show($categoriaid)
    {
        try {
            /*
            * Validação da entrada para ter certeza que o valor é numerico
            */
            $validator =  Validator::make(['id' => $categoriaid],
            [
                    'id' => 'integer'
            ]);
            //Caso não seja válido, levantar exceção
            if($validator->fails()) {
                throw ValidationException::withMessages(['id' => __("categoria.validationidmustnumeric")]);
            }

            /*
            * Continua o fluxo para a execução
            */
            $categoria = Categoria::findorFail($categoriaid);

            return response() -> json([
                'status' => 200,
                'mensagem' => __("categoria.returned"),
                'categoria' => new CategoriaResource($categoria)
            ]);
        } catch(\Exception $ex) {
            /*
            * Tratamento das exceções levantadas
            */
            $class = get_class($ex); // Pega a classe da exceção 
            switch($class) {
                case ModelNotFoundException::class: //Caso não exista o id na base
                    return response() -> json([
                        'status' => 404,
                        'mensagem' => __("categoria.exceptionnotfound"),
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
     *  path ="/api/categorias/{id}",
     *  operationId = "patchCategoria",
     *  tags = {"Categorias"},
     *  summary = "Atualiza os dados de uma categoria.",
     *  description = "Atualiza e retorna o JSON de uma nova Categoria.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\Parameter(
     *      name="id",
     *      description="Id da Categoria",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(ref="#/components/schemas/Categoria")
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/CategoriaResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/CategoriaResponseException500")
     *  ),
     * @OA\Response(
     *      response = 404,
     *      description = "Categoria não encontrada.",
     *      @OA\JsonContent(ref = "#/components/schemas/CategoriaResponseException404")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/CategoriaResponseException406")
     *  )
     * )
     */
    public function update(StoreCategoriaRequest $request, $categoriaid)
    {
        try {
            /*
            * Validação da entrada para ter certeza que o valor é numerico
            */
            $validator =  Validator::make(['id' => $categoriaid],
            [
                'id' => 'integer'
            ]);
            //Caso não seja válido, levantar exceção
            if($validator->fails()) {
                throw ValidationException::withMessages(['id' => __("categoria.validationidmustnumeric")]);
            }

            /*
            * Continua o fluxo para a execução
            */
            $categoria = Categoria::findorFail($categoriaid);
            $categoria->nomedacategoria = $request->nome_da_categoria;
            $categoria->update();
    
            return response() -> json([
                'status' => 200,
                'mensagem' => __("categoria.updated"),
                'categoria' => new CategoriaResource($categoria)
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
                        'mensagem' => __("categoria.exceptionnotfound"),
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
     *  path ="/api/categorias/{id}",
     *  operationId = "deleteCategoria",
     *  tags = {"Categorias"},
     *  summary = "Apaga os dados de uma categoria.",
     *  description = "Apaga e retorna o JSON de confirmação.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\Parameter(
     *      name="id",
     *      description="Id da Categoria",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/CategoriaResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/CategoriaResponseException500")
     *  ),
     * @OA\Response(
     *      response = 404,
     *      description = "Categoria não encontrada.",
     *      @OA\JsonContent(ref = "#/components/schemas/CategoriaResponseException404")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/CategoriaResponseException406")
     *  )
     * )
     */
    public function destroy($categoriaid)
    {
        try {
            /*
            * Validação da entrada para ter certeza que o valor é numerico
            */
            $validator =  Validator::make(['id' => $categoriaid],
            [
                'id' => 'integer'
            ]);
            //Caso não seja válido, levantar exceção
            if($validator->fails()) {
                throw ValidationException::withMessages(['id' => __("categoria.validationidmustnumeric")]);
            }

            /*
            * Continua o fluxo para a execução
            */
            $categoria = Categoria::findorFail($categoriaid);

            // Apagar a categoria
            $categoria->delete();

            // Retorna a mensagem final
            return response() -> json([
                'status' => 200,
                'mensagem' => __("categora.deleted"),
                'categoria' => []
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
                        'mensagem' => __("categoria.exceptionnotfound"),
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
