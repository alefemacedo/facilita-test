<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    public static $TYPE_STUDENT = 'S';
    public static $TYPE_TEACHER = 'T';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type'
    ];

    /**
     * Retorna uma collection com todos os recibos
     * vinculados a este usuário
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     * @author Álefe Macedo
     */
    public function receipts() {
        return $this->hasMany(Receipt::class);
    }

    public static function getAllTypes() {
        return [self::$TYPE_STUDENT => 'Aluno', self::$TYPE_TEACHER => 'Professor'];
    }

    public static function getTypeString($type) {
        if (isset(self::getAllTypes()[$type])) {
            return self::getAllTypes()[$type];
        }
    }
}
