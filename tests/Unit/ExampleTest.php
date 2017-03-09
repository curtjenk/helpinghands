<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
        $ticket = App\Ticket::findOrFail(2);
        $helpers = App\User::select('users.*')
        ->leftJoin('responses', function($join) use($ticket){
            $join->on('responses.user_id', '=', 'users.id')
            ->where('responses.ticket_id', '=', $ticket->id);
        })
        ->whereNull('responses.user_id')
        ->where('users.role_id', '!=', 1)
        ->get();
        foreach($helpers as $helper)
        {
            echo "\n".$helper->name;
        }

    }
}
