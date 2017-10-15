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
