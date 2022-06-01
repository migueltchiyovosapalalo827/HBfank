<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductoController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
        $produtos =  Producto::with('productoimagens','categoria')->latest()->paginate(10) ;

        return  $this->sendResponse($produtos,'lista de produtos');
    }
    public function all(Request $request)
    {
        //get('search')
        $search = $request->get('search');

        $produtos = (isset($search)) ? Producto::with('productoimagens','categoria')->where('nome', 'LIKE', "%$search")->orderBy('id','desc')->get() : Producto::with('productoimagens','categoria')->latest()->get() ;

        return  $this->sendResponse($produtos,'lista de produtos');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
        "nome"=>"required|unique:productos,nome",
        "descricao" => "required|max:255",
        "preco" => "required",
        //"imagens" => "required|mimes:jpeg,jpg,bmp,png,gif,svg",
       "categoria" =>  "required"
    ]);

         DB::beginTransaction();
         try {
             $categoria = Categoria::findOrFail($request->categoria);
            $producto =  $categoria->productos()->create($request->except('categoria','imagens'));
            if($request->hasFile('imagens')){
                $imagens = $request->file('imagens');

                foreach($imagens as $imagen){
                    $nome = $request->nome.$imagen->getClientOriginalName();
                    $url ='/storage/'. $imagen->storeAS('imagens',$nome,'public');
                   $producto->productoimagens()->create(['nome'=>$nome,'url'=>$url]);

                }

                 }
            //
         } catch (\Throwable $th) {
             //throw $th;
             DB::rollBack();
             return $this->sendError('erro ao gravar os dados',$th->getMessage());
         }

        DB::commit();
        return $this->sendResponse($producto,'producto gravado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $producto = producto::with('productoimagens')->findOrFail($id);
        return $this->sendResponse($producto,'producto');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            "nome"=>"required|string",
            "descricao" => "required|max:255",
            "preco" => "required",
           //"imagens" => "image|mimes:jpeg,jpg,bmp,png,gif,svg",
           "categoria" =>  "required"
        ]);

         DB::beginTransaction();
         try {
            $producto = producto::findOrFail($id);
            $producto->update([
                "nome"=> $request->nome,
                "descricao" => $request->descricao,
                "preco" => $request->preco,
               "categoria_id" =>  $request->categoria
            ]);

            if($request->hasFile('imagens')){
                foreach($producto->productoimagens as $imagen){
                    Storage::delete($imagen->url);
                    $imagen->delete();
                }
                   $imagens = $request->file('imagens');

                   foreach($imagens as $imagen){
                       $nome = $request->nome.$imagen->getClientOriginalName();
                       $url ='/storage/'. $imagen->storeAS('imagens',$nome,'public');
                       $producto->productoimagens()->create(['nome'=>$nome,'url'=>$url]);

                   }

                 }

         } catch (\Throwable $th) {
             //throw $th;
             DB::rollBack();
             return $this->sendError('erro ao gravar os dados',$th->getMessage());
         }
         DB::commit();
        return $this->sendResponse($producto,'producto actualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        DB::beginTransaction();
        try {
             //code...
             $record = Producto::findOrFail($id);
             $record->delete();
         } catch (\Throwable $th) {
             DB::rollBack();
             return $this->sendError('Erro ao eliminar os dados', $th->getMessage());
         }

         DB::commit();
         return $this->sendResponse($record, 'producto eliminado com sucesso.');
    }
}
