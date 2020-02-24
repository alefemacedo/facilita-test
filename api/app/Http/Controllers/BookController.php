<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{

    protected $bookService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Lista todos os livros cadastrados formatados
     * em um array
     * 
     * @param Request $request Parâmetros da requisição
     * @return Response $response
     */
    public function index(Request $request) {
        $return = [];
        $statusCode = Response::HTTP_OK;

        try {
            $return = $this->bookService->fetchAll();
        } catch (\Exception $e) {
            $return['message'] = $e->getMessage();
            $statusCode = Response::HTTP_EXPECTATION_FAILED;
        }

        return response()->json(compact('return'))->setStatusCode($statusCode, Response::$statusTexts[$statusCode]);
    }

    /**
     * Recebe os dados do formulário pela requisição
     * e cadastra um novo livro de acordo com esses
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
                'code' => 'required|unique:books'
            ],
            [
                'name.required' => 'O campo nome é obrigatório',
                'code.required' => 'O campo código é obrigatório',
                'code.unique' => 'Já existe uma instância de Livro com o código informado'
            ]
        );

        try {
            $book = $this->bookService->create($data);
            $return['message'] = 'O livro ' . $book->name . ' foi cadastrado com sucesso.';
        } catch (\Exception $e) {
            $return['message'] = $e->getMessage();
            $statusCode = Response::HTTP_EXPECTATION_FAILED;
        }

        return response()->json(compact('return'))->setStatusCode($statusCode, Response::$statusTexts[$statusCode]);
    }
}
