<?php

namespace App\Http\Requests\Contato;

use Illuminate\Foundation\Http\FormRequest;

class ContatoUpdateRequest extends FormRequest
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
            'pessoa_id' => 'required|exists:App\Models\Pessoa,id', 
            'telefone' => 'required|min:3|max:20'                      
        ];
    }

    // Mensagens de resposta das validações da requisição
    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'min' => 'O campo :attribute deve ter no mínimo 3 caracteres',
            'max' => 'O campo :attribute deve ter no máximo 200 caracteres',
            'exists' => 'O campo :attribute não existe na sua respectiva tabela' 
        ];
    }
}