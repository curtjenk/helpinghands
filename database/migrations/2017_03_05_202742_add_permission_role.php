<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermissionRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $admin = App\Role::where('name','Admin')->first();
        $admin->permissions()
              ->sync(App\Permission::whereIn('name',
                            ['Create user',
                             'Delete user',
                             'Show user',
                             'Update user',
                             'List users',
                             'Create organization',
                             'Delete organization',
                             'Show organization',
                             'Update organization',
                             'List organizations',
                             'Create event',
                             'Delete event',
                             'Show event',
                             'Update event',
                             'List events'
                            ])
                        ->pluck('id'));


        $orguser = App\Role::where('name','Member')->first();
        $orguser->permissions()
              ->sync(App\Permission::whereIn('name',
                            ['Show user',
                             'List users',
                             'Update user',
                             'Show organization',
                             'Show event',
                             'List events'
                            ])
                        ->pluck('id'));

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
