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
        $players = $this->model->orderBy('id', 'desc')->get();

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
            $player->team_id = $request->input('team_id');
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

    // Assign Player To Team
    public function assignPlayer(Request $request) {
        $player = $this->model->find($request->route('id'));
        $teamId = 0;

        if ($request->route('team_id')) {
            $teamId = $request->route('team_id');
        }

        try {
            $player->type = $request->route('type');
            $player->team_id = $teamId;
            $player->save();

            return response()->json(['status' => 'success'], 201);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'failed', 'message'=> $ex->getMessage()], 401);
        }
    }

    // import csv data
    public function teamPlayerImport(Request $request) {
        $v = Validator::make($request->all(), [
            'data' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        try {
            $data = $request->input('data');

            for($i = 0; $i < count($data); $i++) {
                $data[$i]['admin_id'] = Auth::user()->id;
            }

            $this->model->insert($data);

            return response()->json(['status' => 'success'], 200);
        } catch(\Exception $e) {
            return response()->json(['status' => 'failed', 'message'=> $e->getMessage()], 401);
        }
    }
}
