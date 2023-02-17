<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Test Task</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" >
</style>
    </head>
    <body>
        <div>
            <pre>@dump($data)</pre>
            <table>
                <tr>
                    <th>Expense/Driver</th>
                    <th>Amount, $</th>
                    @foreach ($data['drivers'] as $driver)
                        <th>{{ $driver }}</th>
                    @endforeach
                </tr>
                @foreach ($data['expenses'] as $name => $price)
                <tr>
                    <td>{{ $name }}</td>
                    <td>{{ $price }}</td>
                    @foreach ($data['driverExpenses'] as $singleDriverExpenses)
                        <td>{{ number_format($singleDriverExpenses['expenses'][$name], 2) }}</td>
                    @endforeach
                </tr>
                @endforeach
                <tr class='totals'>
                    <td>Total:</td>
                    @foreach ($data['totals'] as $total)
                        <td>{{ $total }}</td>
                    @endforeach
                </tr>
            </table>
        </div>
    </body>
</html>
