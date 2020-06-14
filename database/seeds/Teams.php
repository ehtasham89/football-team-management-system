<?php

use Illuminate\Database\Seeder;

class Teams extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i<5; $i++) {
            DB::table('teams')->insert([
                'name' => Str::random(10),
                'status' => 1,
                'admin_id' => 1
            ]);
        }

        for($i = 0; $i<5; $i++) {
            DB::table('players')->insert([
                'name' => Str::random(10),
                'type' => "player",
                'team_id' => '1',
                'status' => 1,
                'admin_id' => 1
            ]);
        }
    }
}
