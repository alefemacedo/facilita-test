<?php
namespace App\Services;

use App\Models\User;

class UserService {

    public $userModel;

    /**
     * Constrói uma nova instância de service
     */
    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }

    /**
     * Recebe os parâmetros da requisição e retorna as
     * instâncias de Usuário formatadas em um Array
     * 
     * @param Array $params Parâmetros da requisição
     * @return Array $users Array com as instâncias de
     * Usuário formatadas
     */
    public function fetchAll($params = null) {
        $users = $this->userModel
            ->all()
            ->map(function ($user) {
                return [
                    'value' => $user->id,
                    'text' => $user->name . '-' . User::getTypeString($user->type)
                ];
            })
            ->toArray();

        return $users;
    }

    /**
     * Recebe um array com os dados de um usuário e
     * cadastra uma nova instância no banco de dados
     * 
     * @param Array $data Array contendo os dados do
     * formulário
     * @return App\Models\User $user instância de Usuário
     * cadastrada
     * @author Álefe Macedo
     */
    public function create($data) {
        $user = $this->userModel->create($data);

        return $user;
    }
}