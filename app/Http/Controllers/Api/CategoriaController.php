<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categorias = Categoria::latest()->with('productos')->paginate(10);
        return $this->sendResponse($categorias,'lista de categoria');
    }


    public function all()
    {
        //
        $categorias = Categoria::all();
        return  $this->sendResponse($categorias,'lista de categoria');
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
        $this->validate($request,[
            "nome"=>"required|unique:categorias,nome",
            "descricao"=>"string"
        ]);
        DB::beginTransaction();
        try {
            //code...
            $categoria = Categoria::create($request->all());
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->sendError('erro ao gravar os dados',$th->getMessage());
        }
        DB::commit();
        return $this->sendResponse($categoria,'categoria gravado com sucesso');
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
        $categoria = Categoria::with('productos')->findOrFail($id);
        return  $this->sendResponse($categoria,' categoria');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $this->validate($request,[
            "nome"=>"required|string",
            "descricao"=>"string"
        ]);

        DB::beginTransaction();
        try {
           $categoria = Categoria::findOrFail($id);
           $categoria->update($request->all());

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->sendError('erro ao gravar os dados',$th->getMessage());
        }
        DB::commit();
       return $this->sendResponse($categoria,'categoria actualizado com sucesso');
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
             $record = Categoria::findOrFail($id);
             $record->delete();
         } catch (\Throwable $th) {
             DB::rollBack();
             return $this->sendError('Erro ao eliminar os dados', $th->getMessage());
         }

         DB::commit();
         return $this->sendResponse($record, 'Categoria eliminado com sucesso.');
    }
}
