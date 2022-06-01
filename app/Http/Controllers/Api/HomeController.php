<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends BaseController
{
    //

    public function index() {
        $data = [];
        $thisMonth = Carbon::now()->format('Y-m');
        $lastMonth = Carbon::now()->subMonth(1)->format('Y-m');

        $data['pedidos_recentes'] = Pedido::where('created_at','LIKE', '%'.$thisMonth.'%')->count();
        $data['pedidos_antigos'] = Pedido::where('created_at','LIKE', '%'.$lastMonth.'%')->count();
        $diff = $data['pedidos_recentes'] -$data['pedidos_antigos'];
        $more_less = $diff > 0 ? "+" : "-";
        $diff = abs($diff);
        $data['percentagem_de_vendas'] = $more_less.(($diff/($data['pedidos_antigos']!==0?:1))*100)."%";
        $data['productos'] = Producto::count();

        $data['productos_vendidos'] = Pedido::join('pedido_producto','pedido_producto.pedido_id',"=","pedidos.id")->
        selectRaw('SUM(pedido_producto.quantidade) as quantidade')->first()->quantidade;

        $data['clientes_satisfeito'] = Cliente::join('pedidos','pedidos.cliente_id',"=","clientes.id")->
        count();
        $data['clientes'] = Cliente::count();
        $data['pedidos'] = Pedido::with('productos','cliente','pagamento')->where('estado','<>','entregue')->latest()->get();
        return response()->json($data);
    }
    public function report() {
        $data = [];
        $data['total']['pedidos'] = Pedido::count();
        $data['total']['pedidos_recentes'] = Pedido::whereMonth('created_at', Carbon::now()->format('m'))->count();
        $data['total']['categoria'] = Categoria::count();
        $data['total']['productos'] = Producto::count();
        $data['total']['product_sold'] =  Pedido::join('pedido_producto','pedido_producto.pedido_id',"=","pedidos.id")->count();
        $data['total']['product_sold_thismo'] =  Pedido::join('pedido_producto','pedido_producto.pedido_id',"=","pedidos.id")->whereMonth('pedidos.created_at', Carbon::now()->format('m'))->count();
        $data['total']['clientes'] = Cliente::count();

        $data['vendas']['grafico'] = DB::table('pedidos')->select(DB::raw("COUNT(*) as a, DATE(created_at) as y"))->where('created_at', '>=', Carbon::now()->subDays(7)->format('Y-m-d'))->groupBy(DB::raw('DATE(created_at)'))->get();

        return response()->json($data);
    }

    public function pdf_transaction(Request $r) {
        $transactions = Pedido::all();
         Pdf::loadview('pdf.transaction', ['transactions' => $transactions])->save('pdf/transaction.pdf');
        return response()->json(['status' => true, 'filename' => 'transaction.pdf']);
    }

    public function pdf_users(Request $r) {
        $users = User::all();
        $pdf = Pdf::loadview('pdf.users', ['users' => $users])->save('pdf/users.pdf');
        return response()->json(['status' => true, 'filename' => 'users.pdf']);
    }

    public function pdf_products(Request $r) {
        $products = Producto::all();
        $pdf = Pdf::loadview('pdf.products', ['products' => $products])->setPaper('a4', 'landscape')->save('pdf/products.pdf');
        return response()->json(['status' => true, 'filename' => 'products.pdf']);
    }
}
