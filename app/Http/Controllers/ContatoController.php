<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Models
use App\Models\Contato;
// Form Requests
use App\Http\Requests\Contato\ContatoStoreRequest;
use App\Http\Requests\Contato\ContatoUpdateRequest;

class ContatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contatos = Contato::all();
        return response()->json($contatos, 200);
    }   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContatoStoreRequest $request)
    {
        $dataForm = $request->only('pessoa_id','telefone');
        $contato = Contato::create($dataForm);

        if ($contato) {
            return response()->json($contato, 200);
        }
        
        return response()->json(['erro' => 'O contato não foi cadastrado'], 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contato = Contato::find($id);

        if($contato === null) {
            return response()->json(['erro' => 'Esse contato pesquisado não existe'], 404);
        }
 
        return response()->json($contato, 200);
    }
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContatoUpdateRequest $request, $id)
    {
        $contato = Contato::find($id);

        if ($contato) {
            $dataForm = $request->only('pessoa_id','telefone');
            
            if ($contato->update($dataForm))
                return response()->json($contato, 200);               

            return response()->json(['erro' => 'O contato não foi atualizado'], 404);
        }

        return response()->json(['erro' => 'O contato não existe'], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contato = Contato::find($id);

        if($contato) {
            $contato->delete();
            return response()->json(['Mensagem:' => 'O produto foi excluído com sucesso!'], 200);
        }

        return response()->json(['erro' => 'Impossível realizar a exclusão. O contato não existe'], 404);
    }
}
