<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        return view('home');
        return View('layouts.master');
    }


    public function statusCode(Request $request)
    {

        if (!Auth::check()) {
            return response()->json(['error' => 'Permission Denied'], 403);
        }
        if (Auth::user()->type != 'admin') {
            return response()->json(['error' => 'Permission Denied'], 403);
        }
        // Begin Transaction
        DB::beginTransaction();
        try {
            $id = $request->id;
            $table = $request->table;
            $status = $request->setStatus;
            $result = DB::table($table)->where('id', $id)->update(['status' => $status]);

            // Commit Transaction
            DB::commit();
            if ($result) {
                return response()->json(['success' => 'Status has been changed.']);
            } else {
                return response()->json(['error' => 'Something went wrong' . '!'], 400);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            // Rollback Transaction
            DB::rollback();
            $errorMessage = $e->getMessage();
            Log::error($errorMessage);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

}
