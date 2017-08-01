<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventFiles extends Model
{
    protected $fillable = ['event_id', 'filename', 'original_filename'];

    /**
      * Indicates if the model should be timestamped.
      *
      * @var bool
      */
    public $timestamps = false;

    public function events()
    {
        return $this->belongsTo('App\Event');
    }
}
