<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(User $user) {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userRepository = new UserRepository($this->user);

        if($request->has('filtro')) {
            $userRepository->filtro($request->filtro);
        }

        return response()->json($userRepository->getResultado(), 200);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->user->rules(), $this->user->feedback());

        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'admin' => $request->admin,
            'password' => Hash::make($request->password)
        ]);

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     * 
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->user->find($id);
        if($user === null) {
            return response()->json(['erro' => 'Usuário não encontrada'], 404) ;
        } 

        return response()->json($user, 200);
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
        $user = $this->user->find($id);

        if($user === null) {
            return response()->json(['erro' => 'Erro! O usuário selecionado não existe.'], 404);
        }

        if($request->method() === 'PATCH') {
            $regrasDinamicas = array();

            foreach($user->rules($id) as $input => $regra) {
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas, $user->feedback());
        } else {
            $request->validate($user->rules($id), $user->feedback());
        }

        $user->fill($request->all());
        $user->save();

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->user->find($id);

        if($user === null) {
            return response()->json(['erro' => 'Erro! O usuário selecionado não existe.'], 404);
        }       

        $user->delete();
        return response()->json(['msg' => 'O usuário foi removido com sucesso!'], 200);
    }
}