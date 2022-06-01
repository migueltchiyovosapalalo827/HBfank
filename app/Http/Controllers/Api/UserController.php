<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends BaseController
{

    //========================   validate  function
     private  function validateUSer($request){
        $rules =[
            "name"=>"required|string|min:6|max:60",
            "email" => "required|unique:users,email",
            "password"=>"required|confirmed",
            'endereco'=>"required|max:255",
            'telefone'=>"required|min:9|max:12",
            'data_de_nascimento'=>"required|date",
            "roles_list" => "required"
        ];

       return Validator::make($request,$rules);
    }

    public function index()
    {
        $users = User::whereNotIn('id',function($query){
            $query->select('user_id')->from('clientes')->get();
        })->with('empregado','roles')->latest()->paginate(10);
        return $this->sendResponse($users,'lista de funcionarios');

    }

    public function store(Request $request)
    {
       // $validator = $this->validateUSer($request);
       /* if($validator->fails()){
            return $this->sendError('Erro de validação', $validator->errors());
        }*/
        $this->validate($request , [
            "name"=>"required|string|min:6|max:60",
            "email" => "required|unique:users,email",
            "password"=>"required|confirmed",
            'endereco'=>"required|max:255",
            'telefone'=>"required|min:9|max:14",
            'data_de_nascimento'=>"required|date",
            "roles_list" => "required"
        ]);
         DB::beginTransaction();

        try {
            //code...
        $request->merge(["password" => Hash::make($request->password),'email_verified_at' => now() ,'nome'=>$request->name]); // hash password
        $user = User::create($request->only('name','email','password','email_verified_at'));
        $user->empregado()->create($request->except('roles_list','email_verified_at','email','name','password'));
        $user->assignRole($request->roles_list);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->sendError('Erro ao gravar os dados', $th->getMessage());
        }
        DB::commit();
        return $this->sendResponse($user, 'Usuario cadastrado com sucesso.');
    }


    public function show($id)
    {
        $user = User::with('empregado','roles')->findOrFail($id);
        return $this->sendResponse($user,'usuario');
    }

    public function update(Request $request, $id)
    {

        $this->validate($request,[
            "name"=>"required|string|min:6|max:60",
            "email" => "required|email",
            "password"=>"confirmed",
            'endereco'=>"required|max:255",
            'telefone'=>"required|min:9|max:14",
            'data_de_nascimento'=>"required|date",
            "roles_list" => "required"
        ]);

        DB::beginTransaction();

        try {
            //code...
           if (!empty($request->password)) {
               # code...
               $request->merge(["password" => Hash::make($request->password)]);
           }

        $request->merge(['nome'=>$request->name]); // hash password
        $user = User::findOrFail($id);
        $user->syncRoles($request->roles_list);
        $user->update($request->except('roles_list','endereco','telefone','data_de_nascimento','nome',($request->password ? "":'password')));
        $user->empregado()->updateOrCreate($request->except('roles_list','password_confirmation','email','name','password'));

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->sendError('não foi possivel eliminar este usuario', $th->getM);
        }
        DB::commit();
        return $this->sendResponse($user, 'Usuario actualizado com sucesso.');


    }


    public function destroy($id)
    {
          DB::beginTransaction();
        try {
             //code...
             $record = User::findOrFail($id);
             $record->delete();
         } catch (\Throwable $th) {
             DB::rollBack();
             return $this->sendError('Erro ao eliminar os dados', $th->getMessage());
         }

         DB::commit();
         return $this->sendResponse($record, 'Usuario eliminado com sucesso.');

    }


}
