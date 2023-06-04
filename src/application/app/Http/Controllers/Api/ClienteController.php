<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Resources\ClienteResource;
use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * @OA\Get(
     *  path ="/api/clientes",
     *  operationId = "getClientesList",
     *  tags = {"Clientes"},
     *  summary = "Retorna a Lista de Clientes.",
     *  description = "Retorna o JSON da Lista de Clientes.",
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
     *          summary = "Ordenação ascedente por nome",
     *          example = "+nome",
     *          value = "+nome"
      *      ),
     *      @OA\Examples(
     *          summary = "Ordenação descendente por nome",
     *          example = "-nome",
     *         value = "-nome"
     *      ),
     *      @OA\Examples(
     *          summary = "Ordenação ascedente por email",
     *          example = "+email",
     *          value = "+email"
      *      ),
     *      @OA\Examples(
     *          summary = "Ordenação descendente por email",
     *          example = "-email",
     *         value = "-email"
     *      ),
     *      @OA\Examples(
     *          summary = "Ordenação ascedente por cidade",
     *          example = "+cidade",
     *          value = "+cidade"
      *      ),
     *      @OA\Examples(
     *          summary = "Ordenação descendente por cidade",
     *          example = "-cidade",
     *         value = "-cidade"
     *      ),
     *      @OA\Examples(
     *          summary = "Ordenação ascedente por estado",
     *          example = "+estado",
     *          value = "+estado"
      *      ),
     *      @OA\Examples(
     *          summary = "Ordenação descendente por estado",
     *          example = "-estado",
     *         value = "-estado"
     *      )
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/ClientesResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/ClientesResponseException500")
     *  )
     * )
     */
    public function index(Request $request)
    {
        try {
            // Se há input
            if($request->input('ordenacao','')) {
                $sorts = explode(',', $request->input('ordenacao',''));

                $query = Cliente::query();
                foreach($sorts as $sortColumn) {
                    $sortDirection = Str::startsWith($sortColumn,'-')?'desc':'asc';
                    $sortColumn = ltrim($sortColumn, '-');

                    // Transforma os nomes dos parametros em nomes dos campos do Modelo
                    switch($sortColumn) {
                        case("nome"):
                            $query->orderBy('nome', $sortDirection);
                            break;
                        case("email"):
                            $query->orderBy('email', $sortDirection);
                            break;
                        case("cidade"):
                            $query->orderBy('cidade', $sortDirection);
                            break;
                        case("estado"):
                            $query->orderBy('estado', $sortDirection);
                            break;                        
                    }
                }            
                $clientes = $query->get();
            }
            else {
                $clientes = Cliente::all();
            }
            return response() -> json([
                'status' => 200,
                'mensagem' => __("cliente.listreturn"),
                'clientes' => ClienteResource::collection($clientes)
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
                        'clientes' => []
                    ], 500);
                    break;
            }
        }
    }

    /**
     * @OA\Post(
     *  path ="/api/clientes",
     *  operationId = "postCliente",
     *  tags = {"Clientes"},
     *  summary = "Armazena os dados de um novo Cliente.",
     *  description = "Armazena e retorna o JSON de um novo Cliente.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\RequestBody(
     *      required = true,
     *      @OA\JsonContent(ref = "#/components/schemas/ClienteNewRequest")
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/ClienteResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/ClienteResponseException500")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/ClienteResponseException406")
     *  )
     * )
     */
    public function store(StoreClienteRequest $request)
    {
        try {
            // Cria o objeto 
            $cliente =new Cliente();
            // Transfere os valores
            $cliente->nome = $request->nome;
            $cliente->telefone = $request->telefone;
            $cliente->email = $request->email;
            $cliente->rua = $request->rua;
            $cliente->cidade = $request->cidade;
            $cliente->estado = $request->estado;
            $cliente->cep = $request->cep;
            // Salva
            $cliente->save();

            // Retorna o resultado
            return response() -> json([
                'status' => 200,
                'mensagem' => __("cliente.created"),
                'cliente' => new ClienteResource($cliente)
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
                        'cliente' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'cliente' => []
                    ], 500);
                    break;
            }
        }
    }

    /**
     * @OA\Get(
     *  path ="/api/clientes/{id}",
     *  operationId = "getCliente",
     *  tags = {"Clientes"},
     *  summary = "Retorna os dados de um Cliente.",
     *  description = "Retorna o JSON de um Cliente.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\Parameter(
     *      name="id",
     *      description="Id do Cliente",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/ClienteResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/ClienteResponseException500")
     *  ),
     * @OA\Response(
     *      response = 404,
     *      description = "Cliente não encontrado.",
     *      @OA\JsonContent(ref = "#/components/schemas/ClienteResponseException404")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/ClienteResponseException406")
     *  )
     * )
     */
    public function show($clienteid)
    {
        try {
            /*
            * Validação da entrada para ter certeza que o valor é numerico
            */
            $validator =  Validator::make(['id' => $clienteid],
            [
                    'id' => 'integer'
            ]);
            //Caso não seja válido, levantar exceção
            if($validator->fails()) {
                throw ValidationException::withMessages(['id' => __("cliente.validationidmustnumeric")]);
            }

            /*
            * Continua o fluxo para a execução
            */
            $cliente = Cliente::findorFail($clienteid);

            return response() -> json([
                'status' => 200,
                'mensagem' => __("cliente.returned"),
                'cliente' => new ClienteResource($cliente)
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
                        'mensagem' => __("cliente.exceptionnotfound"),
                        'cliente' => []
                    ], 404);
                    break;
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' =>  $ex->getMessage(),
                        'cliente' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'cliente' => []
                    ], 500);
                    break;
            }
        }
    }

    /**
     * @OA\Patch(
     *  path ="/api/clientes/{id}",
     *  operationId = "patchCliente",
     *  tags = {"Clientes"},
     *  summary = "Atualiza os dados de um cliente.",
     *  description = "Atualiza e retorna o JSON de um Cliente.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\Parameter(
     *      name="id",
     *      description="Id do Cliente",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(ref="#/components/schemas/Cliente")
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/ClienteResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/ClienteResponseException500")
     *  ),
     * @OA\Response(
     *      response = 404,
     *      description = "Cliente não encontrado.",
     *      @OA\JsonContent(ref = "#/components/schemas/ClienteResponseException404")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/ClienteResponseException406")
     *  )
     * )
     */
    public function update(Request $request, $clienteid)
    {
        try {
            /*
            * Validação da entrada para ter certeza que o valor é numerico
            */
            $validator =  Validator::make(['id' => $clienteid],
            [
                'id' => 'integer'
            ]);
            //Caso não seja válido, levantar exceção
            if($validator->fails()) {
                throw ValidationException::withMessages(['id' => __("cliente.validationidmustnumeric")]);
            }            

            /*
            * Continua o fluxo para a execução
            */
            $cliente = Cliente::findorFail($clienteid);
            $cliente->nome = $request->nome;
            $cliente->telefone = $request->telefone;
            $cliente->email = $request->email;
            $cliente->rua = $request->rua;
            $cliente->cidade = $request->cidade;
            $cliente->estado = $request->estado;
            $cliente->cep = $request->cep;

            $cliente->update();
            return response() -> json([
                'status' => 200,
                'mensagem' => __("cliente.updated"),
                'cliente' => new ClienteResource($cliente)
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
                        'mensagem' => __("cliente.exceptionnotfound"),
                        'cliente' => []
                    ], 404);
                    break;
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' => $ex->getMessage(),
                        'cliente' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'cliente' => []
                    ], 500);
                    break;
            }
        }
    }

    /**
     * @OA\Delete(
     *  path ="/api/clientes/{id}",
     *  operationId = "deleteCliente",
     *  tags = {"Clientes"},
     *  summary = "Apaga os dados de um cliente.",
     *  description = "Apaga e retorna o JSON de confirmação.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\Parameter(
     *      name="id",
     *      description="Id do Cliente",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/ClienteResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/ClienteResponseException500")
     *  ),
     * @OA\Response(
     *      response = 404,
     *      description = "Cliente não encontrado.",
     *      @OA\JsonContent(ref = "#/components/schemas/ClienteResponseException404")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/ClienteResponseException406")
     *  )
     * )
     */
    public function destroy($clienteid)
    {
        try {
            /*
            * Validação da entrada para ter certeza que o valor é numerico
            */
            $validator =  Validator::make(['id' => $clienteid],
            [
                'id' => 'integer'
            ]);
            //Caso não seja válido, levantar exceção
            if($validator->fails()) {
                throw ValidationException::withMessages(['id' => __("cliente.validationidmustnumeric")]);
            }

            /*
            * Continua o fluxo para a execução
            */
            $cliente = Cliente::findorFail($clienteid);

            $cliente->delete();

            return response() -> json([
                'status' => 200,
                'mensagem' => __("cliente.deleted"),
                'cliente' => []
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
                        'mensagem' => __("cliente.exceptionnotfound"),
                        'cliente' => []
                    ], 404);
                    break;
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' => $ex->getMessage(),
                        'cliente' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'cliente' => []
                    ], 500);
                    break;
            }
        }
    }
}
