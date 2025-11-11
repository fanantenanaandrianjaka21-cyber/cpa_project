<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MailLogController extends Controller
{
    public function index()
    {
        $logs = DB::table('mail_logs')
            ->orderByDesc('envoye_le')
            ->limit(50) // Derniers 50 envois
            ->get();

        return view('mail_logs.index', compact('logs'));
    }
}
