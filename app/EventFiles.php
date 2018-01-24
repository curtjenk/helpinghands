<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventFiles extends Model
{
    protected $fillable = ['event_id', 'original_filename', 'mimetype',
        'path', 'size', 'description'];

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
