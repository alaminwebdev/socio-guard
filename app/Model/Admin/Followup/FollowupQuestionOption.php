<?php

namespace App\Model\Admin\Followup;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Followup\FollowupQuestion;

class FollowupQuestionOption extends Model
{
	public function followup_question() 
	{
    	return $this->belongsTo(FollowupQuestion::class, 'followup_question_id', 'id');
    }
}
