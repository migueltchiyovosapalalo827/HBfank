<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo nº {{$pedido->id}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 200px;
        }
        .receipt-details {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            font-weight: bold;
            text-align: right;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Humburgaria Fank</h1>
            <h2>Recibo de Pedido</h2>
        </div>

        <div class="receipt-details">
            <p><strong>Pedido:</strong> #{{$pedido->id}}</p>
            <p><strong>Data:</strong>{{$pedido->created_at}}</p>
            <p><strong>Cliente:</strong>{{$pedido->cliente->nome}}</p>
            <p><strong>Email:</strong>{{$pedido->cliente->email}}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedido->productos as $item)
                <tr>
                    <td>{{$item->nome}}</td>
                    <td>{{$item->pivot->quantidade}}</td>
                    <td>{{$item->pivot->preco}}</td>
                    <td>{{$item->pivot->quantidade * $item->pivot->preco}}</td>
                </tr>
                @endforeach



                <tr>
                    <td colspan="3" class="total">iva (14%)</td>
                    <td>{{$pedido->iva}}</td>
                </tr>
                <tr>
                    <td colspan="3" class="total">Total</td>
                    <td>{{$pedido->total}}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Obrigado pelo seu pedido!</p>
            <p>Se você tiver alguma dúvida, entre em contato conosco pelo e-mail support@example.com</p>
        </div>
    </div>
</body>
</html>

