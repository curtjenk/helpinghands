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
        $su = App\Role::where('name','Super User')->first();
        $su->permissions()->sync(App\Permission::all()->pluck('id'));

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
                             'Create ticket',
                             'Delete ticket',
                             'Show ticket',
                             'Update ticket',
                             'List tickets'
                            ])
                        ->pluck('id'));

        $user = App\Role::where('name','User')->first();
        $user->permissions()
              ->sync(App\Permission::whereIn('name',
                            ['Show user',
                             'List users',
                             'Show organization',
                             'List organizations',
                             'Create ticket',
                             'Show ticket',
                             'Update ticket',
                             'List tickets'
                            ])
                        ->pluck('id'));

        $orgadmin = App\Role::where('name','Organization Admin')->first();
        $orgadmin->permissions()
              ->sync(App\Permission::whereIn('name',
                            ['Create user',
                             'Delete user',
                             'Show user',
                             'Update user',
                             'List users',
                             'Show organization',
                             'Update organization',
                             'Create ticket',
                             'Delete ticket',
                             'Show ticket',
                             'Update ticket',
                             'List tickets'
                            ])
                        ->pluck('id'));

        $orguser = App\Role::where('name','Organization User')->first();
        $orguser->permissions()
              ->sync(App\Permission::whereIn('name',
                            ['Show user',
                             'List users',
                             'Show organization',
                             'Create ticket',
                             'Show ticket',
                             'Update ticket',
                             'List tickets'
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
