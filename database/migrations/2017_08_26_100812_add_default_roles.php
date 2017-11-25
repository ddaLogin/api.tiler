<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->getDefaultRoles() as $roleData){
            \HttpOz\Roles\Models\Role::create([
                'name' => $roleData['name'],
                'slug' => $roleData['slug'],
                'description' => $roleData['description'],
                'group' => (key_exists('group', $roleData)) ? $roleData['group'] : 'default',
            ]);
        }
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

    private function getDefaultRoles()
    {
        return[
            ['name' => 'Administrator', 'slug' => 'admin', 'description' => 'Has full access', 'group' => 'administration'],
            ['name' => 'Moderator', 'slug' => 'moderator', 'description' => 'Has advanced access', 'group' => 'administration'],
            ['name' => 'User', 'slug' => 'user', 'description' => 'Has limited access'],
        ];
    }
}
