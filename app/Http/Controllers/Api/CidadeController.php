<?php

namespace App\Http\Controllers\Api;

use App\Models\Cidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CidadeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private  function validateCidade($request){
        $rules =  [
            "nome"=>"required|unique:cidades,nome",
        ];

        return $this->validate($request,$rules);
    }

    public function index()
    {
        //
        $cidades = Cidade::latest()->paginate(10);
        return  $this->sendResponse($cidades,'lista de cidades');
    }

     public function all()
     {
        $cidades = Cidade::all();
        return  $this->sendResponse($cidades,'lista de cidades');
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
          $this->validateCidade($request);

         DB::beginTransaction();
         try {
            $cidade = Cidade::create(['nome' => $request->nome]);
         } catch (\Throwable $th) {
             //throw $th;
             DB::rollBack();
             return $this->sendError('erro ao gravar os dados',$th->getMessage());
         }

        DB::commit();
        return $this->sendResponse($cidade,'cidade gravado com sucesso');
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
        $cidade = Cidade::with('bairros')->findOrFail($id);
        return $this->sendResponse($cidade,'cidade');
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
       $this->validateCidade($request);

         DB::beginTransaction();
         try {
            $cidade = Cidade::findOrFail($id);
            $cidade->update($request->all());

         } catch (\Throwable $th) {
             //throw $th;
             DB::rollBack();
             return $this->sendError('erro ao gravar os dados',$th->getMessage());
         }
         DB::commit();
        return $this->sendResponse($cidade,'cidade actualizado com sucesso');
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
             $record = Cidade::findOrFail($id);
             $record->delete();
         } catch (\Throwable $th) {
             DB::rollBack();
             return $this->sendError('Erro ao eliminar os dados', $th->getMessage());
         }

         DB::commit();
         return $this->sendResponse($record, 'Cidade eliminado com sucesso.');
    }
}
