<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $admin = factory(\App\Models\User::class, 1)->create([
            'name' => 'Admin',
            'surname' => null,
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
        ]);

        (new \Laravel\Passport\ClientRepository())->createPasswordGrantClient($admin->first()->id, config('app.name'), '');
        $personalAccessClient = (new \Laravel\Passport\ClientRepository())->createPersonalAccessClient(null, 'Socialite', '');

        \Illuminate\Support\Facades\DB::table('oauth_personal_access_clients')->insert([
            ['client_id' => $personalAccessClient->id]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
