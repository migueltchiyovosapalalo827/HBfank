<?php

namespace App\Http\Controllers\Api;


use App\Models\Bairro;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class ClienteController extends BaseController
{


    public function index()
    {

        $clientes = Cliente::with('bairro', 'user')->paginate(10);
        return $this->sendResponse($clientes, 'lista de clientes');
    }
    public function all()
    {
        # code...
        $clientes = Cliente::with('bairro', 'user')->get();
        return $this->sendResponse($clientes, 'lista de clientes');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required|string|min:6|max:60",
            "email" => "required|unique:users,email",
            "password" => "required|confirmed",
            'bairro' => "required"
        ]);

        DB::beginTransaction();

        try {
            //code...
            $bairro = Bairro::findOrFail($request->bairro);
            $request->merge(["password" => Hash::make($request->password)]); // hash password
            $user = User::create(['email' => $request->email, 'password' => $request->password, 'name' => $request->name]);
            $request->merge(['user_id' => $user->id, 'nome' => $request->name]);
            $cliente  = $bairro->clientes()->create($request->except('bairro', 'password_confirmation', 'email', 'name', 'password'));
            $funcao = Role::where('name', 'cliente')->first();
            $user->assignRole([$funcao->id]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->sendError('Erro ao gravar os dados', $th->getMessage());
        }
        DB::commit();
        return $this->sendResponse($cliente, 'Cliente cadastrado com sucesso.');
    }


    public function show($id)
    {
        $cliente = Cliente::with('bairro', 'pedidos')->findOrFail($id);
        return $this->sendResponse($cliente, 'cliente');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "name" => "required|string|min:6|max:60",
            "email" => "required",
            "password" => "confirmed",
            'bairro' => "required"
        ]);

        DB::beginTransaction();

        try {
            //code...
            if (!empty($request->password)) {
                # code...
                $request->merge(["password" => Hash::make($request->password)]);
            } // hash password
            $cliente = Cliente::findOrFail($id);
            if (isset($request->password)) {
                # code...
                $cliente->user()->update(['name' => $request->name, 'email' => $request->email, "password" => $request->password]);
            } else {
                # code...
                $cliente->user()->update(['name' => $request->name, 'email' => $request->email]);
            }


            $request->merge(['nome' => $request->name, 'bairro_id' => $request->bairro, 'user_id' => $cliente->user_id]);
            $cliente->updateOrCreate($request->except('bairro', 'password_confirmation', 'email', 'name', 'password'));
            $funcao = Role::where('name', 'cliente')->first();
            ($cliente->user->hasRole('cliente')) ?   $cliente->user->syncRoles([$funcao->id]) :  $cliente->user->assignRole([$funcao->id]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->sendError('não foi possivel actualizar este cliente', $th->getMessage());
        }
        DB::commit();
        return $this->sendResponse($cliente, 'Cliente actualizado com sucesso.');
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            //code...
            $record = Cliente::findOrFail($id);
            //se o cliente  tiver um pedido nao podemos deletar o cliente e lançar uma exceção
            if (count($record->pedidos) > 0) {

                throw new \Exception("Não é possivel eliminar o cliente, pois o cliente tem pedidos associados.");
            }

            $record->delete();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError('Erro ao eliminar os dados', $th->getMessage(),403);
        }

        DB::commit();
        return $this->sendResponse($record, 'Cliente eliminado com sucesso.');
    }
}
