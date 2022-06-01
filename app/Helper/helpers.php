<?php


// return settings  model

use App\Models\Pedido;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Support\Facades\Notification;

// static response

function responseJson($status , $msg , $data=null){

    $Response = [

        "status" =>$status ,
        "message" =>$msg,
        "data"   =>$data
    ];

    return response()->json($Response);
    }

    //  function to push notification by firebase

    function notifyByFirebase($title,$body,$tokens,$data = [] , $is_notification = true)        // paramete 5 =>>>> $type
    {
    $registrationIDs = $tokens;
    $fcmMsg = array(
        'body' => $body,
        'title' => $title,
        'sound' => "default",
        'color' => "#203E78"
    );
    $fcmFields = array(
        'registration_ids' => $registrationIDs,
        'priority' => 'high',
        'data' => $data
    );
    if($is_notification){
        $fcmFields['notification'] = $fcmMsg;
    }
    //dd(env('FIREBASE_API_ACCESS_KEY'));
    $headers = array(
        'Authorization: key='.env('FIREBASE_API_ACCESS_KEY'),
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmFields));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


//======================  active satus
// return active and btn-success if 0   &&  return de-active btn-danger  if 1

function activeStatus($status){
    $activeState = [];
    if($status != 0) {
        $activeState = ["btn-danger","de-active"];
    }
    else{
        $activeState = ["btn-success","active"];

    }
    return $activeState;
}




// make an function that sends a notification about the status of the order to the user with laravel-websockets
function sendNotification($order_id)
{
    $order = Pedido::find($order_id);
    $user =  User::whereIn('id',function($query){
    $query->select('user_id')->from('empregados')->get();
    })->get();
    Notification::send($user, new OrderNotification($order));
   // $user->notify(new OrderNotification($order));
}

