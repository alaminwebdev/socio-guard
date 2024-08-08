<?php

namespace App\Model\Admin\Setup;

use App\Model\Admin\Setup\CEP_Region\SetupUserArea;
use App\Model\PollisomajSetup;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    public function pollisomaj(){
        return $this->hasMany(PollisomajSetup::class, 'division_id', 'id');
    }


    public function setupuserarea(){
        return $this->hasMany(SetupUserArea::class, 'division_id', 'id');
    }
}
