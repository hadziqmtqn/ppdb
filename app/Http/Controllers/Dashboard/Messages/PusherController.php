<?php

namespace App\Http\Controllers\Dashboard\Messages;

use App\Http\Controllers\Controller;

class PusherController extends Controller
{
    public function getPusherConfig()
    {
        return response()->json([
            'key' => config('broadcasting.connections.pusher.key'),
            'cluster' => config('broadcasting.connections.pusher.options.cluster'),
        ]);
    }
}
