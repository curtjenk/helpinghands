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

                             'Create organization',
                             'Delete organization',
                             'Show organization',
                             'Update organization',

                             'Create team',
                             'Delete team',
                             'Show team',
                             'Update team',

                             'Create event',
                             'Delete event',
                             'Show event',
                             'Update event'
                            ])
                        ->pluck('id'));

        $lead = App\Role::where('name','Lead')->first();
        $lead->permissions()
              ->sync(App\Permission::whereIn('name',
                            [
                            'Show user',

                            'Show organization',
                            'Update organization',

                            'Create team',
                            'Delete team',
                            'Show team',
                            'Update team',

                            'Create event',
                            'Delete event',
                            'Show event',
                            'Update event'

                            ])
                        ->pluck('id'));

        $member = App\Role::where('name','Member')->first();
        $member->permissions()
              ->sync(App\Permission::whereIn('name',
                            [
                            'Show user',

                            'Show organization',

                            'Show team',

                            'Show event'

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
