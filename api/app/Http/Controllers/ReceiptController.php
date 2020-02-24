<?php

namespace App\Http\Controllers;

use App\Services\ReceiptService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exceptions\NotFoundException;

class ReceiptController extends Controller
{

    protected $receiptService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ReceiptService $receiptService)
    {
        $this->receiptService = $receiptService;
    }

    /**
     * Lista todos os recibos cadastrados paginados
     * 
     * @param Request $request Parâmetros da requisição
     * @return Response $response
     */
    public function index(Request $request) {
        $filter = $request->get('filter');
        $filterType = $request->get('filter_type');
        $page = $request->get('page');
        $statusCode = Response::HTTP_OK;
        $return = [];

        try {
            $return = $this->receiptService->fetchAll($request->all());

        } catch (\Exception $e) {
            $return['message'] = $e->getMessage();
            $statusCode =Response::HTTP_EXPECTATION_FAILED;
        }

        return response()->json(compact('return'))->setStatusCode($statusCode, Response::$statusTexts[$statusCode]);
    }

    /**
     * Recebe o ID de um recibo nos parâmetros da
     * requisição e retona os dados deste recibo,
     * inclusive os dados do livro e usuário
     * 
     * @param Request $request Requisição com o ID
     * do usuário
     * @return Response $response
     */
    public function fetch(Request $request) {
        $return = null;
        $statusCode = Response::HTTP_OK;

        try {
            $return = $this->receiptService->fetch($request->get('receipt_id'));

        } catch (NotFoundException $e) {
            $statusCode = Response::HTTP_NOT_FOUND;
            $return = ['message' => $e->getMessage()];
        } catch (\Exception $e) {
            $statusCode = Response::HTTP_EXPECTATION_FAILED;
            $return = ['message' => $e->getMessage()];
        }

        return response()->json(compact('return'))->setStatusCode($statusCode, Response::$statusTexts[$statusCode]);
    }

    /**
     * Recebe os dados do formulário pela requisição
     * e cadastra um novo recibo de um empréstimo de
     * livro de acordo com os dados do formulário
     * 
     * @param Request $request Requisição com os dados
     * do formulário
     * @return Response $response
     */
    public function create(Request $request) {
        $return = [
            'message' => '',
            'receipt_id' => ''
        ];
        $data = $request->all();
        $statusCode = Response::HTTP_OK;

        // Valida os dados do formulário vindos
        // na requisição
        $this->validate(
            $request,
            [
                'user_id' => 'required|exists:users,id',
                'book_id' => 'required|exists:books,id'
            ],
            [
                'user_id.required' => 'Por favor selecione um usuário para o empréstimo',
                'user_id.exists' => 'Não existe nenhum usuário cadastrado para o ID informado',
                'book_id.required' => 'Por favor selecione um livro para o empréstimo',
                'book_id.exists' => 'Não existe nenhum livro cadastrado para o ID informado',
            ]
        );

        try {
            $receipt = $this->receiptService->create($data);
            $return['message'] = 'O empréstimo foi realizado com sucesso.';
            $return['receipt_id'] = $receipt->id;

        } catch (\Exception $e) {
            $return['message'] = $e->getMessage();
            $statusCode = Response::HTTP_EXPECTATION_FAILED;
        }

        return response()->json(compact('return'))->setStatusCode($statusCode, Response::$statusTexts[$statusCode]);
    }

    /**
     * Recebe o ID de um recibo pela requisição e
     * remove a instância do banco de dados
     * 
     * @param Request $request Requisição com o ID
     * do recibo a ser removido
     * @return Response $response
     */
    public function remove(Request $request) {
        $return = [
            'message' => ''
        ];
        $statusCode = Response::HTTP_OK;

        try {
            $this->receiptService->remove($request->get('receipt_id'));
            $return['message'] = 'Recibo removido com sucesso.';
        } catch (NotFoundException $e) {
            $statusCode = Response::HTTP_NOT_FOUND;
            $return['message'] = $e->getMessage();
        } catch (\Exception $e) {
            $statusCode = Response::HTTP_EXPECTATION_FAILED;
            $return['message'] = $e->getMessage();
        }

        return response()->json(compact('return'))->setStatusCode($statusCode, Response::$statusTexts[$statusCode]);
    }
}
