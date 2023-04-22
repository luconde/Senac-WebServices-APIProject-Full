<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\StoreItemdopedidoRequest;
use App\Http\Resources\ItemdopedidoResource;
use App\Models\Itemdopedido;
use App\Models\Pedido;

class ItemdopedidoController extends Controller
{
    /**
     * @OA\Get(
     *  path ="/api/pedidos/{id}/itensdopedido",
     *  operationId = "getItensList",
     *  tags = {"ItensDoPedido"},
     *  summary = "Retorna a Lista de Itens do Pedido.",
     *  description = "Retorna o JSON da Lista de Itens do Pedido.",
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
     *      @OA\JsonContent(ref = "#/components/schemas/ItensDoPedidoResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/ItensDoPedidoResponseException500")
     *  )
     * )
     */
    public function index($pedidoid)
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
                throw ValidationException::withMessages(['id' => __("itemdopedido.validationidmustnumericPedido")]);
            }

            /*
            * Continua o fluxo para a execução
            */              
            $pedido = Pedido::findorFail($pedidoid);             
            $itensdopedido = Itemdopedido::with(['pedido','pedido.cliente'])->where('fkpedido', $pedidoid)->get();

            return response() -> json([
                'status' => 200,
                'mensagem' => __("itemdopedido.listreturn"),
                'itens' => ItemdopedidoResource::collection($itensdopedido)
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
                        'itens' => []
                    ], 404);
                    break;                
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' =>  $ex->getMessage(),
                        'itens' => []
                    ], 406);
                    break;                
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'itens' => []
                    ], 500);
                    break;
            }
        }
    }

    /**
     * @OA\Post(
     *  path ="/api/pedidos/{id}/itensdopedido",
     *  operationId = "postItem",
     *  tags = {"ItensDoPedido"},
     *  summary = "Armazena os dados de um novo Item do Pedido.",
     *  description = "Armazena e retorna o JSON de um novo Item do Pedido.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\RequestBody(
     *      required = true,
     *      @OA\JsonContent(ref = "#/components/schemas/ItemNewRequest")
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/ItemResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/ItemResponseException500")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/ItemResponseException406")
     *  )
     * )
     */
    public function store(StoreItemdopedidoRequest $request, $item)
    {
        try {
            $itemdopedido = new Itemdopedido();
            $itemdopedido->desconto = $request->desconto;
            $itemdopedido->precodelista = $request->preco_de_lista;
            $itemdopedido->quantidade = $request->quantidade;
            $itemdopedido->fkpedido = $item;
            $itemdopedido->fkproduto = $request->produto['id'];
            $itemdopedido->save();
    
    
            return response() -> json([
                'status' => 200,
                'mensagem' => __("itemdopedido.created"),
                'item' => new ItemdopedidoResource($itemdopedido)
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
                        'item' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'item' => []
                    ], 500);
                    break;
            }
        }
    }

    /**
     * @OA\Get(
     *  path ="/api/pedidos/{iddopedido}/itensdopedido/{iddoitem}",
     *  operationId = "getItem",
     *  tags = {"ItensDoPedido"},
     *  summary = "Retorna os dados de um Item do Pedido.",
     *  description = "Retorna o JSON de um Item do Pedido.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\Parameter(
     *      name="iddopedido",
     *      description="Id do Pedido",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Parameter(
     *      name="iddoitem",
     *      description="Id do Item do Pedido",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),     
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/ItemResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/ItemResponseException500")
     *  ),
     * @OA\Response(
     *      response = 404,
     *      description = "Pedido não encontrada.",
     *      @OA\JsonContent(ref = "#/components/schemas/ItemResponseException404")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/ItemResponseException406")
     *  )
     * )
     */
    public function show($pedidoid, $itemid)
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
                throw ValidationException::withMessages(['id' => __("itemdopedido.validationidmustnumericPedido")]);
            }

            /*
            * Validação da entrada para ter certeza que o valor é numerico
            */
            $validator =  Validator::make(['id' => $itemid],
            [
                    'id' => 'integer'
            ]);
            //Caso não seja válido, levantar exceção
            if($validator->fails()) {
                throw ValidationException::withMessages(['id' => __("itemdopedido.validationidmustnumericItemDoPedido")]);
            }

            /*
            * Continua o fluxo para a execução
            */            
            $itemdopedido = Itemdopedido::findorFail($itemid);

            return response() -> json([
                'status' => 200,
                'mensagem' => __("itemdopedido.returned"),
                'item' => new ItemdopedidoResource($itemdopedido)
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
                        'mensagem' => __("itemdopedido.exceptionnotfound"),
                        'item' => []
                    ], 404);
                    break;
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' =>  $ex->getMessage(),
                        'item' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'item' => []
                    ], 500);
                    break;
            }
        }

    }

    /**
     * @OA\Patch(
     *  path ="/api/pedidos/{iddopedido}/itensdopedido/{iddoitem}",
     *  operationId = "patchItem",
     *  tags = {"ItensDoPedido"},
     *  summary = "Atualiza os dados de um Item do Pedido.",
     *  description = "Atualiza e retorna o JSON de um Item do Pedido.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\Parameter(
     *      name="iddopedido",
     *      description="Id do Pedido",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Parameter(
     *      name="iddoitem",
     *      description="Id do Item do Pedido",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),  
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(ref="#/components/schemas/ItemNewRequest")
     *  ),
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/ItemResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/ItemResponseException500")
     *  ),
     * @OA\Response(
     *      response = 404,
     *      description = "Item do pedido não encontrado.",
     *      @OA\JsonContent(ref = "#/components/schemas/ItemResponseException404")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/ItemResponseException406")
     *  )
     * )
     */
    public function update(StoreItemdopedidoRequest $request, $pedidoid, $itemid)
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
                throw ValidationException::withMessages(['id' => __("itemdopedido.validationidmustnumericPedido")]);
            }

            /*
            * Validação da entrada para ter certeza que o valor é numerico
            */
            $validator =  Validator::make(['id' => $itemid],
            [
                    'id' => 'integer'
            ]);
            //Caso não seja válido, levantar exceção
            if($validator->fails()) {
                throw ValidationException::withMessages(['id' => __("itemdopedido.validationidmustnumericItemDoPedido")]);
            }

            /*
            * Continua o fluxo para a execução
            */              
            $itemdopedido = Itemdopedido::findorFail($itemid); 

            $itemdopedido->desconto = $request->desconto;
            $itemdopedido->precodelista = $request->preco_de_lista;
            $itemdopedido->quantidade = $request->quantidade;
            $itemdopedido->update();

            return response() -> json([
                'status' => 200,
                'mensagem' => __("itemdopedido.updated"),
                'item' => new ItemdopedidoResource($itemdopedido)
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
                        'mensagem' => __("itemdopedido.exceptionnotfound"),
                        'item' => []
                    ], 404);
                    break;
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' =>  $ex->getMessage(),
                        'item' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'item' => []
                    ], 500);
                    break;
            }
        }
    }

    /**
     * @OA\Delete(
     *  path ="/api/pedidos/{iddopedido}/itensdopedido/{iddoitem}",
     *  operationId = "deleteItem",
     *  tags = {"ItensDoPedido"},
     *  summary = "Apaga os dados de um pedido.",
     *  description = "Apaga e retorna o JSON de confirmação.",
     *  security = {{"bearerAuth":{}}}, 
     *  @OA\Parameter(
     *      name="iddopedido",
     *      description="Id do Pedido",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ),
     *  @OA\Parameter(
     *      name="iddoitem",
     *      description="Id do Item do Pedido",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *  ), 
     *  @OA\Response (
     *      response = 200,
     *      description = "Operação executada com sucesso.",
     *      @OA\JsonContent(ref = "#/components/schemas/ItemResponse")
     *  ),
     * @OA\Response(
     *      response = 500,
     *      description = "Ocorreu um erro interno.",
     *      @OA\JsonContent(ref = "#/components/schemas/ItemResponseException500")
     *  ),
     * @OA\Response(
     *      response = 404,
     *      description = "Item do pedido não encontrado.",
     *      @OA\JsonContent(ref = "#/components/schemas/ItemResponseException404")
     *  ),
     * @OA\Response(
     *      response = 406,
     *      description = "O campo Id deve ser numérico.",
     *      @OA\JsonContent(ref = "#/components/schemas/ItemResponseException406")
     *  )
     * )
     */
    public function destroy($pedidoid, $itemid)
    {
        try {
            $itemdopedido = Itemdopedido::findorFail($itemid); 

            $itemdopedido->delete();

            return response() -> json([
                'status' => 200,
                'mensagem' => __("itemdopedido.deleted")
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
                        'mensagem' => __("itemdopedido.exceptionnotfound"),
                        'itens' => []
                    ], 404);
                    break;
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' => $ex->getMessage(),
                        'itens' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'itens' => []
                    ], 500);
                    break;
            }
        }

    }
}
