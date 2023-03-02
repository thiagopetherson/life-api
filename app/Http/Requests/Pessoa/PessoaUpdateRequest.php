<?php

namespace App\Http\Requests\Pessoa;

use Illuminate\Foundation\Http\FormRequest;

class PessoaUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */    

    // Regras de validações das requisições
    public function rules() {

        //Pegando o id que veio via GET na requisição
        $id = $this->segment(3);

        return [ 
            'nome' => 'required|string|min:3|max:200',
            'cpf' => "required|max:14|unique:pessoas,cpf,{$id},id",
            'email' => "required|email|unique:pessoas,email,{$id},id",
            'data_nasc' => 'required|date',
            'nacionalidade' => 'required|string|max:200'                      
        ];
    }

    // Mensagens de resposta das validações da requisição
    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'min' => 'O campo :attribute deve ter no mínimo 3 caracteres',
            'max' => 'O campo :attribute deve ter no máximo 200 caracteres',
            'email' => 'O campo :attribute deve ser do tipo email',
            'unique' => 'O campo :attribute é já existe',
            'string' => 'O campo :attribute deve ser do tipo string',
            'date' => 'O campo :attribute deve ser do tipo date'          
        ];
    }
}