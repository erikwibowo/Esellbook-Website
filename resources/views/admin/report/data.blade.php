<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
</head>
<body>
    <center>
        <h2>{{ $title }}</h2>
    </center>
    <table style="width: 100%; border-collapse: collapse" border="1" cellpadding="10">
        <thead>
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Text</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <img height="100px" src="{{ asset('storage/data/'.$i->foto) }}">
                    </td>
                    <td>{{ $i->text }}</td>
                    <td>{{ date('d-m-Y H:i', strtotime($i->created_at)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
<script>
    window.print();
</script>
</html>