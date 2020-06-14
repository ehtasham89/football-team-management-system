<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    public function __construct(\App\Models\Players $players) {
        $this->model = $players;
    }

    // get all unassigned players
    public function getList(Request $request) {
        $players = $this->model->where('team_id', 0)->orderBy('id', 'desc')->get();

        if ($players->count()) {
            return response()->json(['status' => 'success', 'data' => $players], 200);
        }
        
        return response()->json(['status' => 'failed', 'message' => 'data not found!'], 401);
    }

    // create new 
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
            $player = $this->model;
            $player->name = $request->input('name');
            $player->status = 1;
            $player->admin_id = Auth::user()->id;
            $player->type = null !== $request->input('type') ? $request->input('type') : 'player';
            $player->save();

            return response()->json(['status' => 'success', 'player_id' => $player->id], 201);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'failed', 'message'=> $ex->getMessage()], 401);
        }
    }

    // update status 
    public function updateStatus(Request $request) {
        $player = $this->model->find($request->route('id'));

        try {
            $player->status = $request->route('status');
            $player->save();

            return response()->json(['status' => 'success'], 201);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'failed', 'message'=> $ex->getMessage()], 401);
        }
    }

    // change type 
    public function changeType(Request $request) {
        $player = $this->model->find($request->route('id'));

        try {
            $player->status = $request->route('type');
            $player->save();

            return response()->json(['status' => 'success'], 201);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'failed', 'message'=> $ex->getMessage()], 401);
        }
    }

    // import csv data
    public function teamPlayerImport(Request $request, \App\Models\Teams $team) {
        $v = Validator::make($request->all(), [
            'data' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $data = json_decode($request->input('data'), true);

        $teamDaya = $team->where('name', $data->team_name)->first();

        $playerList = $data->player_list;

        if($teamDaya->id) {
            foreach($playerList as $player) {
                $player->team_id = $teamDaya->id;
            }

            $this->model->insert($playerList);

            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message'=> 'team name not found'], 401);
        }
    }
}
