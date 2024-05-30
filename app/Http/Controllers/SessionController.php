<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sessions_manager;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    use \App\Http\Controllers\GlobalTrait\SessionManager;

    public function showSessions(Request $request) {
        // Retrieve sessions for the authenticated user
        $userId = Auth::user()->id;
        $sessions = sessions_manager::where('user_id', $userId)->get();
        $sessions = sessions_manager::all();

        // Pass the sessions data to the view
        return view('app.session.show', compact('sessions'));
    }
}
