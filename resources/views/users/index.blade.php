<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    <title>Importar CSV</title>
</head>
<body>
    <div class="container">
        <div class="card my-5 border-light shadow">
            <h3 class="card-header">Laravel 11 - Import CSV</h3>
            <div class="card-body">
                <!-- Mensagem de sucesso -->
                @session('success')
                    <div class="alert alert-success" role="alert">{!! $value !!}</div>
                @endsession

                <!-- Mensagem de error -->
                @session('error')
                    <div class="alert alert-danger" role="alert">{!! $value !!}</div>
                @endsession

                <!-- Mensagem de erro -->
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('user-import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="input-group my-3">
                        <input class="form-control" type="file" name="file" id="file" accept=".csv">
                        <button type="submit" class="btn btn-outline-success" id="fileBtn"><i class="fa-solid fa-upload"></i> Importar</button>
                    </div>
                </form>

                <table class="table table-striped table-hover mt-3">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>E-mail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
       </div>
    </div>
</body>
</html>
