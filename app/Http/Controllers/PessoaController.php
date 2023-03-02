<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Models
use App\Models\Pessoa;
// Form Requests
use App\Http\Requests\Pessoa\PessoaStoreRequest;
use App\Http\Requests\Pessoa\PessoaUpdateRequest;
// Helper
use App\Helpers\PessoaHelper;

class PessoaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pessoas = Pessoa::all();
        return response()->json($pessoas, 200);
    }
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PessoaStoreRequest $request)
    {
        // Validação do CPF (Chamando o helper)
        $validacaoCpf = PessoaHelper::validarCpf(trim($request->cpf));

        if (!$validacaoCpf)
            return response()->json(['erro' => 'O número do CPF é inválido'], 404);

        $dataForm = $request->only('nome','email','data_nasc','nacionalidade');
        $dataForm['cpf'] = PessoaHelper::extrairSomenteNumerosCpf($request->cpf);      
        
        // Mass Assignment
        $pessoa = Pessoa::create($dataForm);

        return response()->json($pessoa, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pessoa = Pessoa::find($id);

        if($pessoa === null) {
            return response()->json(['erro' => 'Essa pessoa pesquisada não existe'], 404);
        }
 
        return response()->json($pessoa, 200);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PessoaUpdateRequest $request, $id)
    {
        // Validação do CPF (Chamando o helper)
        $validacaoCpf = PessoaHelper::validarCpf(trim($request->cpf));

        if (!$validacaoCpf)
            return response()->json(['erro' => 'O número do CPF é inválido'], 404);

        $pessoa = Pessoa::find($id);

        if($pessoa) {

            $dataForm = $request->only('nome','email','data_nasc','nacionalidade');
            $dataForm['cpf'] = PessoaHelper::extrairSomenteNumerosCpf($request->cpf);
            
            // Mass Assignment
            $pessoa = $pessoa->update($dataForm);

            return response()->json(['updated' => $pessoa], 200);
        }

        return response()->json(['erro' => 'A pessoa não existe'], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pessoa = Pessoa::find($id);

        if($pessoa) {
            $pessoa->delete();
            return response()->json(['Mensagem:' => 'A pessoa foi excluída com sucesso!'], 200);
        }

        return response()->json(['erro' => 'Impossível realizar a exclusão. A pessoa não existe'], 404);
    }
}
