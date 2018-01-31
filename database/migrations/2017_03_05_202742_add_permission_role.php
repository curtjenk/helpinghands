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
        /*
        Everyone gets "Visitor" role and
        associated permissions. Then when user "joins"
        an organization the person adds "Member" permissions, and so on.
        At the end of the day a person can have multiple roles.
         */
        $visitor = App\Role::where('name','Visitor')->first();
        $visitor->permissions()
              ->sync(App\Permission::whereIn('name',
                            [
                             'Show organization',
                             'List organizations',
                             'Show team',
                             'List teams',
                            ])
                        ->pluck('id'));
        // dump($visitor->permissions);
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

        //Lead applies only to teams
        $lead = App\Role::where('name','Lead')->first();
        $lead->permissions()
              ->sync(App\Permission::whereIn('name',
                            [
                            'Update team',

                            'Show event',
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
                            'List organizations',

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
