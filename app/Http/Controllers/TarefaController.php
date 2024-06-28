<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;
use App\Repositories\TarefaRepository;

class TarefaController extends Controller
{
    public function __construct(Tarefa $tarefa) {
        $this->tarefa = $tarefa;
    }
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tarefaRepository = new TarefaRepository($this->tarefa);

        $tarefaRepository->selectAtributosRegistrosRelacionados(['user']);

        if($request->has('filtro')) {
            $tarefaRepository->filtro($request->filtro);
        }

        return response()->json($tarefaRepository->getResultado(), 200);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->tarefa->rules(), $this->tarefa->feedback());

        $tarefa = $this->tarefa->create([
            'user_id' => $request->user_id,
            'prioridade' => $request->prioridade,
            'assunto' => $request->assunto,
            'descricao' => $request->descricao,
            'data_abertura' => $request->data_abertura,
            'data_fechamento' => $request->data_fechamento
        ]);

        return response()->json($tarefa, 201);
    }

    /**
     * Display the specified resource.
     * 
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tarefa = $this->tarefa->find($id);
        if($tarefa === null) {
            return response()->json(['erro' => 'Tarefa não encontrada'], 404) ;
        } 

        return response()->json($tarefa, 200);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tarefa = $this->tarefa->find($id);

        if($tarefa === null) {
            return response()->json(['erro' => 'Erro! A tarefa selecionada não existe.'], 404);
        }

        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            foreach($tarefa->rules() as $input => $regra) {
                
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }

            }

            $request->validate($regrasDinamicas, $tarefa->feedback());
        } else {
            $request->validate($tarefa->rules(), $tarefa->feedback());
        }

        $tarefa->fill($request->all());
        $tarefa->save();

        return response()->json($tarefa, 200);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tarefa = $this->tarefa->find($id);

        if($tarefa === null) {
            return response()->json(['erro' => 'Erro! A tarefa selecionada não existe.'], 404);
        }       

        $tarefa->delete();
        return response()->json(['msg' => 'A tarefa foi removida com sucesso!'], 200);
    }
}