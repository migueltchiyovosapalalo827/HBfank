<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends BaseController
{
    //

    // =================================== pedidos

           public function pedidoNovo(Request $request)
           {

           DB::beginTransaction();
           try {
               // crriar pedido inicail
            $user  = User::find($request->cliente['id']);
            $pedido = $user->cliente->pedidos()->create([
                'forma_de_pagamento' => $request->formaPagamento,
                'endereco'=>$user->cliente->bairro->nome
            ]);

            $custo = 0;

            // obter  custo de entrega
            foreach ($request->items as $i){

                $producto = Producto::find($i['id']);
                $ready_product = [
                  $i['id']=>[
                      'quantidade' => $i['quantity'],
                      'preco' => $producto->preco,
                  ]
                ];

                 $pedido->productos()->attach($ready_product);
                $custo+=($producto->preco * $i['quantity']);
            }
               // verifique o custo mínimo do pedido
            if($custo >= 1000){

                     //calc total custo
                $total = $request->total;
                     // calc iva for app
                $iva = 14/100 * $custo;

                /// update pedido  *
                $update = $pedido->update([
                    'taxa_de_entrega' =>0,
                    'iva' =>$iva,
                    'total' =>$total,
                    'referencia_de_pagamento' =>$request->referenciaPagamento
                ]);


            }
            else{

                DB::rollBack();
                return $this->sendError('o valor pedido deve ser maior  que 1000 kz');
            }

           } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError('não foi possivel realiar esta venda porque ocorreu um erro de sistema', $th->getMessage());
            }
            DB::commit();
             sendNotification($pedido->id,'O seu pedido foi efectuado com sucesso!','success');
            return $this->sendResponse($pedido,'O seu pedido foi efectuado com sucesso!');

        }
               /*  pedido actual  */
        public  function pedidoActual(){
            $pedidos = pedido::where('cliente_id',auth()->user()->cliente->id)->where('estado','aceito')->get();
            if(count($pedidos)){
                return $this->sendResponse($pedidos,'sucesso');
            }
            return $this->sendError('não existe nenhum pedido');
        }
            /*  pedido Antigo  */
        public  function pedidoAntigo(){
            $pedidos = pedido::where('cliente_id',auth('clientes')->cliente->id)->whereNotIn('estado',['pendente', 'aceito'])->get();

            if(count($pedidos)){
                return $this->sendResponse([$pedidos],'sucesso');

            }
            return $this->sendError('não existe nenhum pedido');
        }

        /*   pedido Recebido */

        public function pedidoRecebido(Request $request){
            pedido::where('cliente_id',auth('clientes')->user()->cliente->id)->where('id',$request->pedido_id)->update([
                'estado' => 'entregue'
            ]);
            $pedido_id = $request->pedido_id;

            /* notifications  */
            return notify(auth()->user()->id,$request->user()->cliente->nome.' recebeu pedido ',
                $pedido_id,"pedido entregue",'resturant');
            /* end notifications  */
        }

        /* rejeitar pedido  */
        public function rejeitarPedido(Request $request){
            pedido::where('cliente_id',$request->cliente)->where('id',$request->pedido_id)->update([
                'estado' => 'rejeitado'
            ]);
            $pedido_id = $request->pedido_id;

            /* notifications  */
            return notify(auth()->user()->id,$request->user()->cliente->nome.' rejeitou pedido ',
                $pedido_id," pedido rjeitado",'resturant');
            /* end notifications  */
        }

         /* pedidos pendente*/
        public  function pedidoPendente(){
            $pedidos = Pedido::where('estado','pendente')->get();
            if(count($pedidos)){
                return $this->sendResponse($pedidos,'sucesso');
            }
            return $this->sendError('não existe nenhum pedido');
        }
        /* pedidos recentes  */
        public  function pedidoRecentes(){
            $pedidos = Pedido::whereIn('estado',['aceite'])->get();
            if(count($pedidos)){
                return $this->sendResponse($pedidos,'sucesso');
            }
            return $this->sendError('não existe nenhum pedido');
        }


        /* aceitar  pedido  */
        public function pedidoAceite(Request $request){
            pedido::where('id',$request->pedido_id)->update([
                'estado' => 'aceito'
            ]);
            $pedido_id = $request->pedido_id;
            $client_id = Pedido::where('id',$request->pedido_id)->pluck('cliente_id')->toArray();
            $cliente = Cliente::find($client_id[0]);
            /* notifications  */
            return notify($cliente,$request->user()->name.' acieto o teu pedido ',
                $pedido_id,"accepted pedido",'cliente');
            /* end notifications  */
        }
        /*  pedido Entregue  */
        public function pedidoEntregue(Request $request){
            pedido::where('id',$request->pedido_id)->update([
                'estado' => 'entregue'
            ]);
            $pedido_id = $request->pedido_id;
            $client_id = pedido::where('id',$request->pedido_id)->pluck('cliente_id')->toArray();
            $cliente = Cliente::find($client_id[0]);
            /* notifications  */
            return notify($cliente,$request->user()->name.'  Entregou o teu pedido ',
                $pedido_id," pedido entregue",'client');
            /* end notifications  */
        }
    // posto de venda
    public function pos(Request $request)
     {
                   # code...



                 /*  $validate = validator()->make($request->all(),[
                    "productos.*.producto_id" => "required|exists:productos,id",
                    "productos.*.quantidade" => "required",
                    "forma_de_pagamento" => "required|in:cash,transferencia,deposito"
                ]);
                if($validate->fails()){
                    return $this->sendError("erro de validação",$validate->errors());
                }*/

                // crriar pedido inicail
                DB::beginTransaction();
                try {
                    //code...

                $cliente = Cliente::find($request->cliente);
                $pedido = $cliente->pedidos()->create([
                    'forma_de_pagamento' => $request->forma_de_pagamento,
                ]);

                $custo = 0;

                // obter  custo de entrega
                $taxa_de_entrega =  (isset($request->taxa_de_entrega)) ? $request->taxa_de_entrega : 0 ;
                foreach ($request->productos as $i){

                    $producto = Producto::find($i['producto_id']);
                    $ready_product = [
                      $i['producto_id']=>[
                          'quantidade' => $i['quantity'],
                          'preco' => $producto->preco,
                      ]
                    ];

                     $pedido->productos()->attach($ready_product);
                    $custo+=($producto->preco * $i['quantity']);
                }
                   // verifique o custo mínimo do pedido para restaurante
                if($custo >= 100){

                         //calc total custo
                    $total = $custo + $taxa_de_entrega;
                         // calc iva for app
                    $iva = 14/100 * $custo;

                    /* update pedido  */
                    $update = $pedido->update([
                        'taxa_de_entrega' =>$taxa_de_entrega,
                        'iva' =>$iva,
                        'total' =>$total,
                        'estado' => 'entregue'
                    ]);

                    $pedido->pagamento()->create([
                        'estado'=>'confirmado',
                        'valor' =>$total+$iva
                    ]);
                }
                else{
                     DB::rollBack();
                    return $this->sendError('o valor pedido deve ser maior  que 100 kz');
                }

            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
            return $this->sendError('não foi possivel realiar esta venda porque ocorreu um erro de sistema', $th->getMessage());
            }
            DB::commit();
            return $this->sendResponse($pedido,'venda realizada com sucesso');
     }

     public function factura($pedido_id)
     {
         # code...
         $pedido = Pedido::with('productos','cliente','pagamento')->where('id',$pedido_id)->orderBy('id','desc')->first();
         return $this->sendResponse($pedido,'factura');
     }


     public function show($pedido_id)
     {
         # code...
         $pedido = Pedido::with('productos','cliente','pagamento')->where('id',$pedido_id)->orderBy('id','desc')->first();
         return $this->sendResponse($pedido,'pedido');
     }

     public function history(Request $request) {
        $search = $request->get('search');
        $pedidos   = (isset($search)) ? Pedido::with('productos','cliente','pagamento')->where('estado','!=','pendente')
        ->where('id','LIKE',"%$search%")->orderBy('id','desc')->paginate(10) :  Pedido::with('productos','cliente','pagamento')->where('estado','!=','pendente')->latest()->paginate(10);
         return $this->sendResponse($pedidos,'hestorico de venda');
    }

}
