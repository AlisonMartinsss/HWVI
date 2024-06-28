<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    protected $fillable = ['user_id', 'prioridade', 'assunto', 'descricao', 'data_abertura', 'data_fechamento'];

    public function rules()
    {
        return [
            'user_id' => 'exists:users,id',
            'prioridade' => 'required',
            'assunto' => 'required',
            'descricao' => 'required',
            'data_abertura' => 'required'
        ];
    }

    public function feedback()
    {
        return [
            'user_id.exists' => 'Esse usuário não existe',
            'prioridade.required' => 'A prioridade precisa ser preenchida',
            'assunto.required' => 'O assunto precisa ser preenchido',
            'descricao.required' => 'A descrição precisa ser preenchida',
            'data_abertura.required' => 'A data de abertura precisa ser preenchida'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
