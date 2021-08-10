<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de venta de libros</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-3">Reporte de venta de libros</h2>
        <h3 class="text-center mb-3">{{ $author->name }}</h3>

        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-info">
                    <th scope="col">#</th>
                    <th scope="col">Libro</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Pagado</th>
                    <th scope="col">Comprador</th>
                    <th scope="col">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $price = 0;
                    $cost = 0;
                    $count = 0;
                @endphp
                @foreach ($data['books'] ?? [] as $key => $item)
                    <tr>
                        <th scope="row">{{ $item->id ?? null }}</th>
                        <td>{{ $item->book->title ?? null }}</td>
                        <td>${{ $item->book->price ?? null }}</td>
                        <td>${{ $item->cost ?? null }}</td>
                        <td>{{ $item->user->name ?? null }}</td>
                        <td>{{ explode(' ', $item->created_at ?? '')[0] ?? null }}</td </tr>
                        @php
                            $price = $price + $item->book->price;
                            $cost = $cost + $item->cost;
                            $count++;
                        @endphp
                @endforeach
                <tr class="table-warning">
                    <td scope="col"></td>
                    <td scope="col">{{ $count }} Ventas</td>
                    <td scope="col">${{ $price }}</td>
                    <td scope="col">${{ $cost }}</td>
                    <td scope="col"></td>
                    <td scope="col"></td>
                </tr>
            </tbody>
        </table>

    </div>

</body>

</html>
