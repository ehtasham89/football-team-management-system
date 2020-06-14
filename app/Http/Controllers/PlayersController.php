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

    // get all
    public function getList(Request $request) {
        $teams = $this->model->whereNull('team_id')->get();

        if ($teams->count()) {
            return response()->json(['status' => 'success', 'data' => $teams], 200);
        }
        
        return response()->json(['status' => 'failed', 'data' => $teams, 'data not found!'], 401);
    }

    // create new 
    public function create(Request $request) {
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
            $player = $this->model;
            $player->name = $request->input('name');
            $player->status = 1;
            $player->admin_id = Auth::user()->id;
            $player->type = null !== $request->input('type') ? $request->input('type') : 'player';
            $player->save();

            return response()->json(['status' => 'success'], 201);
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
}
