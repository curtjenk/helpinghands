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
        //skip this stuff
        //
        return;

        $visitor = App\Role::where('name','Visitor')->first();
        $visitor->permissions()
              ->sync(App\Permission::whereIn('name',
                            [
                             'List users',
                             'List organizations',
                             'List teams',
                             'Show event',
                             'List events',
                            ])
                        ->pluck('id'));
        $site = App\Role::where('name','Site')->first();
        $site->permissions()
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
                             'List events',
                            ])
                        ->pluck('id'));

        $admin = App\Role::where('name','Admin')->first();
        $admin->permissions()
              ->sync(App\Permission::whereIn('name',
                            [
                             'Show organization',
                             'Update organization',

                             'Create team',
                             'Delete team',
                             'Show team',
                             'Update team',
                             'List teams',

                             'Create event',
                             'Delete event',
                             'Show event',
                             'Update event',
                             'List events',
                            ])
                        ->pluck('id'));

        $lead = App\Role::where('name','Lead')->first();
        $lead->permissions()
              ->sync(App\Permission::whereIn('name',
                            [
                            'Update team',

                            'Create event',
                            'Delete event',
                            'Update event',
                            ])
                        ->pluck('id'));

        $member = App\Role::where('name','Member')->first();
        $member->permissions()
              ->sync(App\Permission::whereIn('name',
                            [
                            'Show user',
                            'List users',

                            'Show organization',

                            'Show team',
                            'List teams',

                            'Show event',
                            'List events',

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
