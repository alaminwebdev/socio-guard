<?php

namespace App\Model\Admin\Followup;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Followup\FollowupQuestionOption;
use App\Model\Admin\Followup\FollowupQuestionAnswer;

class FollowupQuestionAnswerDetail extends Model
{
	public function followup_question_answer()
    {
    	return $this->belongsTo(FollowupQuestionAnswer::class, 'followup_question_answer_id', 'id');
    }

    public function question_answer_option()
    {
    	return $this->belongsTo(FollowupQuestionOption::class, 'answer', 'id');
    }
}
