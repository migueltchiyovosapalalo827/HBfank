<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class Logincontroller extends BaseController
{

    public function authenticate(Request $request)
    {
        # code...

        $rules =  [
            "email"=>"required|email",
            'password' => "required"
        ];


        $validator = Validator::make($request->only(['email','password']),$rules);
          if( $validator->fails())
          {
              return  response()->json(['sucess'=>false,
              'error'=> $validator->errors()],Response::HTTP_BAD_REQUEST);
          }

        if (Auth::attempt($request->only(['email','password']),$request->remember)) {
            $token  = '';

            $user = User::with('empregado','roles')->find(Auth::user()->id);
            if (empty($request->device_name)) {
                # code...

                $request->session()->regenerate();

                $token =  csrf_token();
            }else
            {
          $token = $user->createToken($request->device_name)->plainTextToken;
            }

            return response()->json(['sucess'=>true,'token'=>$token,'user'=> $user],Response::HTTP_OK);

        }
        return response()->json(['sucess'=>false,
                                     'error'=>['As credenciais fornecidas não correspondem aos nossos registros.']],Response::HTTP_EXPECTATION_FAILED);
    }
    public function logout(Request $request)
      {

        if (isset($request->web))
           {
              # code...
              $request->session()->invalidate();
              $request->session()->regenerateToken();
          }  else
          {
              # code...
                $request->user()->currentAccessToken()->delete();
          }

        return response()->json(['sucess'=>true],Response::HTTP_OK);


    }
}
