<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead()
    {
        auth()->user()->notifications()->where('is_read', false)->update(['is_read' => true]);
        return response()->json(['status' => 'success']);
    }
}
