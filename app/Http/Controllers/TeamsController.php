<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    public function __construct(\App\Models\Teams $teams) {
        $this->model = $teams;
    }

    // get all teams
    public function getList(Request $request) {
        $teams = $this->model->all();

        if ($teams->count()) {
            return response()->json(['status' => 'success', 'data' => $teams], 200);
        }
        
        return response()->json(['status' => 'failed', 'data not found!'], 401);
    }

    // get team with player
    public function getTeamPlayer(Request $request) {
        $teams = $this->model->find($request->route('id'))->players()->get();

        if ($teams->count()) {
            return response()->json(['status' => 'success', 'data' => $teams], 200);
        }
        
        return response()->json(['status' => 'failed', 'message'=> 'data not found!'], 401);
    }

    // create new team 
    public function create(Request $request) {
        $v = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        try {
            $teams = $this->model;
            $teams->name = $request->input('name');
            $teams->status = 1;
            $teams->admin_id = Auth::user()->id;
            $teams->save();

            return response()->json(['status' => 'success'], 201);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'failed', 'message'=> $ex->getMessage()], 401);
        }
    }

    // update team status 
    public function updateStatus(Request $request) {
        $teams = $this->model->find($request->route('id'));

        try {
            $teams->status = $request->route('status');
            $teams->save();

            return response()->json(['status' => 'success'], 201);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'failed', 'message'=> $ex->getMessage()], 401);
        }
    }

    // replace player with new player
    public function replacePlayer(Request $request) {
        try {
           //unassign player
            $player = $this->model->find($request->route('id'));
            $player->team_id = null;
            $player->save();
            // assign player
            $player = $this->model->find($request->route('p_id'));
            $player->team_id = $request->route('t_id');
            $player->save();

            return response()->json(['status' => 'success'], 201);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'failed', 'message'=> $ex->getMessage()], 401);
        }
    }
}
