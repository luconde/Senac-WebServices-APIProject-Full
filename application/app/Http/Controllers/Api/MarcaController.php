<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\StoreMarcaRequest;
use App\Http\Resources\MarcaResource;
use App\Models\Marca;

class MarcaController extends Controller
{
    /**
     * @OA\Get(
     *  path ="/api/marcas",
     *  operationId = "getMarcasList",
     *  tags = {"Marcas"},
     *  summary = "Retorna a Lista de Marcas.",
     *  description = "Retorna o JSON da Lista de Marcas.",
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
     *          summary = "Ordenação ascedente por nome da marca",
     *          example = "+nome_da_marca",
     *          value = "+nome_da_marca"
     *      ),
     *      @OA\Examples(
     *          summary = "Ordenação descendente por nome da marca",
     *          example = "-nome_da_marca",
     *          value = "-nome_da_marca"
     *      )
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/MarcasResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/MarcasResponseException500")
     *  )
     * )
     */
    public function index(Request $request)
    {
        try {
            // Captura a coluna para ordenacao
            $sortParameter = $request->input('ordenacao','nome_da_marca');
            $sortDirection = Str::startsWith($sortParameter,'-') ? 'desc':'asc';
            $sortColumn = ltrim($sortParameter,'-');

            // Determina se faz a query ordenada ou aplica o default
            if($sortColumn == 'nome_da_marca') {
                $marcas = Marca::orderBy('nomedamarca', $sortDirection)->get();
            }
            else {
                $marcas = Marca::all();
            }  

            return response() -> json([
                'status' => 200,
                'mensagem' => __("marca.listreturn"),
                'marcas' => MarcaResource::collection($marcas)
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
                        'marcas' => []
                    ], 500);
                    break;
            }
        }
    }

    /**
     * @OA\Post(
     *  path ="/api/marcas",
     *  operationId = "postMarca",
     *  tags = {"Marcas"},
     *  summary = "Armazena os dados de uma nova Marca.",
     *  description = "Armazena e retorna o JSON de uma nova Marca.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\RequestBody(
     *      required = true,
     *      @OA\JsonContent(ref = "#/components/schemas/MarcaNewRequest")
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/MarcaResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/MarcaResponseException500")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/MarcaResponseException406")
     *  )
     * )
     */
    public function store(StoreMarcaRequest $request)
    {
        try {
            // Cria o objeto 
            $marca =new Marca();
            // Transfere os valores
            $marca->nomedamarca = $request->nome_da_marca;
            // Salva
            $marca->save();
            // Retorna o resultado
            return response() -> json([
                'status' => 200,
                'mensagem' => __("marca.created"),
                'marca' => new MarcaResource($marca)
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
                        'marca' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'marca' => []
                    ], 500);
                    break;
            }
        }

    }

    /**
     * @OA\Get(
     *  path ="/api/marcas/{id}",
     *  operationId = "getMarca",
     *  tags = {"Marcas"},
     *  summary = "Retorna os dados de uma Marca.",
     *  description = "Retorna o JSON de uma Marca.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\Parameter(
     *      name="id",
     *      description="Id da Marca",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/MarcaResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/MarcaResponseException500")
     *  ),
     * @OA\Response(
     *      response = 404,
     *      description = "Marca não encontrada.",
     *      @OA\JsonContent(ref = "#/components/schemas/MarcaResponseException404")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/MarcaResponseException406")
     *  )
     * )
     */
    public function show($marcaid)
    {
        try {
            /*
            * Validação da entrada para ter certeza que o valor é numerico
            */
            $validator =  Validator::make(['id' => $marcaid],
            [
                    'id' => 'integer'
            ]);
            //Caso não seja válido, levantar exceção
            if($validator->fails()) {
                throw ValidationException::withMessages(['id' => __("marca.validationidmustnumeric")]);
            }

            /*
            * Continua o fluxo para a execução
            */            
            $marca = Marca::findorFail($marcaid);
            return response() -> json([
                'status' => 200,
                'mensagem' => __("marca.returned"),
                'marca' => new MarcaResource($marca)
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
                        'mensagem' => __("marca.exceptionnotfound"),
                        'marca' => []
                    ], 404);
                    break;
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' =>  $ex->getMessage(),
                        'marca' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'marca' => []
                    ], 500);
                    break;
            }
        }


    }

    /**
     * @OA\Patch(
     *  path ="/api/marcas/{id}",
     *  operationId = "patchMarca",
     *  tags = {"Marcas"},
     *  summary = "Atualiza os dados de uma marca.",
     *  description = "Atualiza e retorna o JSON de uma nova Marca.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\Parameter(
     *      name="id",
     *      description="Id da Marca",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(ref="#/components/schemas/Marca")
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/MarcaResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/MarcaResponseException500")
     *  ),
     * @OA\Response(
     *      response = 404,
     *      description = "Marca não encontrada.",
     *      @OA\JsonContent(ref = "#/components/schemas/MarcaResponseException404")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/MarcaResponseException406")
     *  )
     * )
     */
    public function update(StoreMarcaRequest $request, $marcaid)
    {
        try {
            /*
            * Validação da entrada para ter certeza que o valor é numerico
            */
            $validator =  Validator::make(['id' => $marcaid],
            [
                'id' => 'integer'
            ]);
            //Caso não seja válido, levantar exceção
            if($validator->fails()) {
                throw ValidationException::withMessages(['id' => __("marca.validationidmustnumeric")]);
            }            

            /*
            * Continua o fluxo para a execução
            */
            $marca = Marca::findorFail($marcaid);            
            $marca->nomedamarca = $request->nome_da_marca;
            $marca->update();
            return response() -> json([
                'status' => 200,
                'mensagem' => __("marca.updated"),
                'marca' => new MarcaResource($marca)
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
                        'mensagem' => __("marca.exceptionnotfound"),
                        'marca' => []
                    ], 404);
                    break;
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' => $ex->getMessage(),
                        'marca' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'marca' => []
                    ], 500);
                    break;
            }
        }
    }

    /**
     * @OA\Delete(
     *  path ="/api/marcas/{id}",
     *  operationId = "deleteMarca",
     *  tags = {"Marcas"},
     *  summary = "Apaga os dados de uma categoria.",
     *  description = "Apaga e retorna o JSON de confirmação.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\Parameter(
     *      name="id",
     *      description="Id da Marca",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/MarcaResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/MarcaResponseException500")
     *  ),
     * @OA\Response(
     *      response = 404,
     *      description = "Marca não encontrada.",
     *      @OA\JsonContent(ref = "#/components/schemas/MarcaResponseException404")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/MarcaResponseException406")
     *  )
     * )
     */
    public function destroy($marcaid)
    {
        try {
            /*
            * Validação da entrada para ter certeza que o valor é numerico
            */
            $validator =  Validator::make(['id' => $marcaid],
            [
                'id' => 'integer'
            ]);
            //Caso não seja válido, levantar exceção
            if($validator->fails()) {
                throw ValidationException::withMessages(['id' => __("marca.validationidmustnumeric")]);
            }

            /*
            * Continua o fluxo para a execução
            */
            $marca = Marca::findorFail($marcaid);            

            $marca->delete();
            
            return response() -> json([
                'status' => 200,
                'mensagem' => __("marca.deleted"),
                'marca' => []
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
                        'mensagem' => __("marca.exceptionnotfound"),
                        'marca' => []
                    ], 404);
                    break;
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' => $ex->getMessage(),
                        'marca' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'marca' => []
                    ], 500);
                    break;
            }
        }
    }
}
