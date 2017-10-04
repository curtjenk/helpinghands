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
                             'Create team',
                             'Delete team',
                             'Show team',
                             'Update team',
                             'List teams',
                             'Create event',
                             'Delete event',
                             'Show event',
                             'Update event',
                             'List events'
                            ])
                        ->pluck('id'));

        $lead = App\Role::where('name','Admin')->first();
        $lead->permissions()
              ->sync(App\Permission::whereIn('name',
                            [
                             'Update team',
                             'List teams',
                             'Create event',
                             'Delete event',
                             'Show event',
                             'Update event',
                            ])
                        ->pluck('id'));

        $member = App\Role::where('name','Member')->first();
        $member->permissions()
              ->sync(App\Permission::whereIn('name',
                            ['Show user',
                             'List users',
                             'Update user',
                             'Show organization',
                             'Show team',
                             'Show event',
                             'List organizations',
                             'List teams',
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
