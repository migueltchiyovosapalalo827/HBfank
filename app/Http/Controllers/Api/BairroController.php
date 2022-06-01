<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bairro;
use App\Models\Cidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BairroController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private  function validateBairro($request){
        $rules =  [
            "nome"=>"required|unique:bairros,nome",
        ];

        return $this->validate($request,$rules);
    }

    public function index()
    {
        //
        $bairros = Bairro::with('cidade')->latest()->paginate(10);
        return  $this->sendResponse($bairros,'lista de bairros');
    }

    public function all()
    {
        # code...
        $bairros = Bairro::with('cidade')->get();
        return  $this->sendResponse($bairros,'lista de Permissões');
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
        $this->validateBairro($request);


         DB::beginTransaction();
         try {
            $cidade = Cidade::find($request->cidade);
            $cidade->bairros()->create(['nome' => $request->nome]);
         } catch (\Throwable $th) {
             //throw $th;
             DB::rollBack();
             return $this->sendError('erro ao gravar os dados',$th->getMessage());
         }

        DB::commit();
        return $this->sendResponse($cidade,'bairro gravado com sucesso');
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
        $bairro = Bairro::with('bairro')->findOrFail($id);
        return $this->sendResponse($bairro,'bairro');
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
            "nome"=>"required",
        ]);
         DB::beginTransaction();
         try {
            $bairro = Bairro::findOrFail($id);
            $bairro->update($request->all());

         } catch (\Throwable $th) {
             //throw $th;
             DB::rollBack();
             return $this->sendError('erro ao gravar os dados',$th->getMessage());
         }
         DB::commit();
        return $this->sendResponse($bairro,'bairro actualizado com sucesso');
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
             $record = Bairro::findOrFail($id);
             $record->delete();
         } catch (\Throwable $th) {
             DB::rollBack();
             return $this->sendError('Erro ao eliminar os dados', $th->getMessage());
         }

         DB::commit();
         return $this->sendResponse($record, 'Bairro eliminado com sucesso.');
    }
}
