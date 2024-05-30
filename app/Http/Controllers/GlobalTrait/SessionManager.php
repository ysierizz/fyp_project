<?php

namespace App\Http\Controllers\GlobalTrait;

use Illuminate\Http\Request;
use App\Models\sessions_manager;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

trait SessionManager {

    public function setSessions(Request $request, $user, $last_activity) {

    	$request->session()->put('id', $user->id);

    	$sessions = new sessions_manager;
    	$sessions->user_id = $user->id;
    	$sessions->ip_address = request()->ip();
    	$sessions->last_activity = $last_activity ;
    	$sessions->updated_at = Carbon::now()->toDateTimeString();
    	$sessions->save();

    	return true;
    }

    public function releaseSessions(Request $request, $last_activity) {
        
        $sessions = new sessions_manager;
        $sessions->user_id = Auth::user()->id;
        $sessions->ip_address = request()->ip();
        $sessions->last_activity = $last_activity ;
        $sessions->updated_at = Carbon::now()->toDateTimeString();
        $sessions->save();

        return true;
    }

    public function crudSessions(Request $request, $last_activity, $sess_remark) {
        
        $sessions = new sessions_manager;
        $sessions->user_id = Auth::user()->id;
        $sessions->ip_address = request()->ip();
        $sessions->last_activity = $last_activity;
        $sessions->sess_remark = $sess_remark;
        $sessions->updated_at = Carbon::now()->toDateTimeString();
        $sessions->save();

        return true;
    }
    
}
