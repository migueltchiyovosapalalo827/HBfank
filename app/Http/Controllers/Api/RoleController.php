<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RoleController extends BaseController
{
    //========================   validate  function
    private  function validateRole($request){
        $rules =  [
            "name"=>"required|unique:roles,name",
            "permissions_list" => "required|array",

        ];

        return $this->validate($request,$rules);
    }



    public function index()
    {
        $records = Role::with('permissions')->latest()->paginate(10);
        return  $this->sendResponse($records,'lista de funções');
    }

    public function all()
    {
        # code...
        $permissions = Role::all();
        return  $this->sendResponse($permissions,'lista de Permissões');
    }
    public function show($id)
    {
        //
        $funcao = Role::with('permissions')->findOrFail($id);
        return $this->sendResponse($funcao,'funcao');
    }

    public function store(Request $request)
    {

        $this->validateRole($request);
        DB::beginTransaction();
        try {
            //code...
            $role = Role::create(['name'=>$request->name,'guard_name'=>"web"]);
            $role->permissions()->sync($request->permissions_list);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->sendError('erro ao gravar os dados',$th->getMessage());
        }
      DB::commit();
      return $this->sendResponse($role,'funcão gravado com sucesso');
    }







    public function update(Request $request, $id)
    {
        $this->validate($request, ["name"=>"required","permissions_list" => "required|array", ]);

        DB::beginTransaction();
        try {
            //code...
            $record = Role::findOrFail($id);
            $record->update($request->except(['permissions_list']));
            $record->permissions()->sync($request->permissions_list);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->sendError('Erro ao grava os dados',$th->getMessage());
        }
        DB::commit();

        return  $this->sendResponse($record,'a função foi actualizada com sucesso');
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
             //code...
             $record = Role::findOrFail($id);
             $record->delete();
         } catch (\Throwable $th) {
             DB::rollBack();
             return $this->sendError('Erro ao eliminar os dados', $th->getMessage());
         }

         DB::commit();
         return $this->sendResponse($record, 'funcão eliminado com sucesso.');
    }

}
