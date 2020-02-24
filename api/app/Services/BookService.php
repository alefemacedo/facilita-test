<?php
namespace App\Services;

use App\Models\Book;

class BookService {

    public $bookModel;

    /**
     * Constrói uma nova instância de service
     */
    public function __construct(Book $bookModel) {
        $this->bookModel = $bookModel;
    }

    /**
     * Recebe os parâmetros da requisição e retorna as
     * instâncias de Livro formatadas em um Array
     * 
     * @param Array $params Parâmetros da requisição
     * @return Array $books Array com as instâncias de
     * Livro formatadas
     */
    public function fetchAll($params = null) {
        $books = $this->bookModel
            ->all()
            ->map(function ($book) {
                return [
                    'value' => $book->id,
                    'text' => $book->name
                ];
            })
            ->toArray();

        return $books;
    }

    /**
     * Recebe um array com os dados de um livro e
     * cadastra uma nova instância no banco de dados
     * 
     * @param Array $data Array contendo os dados do
     * formulário
     * @return App\Models\Book $book instância de Livro
     * cadastrada
     * @author Álefe Macedo
     */
    public function create($data) {
        $book = $this->bookModel->create($data);

        return $book;
    }
}