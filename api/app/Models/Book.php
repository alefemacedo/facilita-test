<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code'
    ];

    /**
     * Retorna uma collection com todos os recibos
     * vinculados a este livro
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     * @author Álefe Macedo
     */
    public function receipts() {
        return $this->hasMany(Receipt::class);
    }    
}