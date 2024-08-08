<?php

namespace App\Http\Controllers\Backend\Admin\Followup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Auth;
use App\User;
use App\Model\Admin\Followup\FollowupQuestion;
use App\Model\Admin\Followup\FollowupQuestionOption;
use App\Model\Admin\Followup\FollowupQuestionAnswer;

class FollowupQuestionController extends Controller
{
	public function view() 
	{
		$data['followup_questions'] = FollowupQuestion::select('id', 'question', 'status')
                                        ->orderBy('id', 'ASC')
                                        ->get();
                                    
        // dd($data['followup_questions']->toArray());
        return view('backend.admin.followup.view', $data);
    }

    public function add()
    {
        return view('backend.admin.followup.add');
    }

    public function store(Request $request)
    {
		// dd($request->toArray());

        $followup_question = new FollowupQuestion;
        $followup_question->question   = $request->question;
        $followup_question->created_by = Auth::user()->id;
        $followup_question->save();

        return redirect()->route('followup.question.view')->with('success', 'Successfully Inserted');
    }

    public function edit($id)
    {
        $data['editData'] = FollowupQuestion::select('id', 'question', 'status')->find($id);
        // dd($data['editData']->toArray());

        return view('backend.admin.followup.edit', $data);
    }

    public function update(Request $request, $id)
    {
		// dd($request->toArray());

        $followup_question = FollowupQuestion::find($id);
        $followup_question->question   = $request->question;
        $followup_question->updated_by = Auth::user()->id;
        $followup_question->save();

        return redirect()->route('followup.question.view')->with('success', 'Successfully Updated');
    }

    public function viewOption() 
    {
        $data['followup_questions'] = FollowupQuestion::with(['followup_question_option'])
                                        ->where('status', 1)
                                        ->orderBy('id', 'ASC')
                                        ->get();
                                    
        // dd($data['followup_questions']->toArray());

        return view('backend.admin.followup.view_option', $data);
    }

    public function addOption()
    {
        $data['followup_questions'] = FollowupQuestion::select('id', 'question', 'status')
                                        ->where('status', 1)
                                        ->orderBy('id', 'ASC')
                                        ->get();

        return view('backend.admin.followup.add_option', $data);
    }

    public function storeOption(Request $request)
    {
        // dd($request->toArray());

        foreach($request->option as $key => $value)
        {
            $question_option = new FollowupQuestionOption;
            $question_option->followup_question_id = $request->question_id;
            $question_option->option = $value;
            $question_option->created_by = Auth::user()->id;
            $question_option->save();
        }

        return redirect()->route('followup.question.option.view')->with('success', 'Successfully Inserted');
    }

    public function editOption($id)
    {
        $data['editData'] = FollowupQuestion::with(['followup_question_option'])->find($id);
        $data['followup_questions'] = FollowupQuestion::select('id', 'question', 'status')
                                        ->where('status', 1)
                                        ->orderBy('id', 'ASC')
                                        ->get();
        // dd($data['editData']->toArray());

        return view('backend.admin.followup.edit_option', $data);
    }

    public function updateOption(Request $request, $id)
    {
        // dd($request->toArray());

        $question_option = FollowupQuestionOption::where('followup_question_id', $id)->delete();
        foreach($request->option as $key => $value)
        {
            $question_option = new FollowupQuestionOption;
            $question_option->followup_question_id = $request->question_id;
            $question_option->option = $value;
            $question_option->updated_by = Auth::user()->id;
            $question_option->save();
        }

        return redirect()->route('followup.question.option.view')->with('success', 'Successfully Updated');
    }

    public function delete($id)
    {
        // dd($id);

        FollowupQuestion::where('id', $id)->delete();
        return response()->json('deleted');
    }

    public function changeQuestionStatus(Request $request)
    {
        $region = FollowupQuestion::find($request->id);
        $region->status = $request->status;
        $region->save();

        return response()->json('changed');
    }
}
