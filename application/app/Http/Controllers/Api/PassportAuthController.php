<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ControllerAuthentication;
use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Resources\PassportResource;

class PassportAuthController extends ControllerAuthentication
{
    /**
     * @OA\Post(
     *      path="/api/register",
     *      operationId="register",
     *      tags={"Seguranca"},
     *      summary="Cria um novo usuario.",
     *      description="Retorna o Token de autenticação.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AuthRegisterRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operação executada com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/AuthResponse")
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description = "Ocorreu um erro interno.",
     *          @OA\JsonContent(ref = "#/components/schemas/AuthResponseException500")
     *       )
     * )
     */
    public function register(Request $request) {
        try {
            /*
            * Valida a entrada para registrar para o usuario
            */
            $this->validate($request, [
                'nome' => 'required|min:4',
                'email' => 'required|email',
                'senha' => 'required|min:8'
            ]);
    
            /* 
            * Cria o novo usuario
            */
            $user = User::create([
                'name' => $request->nome,
                'email' => $request->email,
                'password' => bcrypt($request->senha)
            ]);
    
            // Gera o token do usuario
            $token = $user->createToken('Laravel-9-Passport-Auth')->accessToken;
    
            return response()->json([
                'status' => 200,
                'mensagem' => __("passport.created"),
                'token' => $token
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
                        'token' => []
                    ], 500);
                    break;
            }
        }   
    }

    /**
     * @OA\Post(
     *      path="/api/login",
     *      operationId="login",
     *      tags={"Seguranca"},
     *      summary="Login do usuario.",
     *      description="Retorna o Token de autenticação.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AuthLoginRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operação executada com sucesso.",
     *          @OA\JsonContent(ref="#/components/schemas/AuthResponse")
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description = "Ocorreu um erro interno.",
     *          @OA\JsonContent(ref = "#/components/schemas/AuthResponseException500")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description = "Não encontrado.",
     *          @OA\JsonContent(ref = "#/components/schemas/AuthResponseException404")
     *       ),
     *      @OA\Response(
     *          response=406,
     *          description = "Acesso não autorizado.",
     *          @OA\JsonContent(ref = "#/components/schemas/AuthResponseException406")
     *       )
     * )
     */    
    public function login(Request $request) {
        try {
            $data = [
                'email' => $request->email,
                'password' => $request->senha
            ];
    
            if(auth()->attempt($data)) {
                $token = auth()->user()->createToken('Laravel-9-Passport-Auth')->accessToken;
    
                return response()->json([
                    'status' => 200,
                    'mensagem' => __("passport.login"),
                    'token' => $token
                ], 200);
            } else {
                return response()->json([
                    'status' => 401,
                    'mensagem' => __("passport.unauthorised"),
                    'token' => []
                 ], 401);
            }
        } catch(\Exception $ex) {
            /*
            * Tratamento das exceções levantadas
            */
            $class = get_class($ex); // Pega a classe da exceção 
            switch($class) {
                case ModelNotFoundException::class: //Caso não exista o id na base
                    return response() -> json([
                        'status' => 404,
                        'mensagem' => __("passport.exceptionnotfound"),
                        'token' => []
                    ], 404);
                    break;
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' =>  $ex->getMessage(),
                        'token' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'token' => $ex->getMessage()
                    ], 500);
                    break;
            }
        }

    }

    /**
     * @OA\Post(
     *      path="/api/logout",
     *      operationId="logout",
     *      tags={"Seguranca"},
     *      summary="Logout do usuario.",
     *      description="Retorna o Token de autenticação.",
     *      security = {{"bearerAuth":{}}}, 
     *      @OA\Response(
     *          response=200,
     *          description="Operação executada com sucesso.",
     *          @OA\JsonContent(ref="#/components/schemas/AuthResponse")
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description = "Ocorreu um erro interno.",
     *          @OA\JsonContent(ref = "#/components/schemas/AuthResponseException500")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description = "Não encontrado.",
     *          @OA\JsonContent(ref = "#/components/schemas/AuthResponseException404")
     *       ),
     *      @OA\Response(
     *          response=406,
     *          description = "Acesso não autorizado.",
     *          @OA\JsonContent(ref = "#/components/schemas/AuthResponseException406")
     *       )
     * )
     */     
    public function logout(Request $request) {
        try {
            //Captura o token
            $accessToken = auth()->user()->token();

            $token = $request->user()->tokens->find($accessToken);
    
            $token->revoke();
    
            return response()->json([
                'status' => 200,
                'mensagem' => __("passport.loggout"),
                'token' => []
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
                        'mensagem' => __("passport.exceptionnotfound"),
                        'token' => []
                    ], 404);
                    break;
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' =>  $ex->getMessage(),
                        'token' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'token' => []
                    ], 500);
                    break;
            }
        }
    }

    /**
     * @OA\Get(
     *      path="/api/user",
     *      operationId="user",
     *      tags={"Seguranca"},
     *      summary="Retorna as informações do usuário logado.",
     *      description="Retorna o Token de autenticação.",
     *      security = {{"bearerAuth":{}}}, 
     *      @OA\Response(
     *          response=200,
     *          description="Operação executada com sucesso.",
     *          @OA\JsonContent(ref="#/components/schemas/AuthUserResponse")
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description = "Ocorreu um erro interno.",
     *          @OA\JsonContent(ref = "#/components/schemas/AuthUserResponseException500")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description = "Não encontrado.",
     *          @OA\JsonContent(ref = "#/components/schemas/AuthUserResponseException404")
     *       ),
     *      @OA\Response(
     *          response=406,
     *          description = "Acesso não autorizado.",
     *          @OA\JsonContent(ref = "#/components/schemas/AuthUserResponseException406")
     *       )
     * )
     */  
    public function userInfo() {
        try {
            $user = auth()->user();

            return response()->json([
                'status' => 200,
                'mensagem' => __("passport.userInfo"),
                'usuario' => new PassportResource($user)
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
                        'mensagem' => __("passport.exceptionnotfound"),
                        'usuario' => []
                    ], 404);
                    break;
                case \Illuminate\Validation\ValidationException::class: //Caso seja erro de validação
                    return response() -> json([
                        'status' => 406,
                        'mensagem' =>  $ex->getMessage(),
                        'usuario' => []
                    ], 406);
                    break;
                default: // Algum erro interno ocorreu 
                    return response() -> json([
                        'status' => 500,
                        'mensagem' => __("exception.internalerror"),
                        'usuario' => []
                    ], 500);
                    break;
            }
        }
    }
}
