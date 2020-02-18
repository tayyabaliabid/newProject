<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * Relationship
     */

    public function contacts()
    {
        return $this->hasMany(contact::class);
    }

    
    public function delete()
    {
        // delete all related contacts 
        $this->contacts()->delete();  

        return parent::delete();
    }

}
