<?php

namespace App\Model\Admin\Followup;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Followup\FollowupQuestionOption;
use App\Model\Admin\Followup\FollowupQuestionAnswerDetail;

class FollowupQuestion extends Model
{
	public function followup_question_option()
    {
    	return $this->hasMany(FollowupQuestionOption::class, 'followup_question_id', 'id');
    }

    public function question_answer()
    {
    	return $this->hasMany(FollowupQuestionAnswerDetail::class, 'question_id', 'id');
    }
}
