<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;
class PusherNotificationController extends Controller
{
    public function notification(Request $request)
    {
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
        $this->validate($request, [
            'nitif' => 'required'
        ]);
        
        $data['message'] = $request->nitif;
        $pusher->trigger('notify-channel', 'App\\Events\\Notify', $data);
        return redirect('/dashboard');
    }
}
