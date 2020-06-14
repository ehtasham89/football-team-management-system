<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'team_id', 'admin_id', 'status'
    ];

    /**
     * Get the team have players.
     */
    public function team()
    {
        return $this->belongsTo('App\Models\Teams');
    }
}
