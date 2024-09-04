<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Listar os usuários
    public function index()
    {
        // Recuperar os registros do banco de dados
        $users = User::get();

        // dd($users);

        // Carregar a VIEW
        return view('users.index', ['users' => $users]);
    }
}
