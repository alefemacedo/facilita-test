<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'book_id', 'days'
    ];

    /**
     * Retorna a instância de usuário à qual este 
     * recibo pertence
     * 
     * @return App\Models\User
     * @author Álefe Macedo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Retorna a instância de livro à qual este 
     * recibo pertence
     * 
     * @return App\Models\Book
     * @author Álefe Macedo
     */
    public function book() {
        return $this->belongsTo(Book::class);
    }
}