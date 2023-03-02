<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contato;

class Pessoa extends Model
{
    use HasFactory;

    protected $fillable = ['nome','email','cpf','data_nasc','nacionalidade','created_at','updated_at'];
    
    // Formatando a saída da data
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    
    // Relacionamento com Contatos
    public function contatos(){
        return $this->hasMany(Contato::class, 'pessoa_id', 'id');
    }
}
