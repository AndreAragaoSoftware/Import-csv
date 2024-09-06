<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar CSV</title>
</head>
<body>

    <!-- Mensagem de sucesso -->
    @session('success')
        <p style="color: #086;">{!! $value !!}</p>
    @endsession

    <!-- Mensagem de erro -->
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color: #f00;">{{ $error }}</p>
        @endforeach
    @endif

    <form action="{{ route('user-import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" id="file" accept=".csv"><br><br>
        <button type="submit" id="fileBtn">Importar</button>
    </form>

    @foreach ($users as $user)
        {{ $user->id }}
    @endforeach
</body>
</html>
