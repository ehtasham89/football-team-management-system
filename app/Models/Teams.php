<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status', 'admin_id',
    ];

    /**
     * The players that belong to the team.
     */
    public function players()
    {
        return $this->hasMany('App\Models\Players', 'team_id', 'id');
    }
}
