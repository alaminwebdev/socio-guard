<?php

namespace App\Model\Admin\Followup;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Model\Admin\Followup\FollowupQuestion;
use App\Model\Admin\Followup\FollowupQuestionAnswerDetail;

class FollowupQuestionAnswer extends Model
{
	public function followup_done_by() 
	{
    	return $this->belongsTo(User::class, 'created_by', 'id');
    }

	public function followup_question() 
	{
    	return $this->belongsTo(FollowupQuestion::class, 'followup_question_id', 'id');
    }

    public function followup_question_answer_details()
    {
    	return $this->hasMany(FollowupQuestionAnswerDetail::class, 'followup_question_answer_id', 'id');
    }
}
