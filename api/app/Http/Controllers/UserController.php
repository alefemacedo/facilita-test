<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class UserController extends Controller
{

    protected $userService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Lista todos os usuários cadastrados formatados
     * em um array
     * 
     * @param Request $request Parâmetros da requisição
     * @return Response $response
     */
    public function index(Request $request) {
        $return = [];
        $statusCode = Response::HTTP_OK;

        try {
            $return = $this->userService->fetchAll();
        } catch (\Exception $e) {
            $return['message'] = $e->getMessage();
            $statusCode = Response::HTTP_EXPECTATION_FAILED;
        }

        return response()->json(compact('return'))->setStatusCode($statusCode, Response::$statusTexts[$statusCode]);
    }

    /**
     * Recebe os dados do formulário pela requisição
     * e cadastra um novo usuário de acordo com esses
     * dados
     * 
     * @param Request $request Requisição com os dados
     * do formulário
     * @return Response $response
     */
    public function create(Request $request) {
        $return = [
            'message' => ''
        ];
        $data = $request->all();
        $statusCode = Response::HTTP_OK;

        // Valida os dados do formulário vindos
        // na requisição
        $this->validate(
            $request,
            [
                'name' => 'required',
                'type' => 'required|in:' . implode(',', array_keys(User::getAllTypes()))
            ],
            [
                'name.required' => 'O campo nome é obrigatório',
                'type.required' => 'O campo tipo é obrigatório',
                'type.in' => 'O campo tipo não apresenta um valor válido'
            ]
        );

        try {
            $user = $this->userService->create($data);
            $return['message'] = 'O usuário ' . $user->name . ' foi cadastrado com sucesso.';
        } catch (\Exception $e) {
            $return['message'] = $e->getMessage();
            $statusCode = Response::HTTP_EXPECTATION_FAILED;
        }

        return response()->json(compact('return'))->setStatusCode($statusCode, Response::$statusTexts[$statusCode]);
    }
}
