<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function rules($id = null)
    {
        return [
            'name' => 'required',
            'admin' => ['required', 'boolean'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($id),],
            'password' => ['required']
        ];
    }

    public function feedback()
    {
        return [
            'name.required' => 'O nome precisa ser preenchido',
            'email.required' => 'O e-mail precisa ser preenchido',
            'email.email' => 'O e-mail precisa ser um e-mail válido',
            'email.unique' => 'O e-mail já foi preenchido por outro usuário',
            'admin.required' => 'O campo função precisa ser preenchido',
            'admin.boolean' => 'O campo função precisa ser verdadeiro ou falso',
            'password.required' => 'A senha precisa ser preenchida'
        ];
    }
}
