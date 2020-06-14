<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Models\Teams;

class TeamsController extends Controller
{
    // get all teams
    public function getList(Request $request) {
        $teams = new Teams();

        $teams = $teams->all();

        if ($teams->count()) {
            return response()->json(['status' => 'success', 'data' => $teams], 200);
        }
        
        return response()->json(['status' => 'failed', 'data' => $teams, 'data not found!'], 401);
    }

    // get team with player
    public function getTeamPlayer(Request $request) {
        $teams = new Teams();

        $teams = $teams->find($request->route('team_id'))->players()->get();

        if ($teams->count()) {
            return response()->json(['status' => 'success', 'data' => $teams], 200);
        }
        
        return response()->json(['status' => 'failed', 'data' => $teams, 'message'=> 'data not found!'], 401);
    }

    // create new team 
    public function create(Request $request) {
        $teams = new Teams();

        $v = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        try {
            $teams->name = $request->input('name');
            $teams->status = 1;
            $teams->admin_id = Auth::user()->id;
            $teams->save();

            return response()->json(['status' => 'success'], 201);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'failed', 'data' => $teams, 'message'=> $ex->getMessage()], 401);
        }
    }

    // update team status 
    public function updateStatus(Request $request) {
        $teams = new Teams();

        $teams = $teams->find($request->route('team_id'));

        try {
            $teams->status = $request->route('status');
            $teams->save();

            return response()->json(['status' => 'success'], 201);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'failed', 'data' => $teams, 'message'=> $ex->getMessage()], 401);
        }
    }
}
