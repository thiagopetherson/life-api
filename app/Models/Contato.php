<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pessoa;

class Contato extends Model
{
    use HasFactory;

    protected $fillable = ['pessoa_id','telefone'];

    // Formatando a saída da data
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    // Relacionamento com Pessoa
    public function pessoa(){
        return $this->belongsTo(Pessoa::class);
    }
}
