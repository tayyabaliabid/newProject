<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * Relationship
     */
    public function group()
    {
        return $this->belongsTo(group::class);
    }
}
