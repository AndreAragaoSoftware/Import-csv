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

    public function import(Request $request)
    {
        // Validar o arquivo
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ],[
            'file.required' => 'Por favor, escolha um arquivo CSV.',
            'file.mimes' => 'O arquivo precisa ser um CSV.',
            'file.max' => 'O arquivo pode ter no máximo :max Mb.',
        ]);

        // Criar o array conforme as colunas da base de dados
        $headers = ['name', 'email', 'password'];

        // Ler os dados e converter em array
        $dataFile = array_map('str_getcsv', file($request->file('file')));

        // Percorre as linhas do ficheiro
        foreach ($dataFile as $KeyData => $row) {

            // Converter a linha do array
            $values = explode(';', $row[0]);

            // Percorre as colunas do cabeçalho
            foreach($headers as $key => $header) {
                // Atribuir o valor ao elemento do array
                $arrayValues[$KeyData][$header] = $values[$key];
            }
        }
        dd($arrayValues);
    }
}
