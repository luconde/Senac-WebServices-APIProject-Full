<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\StorePedidoRequest;
use App\Http\Resources\PedidoResource;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Itemdopedido;

class PedidoController extends Controller
{
    /**
     * @OA\Get(
     *  path ="/api/clientes/{id}/pedidos",
     *  operationId = "getPedidosList",
     *  tags = {"Pedidos"},
     *  summary = "Retorna a Lista de Pedidos.",
     *  description = "Retorna o JSON da Lista de Pedidos.",
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
     *  @OA\Parameter(
     *      name="ordenacao",
     *      in="query",
     *      description="Ordernação dos dados",
     *      required=false,
     *      @OA\Schema(
     *          type="string"
     *      )
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/PedidosResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/PedidosResponseException500")
     *  )
     * )
     */
    public function index($clienteid, Request $request)
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
                throw ValidationException::withMessages(['id' => __("pedido.validationidmustnumericCliente")]);
            }

            /*
            * Continua o fluxo para a execução
            */              
            $cliente = Cliente::findorFail($clienteid);              
            
            // Captura a coluna para ordenacao
            $sortParameter = $request->input('ordenacao','data_do_pedido');
            $sortDirection = Str::startsWith($sortParameter,'-') ? 'desc':'asc';
            $sortColumn = ltrim($sortParameter,'-');

            // Determina se faz a query ordenada ou aplica o default
            if($sortColumn == 'data_do_pedido') {
                $pedidos = Pedido::with(['Cliente','itensdopedido','itensdopedido.produto'])->where('fkcliente', $clienteid)->orderBy('datadopedido', $sortDirection)->get();
            }
            else {
                $pedidos = Pedido::with(['Cliente','itensdopedido','itensdopedido.produto'])->where('fkcliente', $clienteid)->get();
            }

            return response() -> json([
                'status' => 200,
                'mensagem' => __("pedido.listreturn"),
                'pedidos' => PedidoResource::collection($pedidos),
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
                        'mensagem' => __("itemdopedido.exceptionPedidonotfound"),
                        'pedidos' => []
                    ], 404);
                    break;                
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' =>  $ex->getMessage(),
                        'pedidos' => []
                    ], 406);
                    break;                  
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'pedidos' => []
                    ], 500);
                    break;
            }
        }
    }
        
    /**
     * @OA\Post(
     *  path ="/api/clientes/{1}/pedidos",
     *  operationId = "postPedido",
     *  tags = {"Pedidos"},
     *  summary = "Armazena os dados de um novo Pedido.",
     *  description = "Armazena e retorna o JSON de um novo Pedido.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\RequestBody(
     *      required = true,
     *      @OA\JsonContent(ref = "#/components/schemas/PedidoNewRequest")
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/PedidoResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/PedidoResponseException500")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/PedidoResponseException406")
     *  )
     * )
     */
    public function store(Cliente $cliente, StorePedidoRequest $request)
    {
        try {
            // Cria o objeto 
            $pedido =new Pedido();
            // Transfere os valores
            $pedido->fkcliente = $cliente->pkcliente;
            $pedido->statusdopedido = 0;
            $pedido->datadopedido = Carbon::now()->format('Y-m-d');
            $pedido->datarequisitada = $request->data_requisitada;
            // Salva
            $pedido->save();
            // Retorna o resultado
            return response() -> json([
                'status' => 200,
                'mensagem' => __("pedido.created"),
                'pedido' => new PedidoResource($pedido)
            ], 200);
        }catch(\Exception $ex) {
            /*
            * Tratamento das exceções levantadas
            */
            $class = get_class($ex); // Pega a classe da exceção 
            switch($class) {
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' =>  $ex->getMessage(),
                        'pedido' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'pedido' => []
                    ], 500);
                    break;
            }
        }
    }

    /**
     * @OA\Get(
     *  path ="/api/pedidos/{id}",
     *  operationId = "getPedido",
     *  tags = {"Pedidos"},
     *  summary = "Retorna os dados de um Pedido.",
     *  description = "Retorna o JSON de um Pedido.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\Parameter(
     *      name="id",
     *      description="Id do Pedido",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/PedidoResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/PedidoResponseException500")
     *  ),
     * @OA\Response(
     *      response = 404,
     *      description = "Pedido não encontrada.",
     *      @OA\JsonContent(ref = "#/components/schemas/PedidoResponseException404")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/PedidoResponseException406")
     *  )
     * )
     */
    public function show($pedidoid)
    {
        try {
            /*
            * Validação da entrada para ter certeza que o valor é numerico
            */
            $validator =  Validator::make(['id' => $pedidoid],
            [
                    'id' => 'integer'
            ]);
            //Caso não seja válido, levantar exceção
            if($validator->fails()) {
                throw ValidationException::withMessages(['id' => __("pedido.validationidmustnumeric")]);
            }

            /*
            * Continua o fluxo para a execução
            */              
            $pedido = Pedido::with(['cliente','itensdopedido','itensdopedido.produto'])->findorFail($pedidoid);

            return response() -> json([
                'status' => 200,
                'mensagem' => __("pedido.returned"),
                'pedido' => new PedidoResource($pedido)
            ], 200);
        }catch(\Exception $ex) {
            /*
            * Tratamento das exceções levantadas
            */
            $class = get_class($ex); // Pega a classe da exceção 
            switch($class) {
                case ModelNotFoundException::class: //Caso não exista o id na base
                    return response() -> json([
                        'status' => 404,
                        'mensagem' => __("pedido.exceptionnotfound"),
                        'pedido' => []
                    ], 404);
                    break;
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' =>  $ex->getMessage(),
                        'pedido' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'pedido' => []
                    ], 500);
                    break;
            }
        }
    }

    /**
     * @OA\Patch(
     *  path ="/api/pedidos/{id}",
     *  operationId = "patchPedido",
     *  tags = {"Pedidos"},
     *  summary = "Atualiza os dados de um pedido.",
     *  description = "Atualiza e retorna o JSON de um Pedido.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\Parameter(
     *      name="id",
     *      description="Id do Pedido",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(ref="#/components/schemas/PedidoNewRequest")
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/PedidoResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/PedidoResponseException500")
     *  ),
     * @OA\Response(
     *      response = 404,
     *      description = "Pedido não encontrado.",
     *      @OA\JsonContent(ref = "#/components/schemas/PedidoResponseException404")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/CategoriaResponseException406")
     *  )
     * )
     */
    public function update(StorePedidoRequest $request, $pedidoid)
    {
        try {
            /*
            * Validação da entrada para ter certeza que o valor é numerico
            */
            $validator =  Validator::make(['id' => $pedidoid],
            [
                'id' => 'integer'
            ]);
            //Caso não seja válido, levantar exceção
            if($validator->fails()) {
                throw ValidationException::withMessages(['id' => __("pedido.validationidmustnumeric")]);
            }            

            /*
            * Continua o fluxo para a execução
            */            
            $pedido = Pedido::findorFail($pedidoid);
            $pedido->datarequisitada = $request->data_requisitada;
            $pedido->update();
            return response() -> json([
                'status' => 200,
                'mensagem' => __("pedido.updated"),
                'pedido' => new PedidoResource($pedido)
            ], 200);
        }catch(\Exception $ex) {
            /*
            * Tratamento das exceções levantadas
            */
            $class = get_class($ex); // Pega a classe da exceção
            switch($class) {
                case ModelNotFoundException::class: //Caso não exista o id na base
                    return response() -> json([
                        'status' => 404,
                        'mensagem' => __("pedido.exceptionnotfound"),
                        'pedido' => []
                    ], 404);
                    break;
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' => $ex->getMessage(),
                        'pedido' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'pedido' => []
                    ], 500);
                    break;
            }
        }
    }

    /**
     * @OA\Delete(
     *  path ="/api/pedidos/{id}",
     *  operationId = "deletePedido",
     *  tags = {"Pedidos"},
     *  summary = "Apaga os dados de um pedido.",
     *  description = "Apaga e retorna o JSON de confirmação.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\Parameter(
     *      name="id",
     *      description="Id do Pedido",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/PedidoResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/PedidoResponseException500")
     *  ),
     * @OA\Response(
     *      response = 404,
     *      description = "Pedido não encontrado.",
     *      @OA\JsonContent(ref = "#/components/schemas/PedidoResponseException404")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/PedidoResponseException406")
     *  )
     * )
     */
    public function destroy($pedidoid)
    {
        try {
            /*
            * Validação da entrada para ter certeza que o valor é numerico
            */
            $validator =  Validator::make(['id' => $pedidoid],
            [
                'id' => 'integer'
            ]);
            //Caso não seja válido, levantar exceção
            if($validator->fails()) {
                throw ValidationException::withMessages(['id' => __("pedido.validationidmustnumeric")]);
            }

            /*
            * Continua o fluxo para a execução
            */
            $pedido = Pedido::findorFail($pedidoid);               

            $pedido->delete();
            return response() -> json([
                'status' => 200,
                'mensagem' => __("pedido.deleted"),
                'pedido' => []
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
                        'mensagem' => __("pedido.exceptionnotfound"),
                        'pedido' => []
                    ], 404);
                    break;
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' => $ex->getMessage(),
                        'pedido' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'pedido' => []
                    ], 500);
                    break;
            }
        }

    }
}
