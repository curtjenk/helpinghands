<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class Response extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 'user_id', 'helping', 'token',
    ];

    public function events()
    {
        return $this->belongsTo('App\Event');
    }
    /**
     * Generate a token to send in emails.  If dupe token
     * call recusively.
     * @return [type] [description]
     */
    static public function generateToken()
    {
        $token = str_random(30);
        if (App\Response::where('token', $token)->first()){
            generateToken();
        }
        return $token;
    }
}
