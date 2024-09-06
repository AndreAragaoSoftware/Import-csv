<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        // Iniciando variável que recebe o número de registro
        $numberRegisteredRecords = 0;

        // Inicia lista de emails já cadastrados
        $emailAlreadyRegistered = false;

        // Criar um array com os valores dos dados
        $arrayValues[] = [];

        // Percorre as linhas do ficheiro
        foreach ($dataFile as $KeyData => $row) {

            // Converter a linha do array
            $values = explode(';', $row[0]);

            // Percorre as colunas do cabeçalho
            foreach($headers as $key => $header) {

                // Atribuir o valor ao elemento do array
                $arrayValues[$KeyData][$header] = $values[$key];

                // Verificar se a coluna é email:
                if ($header == 'email') {

                    // Verificar se o email já existe
                    if (User::where('email', $values[$key])->first()) {

                        // Atribuir o email na lista de emails já cadastrados
                        $emailAlreadyRegistered .= $values[$key] . ",";
                    }
                }

                // Verifica se a coluna password
                if($header == "password"){
                    // Criptografara a senha
                    $arrayValues[$KeyData][$header] = Hash::make($arrayValues[$KeyData]['password'], ['rounds' => 12]);
                }
                
            }
            // Adiciona o número de registro
            $numberRegisteredRecords++;
        }

        // Verificar se existe e-mail já cadastrado, retorna erro e não caastra na base de dados
        if ($emailAlreadyRegistered) {

            // Retorna erro e não caastra na base de dados
            return back()->with('error', 'Dados não importados. Existem emails já cadstrados: ,<br>'. $emailAlreadyRegistered);
        }

        // Cadastrar registros na base de dados
        User::insert($arrayValues);

        // Redirecionamento para página anterior com uma mensagem de sucesso
        return back()->with('success', 'Usuários importados com sucesso. <br>Quantidade: ' . $numberRegisteredRecords);
    }
}
