<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PollisomajTheatreModel extends Model
{
    protected $table='pollisomaj_theatre_category';


    /**
     * Get the pollisomaj theatre list for the blog post.
     */
    public function pollisomajData()
    {
        return $this->belongsTo(PollisomajTheatreModel::class,'pollisomaj_ref_id','pollisomaj_data_ref');
    }
}
