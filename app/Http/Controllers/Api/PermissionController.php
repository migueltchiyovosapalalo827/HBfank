<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private  function validatePermission():array
    {
        $rules =  [
            "name"=>"required|unique:permissions,name",
        ];

        return $rules;
    }

    public function index()
    {
        //
        $records = Permission::latest()->paginate(10);
        return  $this->sendResponse($records,'lista de Permissões');
    }

    public function all()
    {
        # code...
        $permissions = Permission::all();
        return  $this->sendResponse($permissions,'lista de Permissões');
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
         $rules = $this->validatePermission();
        $this->validate($request, [
            "name"=>"required|unique:permissions,name",
        ]);
         DB::beginTransaction();
         try {
            $permission = Permission::create(['name' => $request->name]);
         } catch (\Throwable $th) {
             //throw $th;
             DB::rollBack();
             return $this->sendError('erro ao gravar os dados',$th->getMessage());
         }

        DB::commit();
        return $this->sendResponse($permission,'Permissão gravado com sucesso');
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
        $permission = Permission::with('roles')->findOrFail($id);
        return $this->sendResponse($permission,'permisão');
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
            "name"=>"required|unique:permissions,name",
        ]);

         DB::beginTransaction();
         try {
            $permission = Permission::findOrFail($id);
            $permission->update($request->all());

         } catch (\Throwable $th) {
             //throw $th;
             DB::rollBack();
             return $this->sendError('erro ao gravar os dados',$th->getMessage());
         }
         DB::commit();
        return $this->sendResponse($permission,'Permissão actualizado com sucesso');
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
             $record = Permission::findOrFail($id);
             $record->delete();
         } catch (\Throwable $th) {
             DB::rollBack();
             return $this->sendError('Erro ao eliminar os dados', $th->getMessage());
         }

         DB::commit();
         return $this->sendResponse($record, 'Permissão eliminado com sucesso.');
    }
}
