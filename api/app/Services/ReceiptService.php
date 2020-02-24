<?php
namespace App\Services;

use App\Models\Receipt;
use App\Models\User;
use App\Exceptions\NotFoundException;

class ReceiptService {

    public $receiptModel;
    public $userModel;

    /**
     * Constrói uma nova instância de service
     */
    public function __construct(Receipt $receiptModel, User $userModel) {
        $this->receiptModel = $receiptModel;
        $this->userModel = $userModel;
    }

    /**
     * Recebe os parâmetros da requisição e retorna as
     * instâncias de Recibo paginadas e filtradas de
     * acordo com os parâmetros na requisição
     * 
     * @param Array $params Parâmetros da requisição
     * @return Illuminate\Http\Collection $receipts Collection
     * com todas as instâncias de Recibo paginadas
     */
    public function fetchAll($params = null) {
        $filterType = $params['filter_type'] == 'user' ? 'users.name' : 'books.name';
        $receipts = $this->receiptModel
            ->join('users', 'receipts.user_id', '=', 'users.id')
            ->join('books', 'receipts.book_id', '=', 'books.id')
            ->where($filterType, 'like', '%' . $params['filter'] . '%')
            ->select('users.name as user', 'books.name as book', 'receipts.days', 'receipts.id')
            ->paginate(25, ['*'], 'page', $params['page']);

        return $receipts;
    }

    /**
     * Recebe um array com os dados de um empréstimo e
     * cadastra uma nova instância de recibo no banco
     * de dados
     * 
     * @param Array $data Array contendo os dados do
     * formulário
     * @return App\Models\Receipt $receipt instância de
     * Recibo cadastrada que representa o empréstimo
     * @author Álefe Macedo
     */
    public function create($data) {
        $user = $this->userModel->findOrFail($data['user_id']);
        $data['days'] = $user->type == User::$TYPE_STUDENT ? 3 : 10;

        $receipt = $this->receiptModel->create($data);

        return $receipt;
    }

    /**
     * Recebe o ID de um recibo de empréstimo
     * e retorna os dados do recibo caso este exista,
     * juntamente com os dados do Livro e Usuário
     * 
     * @param Integer $id ID da instància de Recibo
     * cadastrada
     * @return App\Models\Receipt $receipt Instância de
     * Recibo com os dados de Livro e Usuário
     */
    public function fetch($id) {
        $receipt = $this->receiptModel->with('user', 'book')
            ->findOrFail($id);
        if (is_null($receipt)) throw new NotFoundException("Não existe nenhum recibo cadastrado para o ID informado");

        // Altera o tipo do Usuário para receber a String referente
        // a este
        $receipt->user->type = User::getTypeString($receipt->user->type);

        return $receipt;
    }

    /**
     * Recebe o ID de uma instância de Recibo no
     * banco de dados e a remove
     * 
     * @param Integer $id ID da instância a ser removida
     * @return void
     */
    public function remove($id) {
        $receipt = $this->receiptModel->findOrFail($id);

        if (is_null($receipt)) throw new NotFoundException('Não existe uma instância de Recibo cadastrada com o ID informado');

        $receipt->delete();
    }
}