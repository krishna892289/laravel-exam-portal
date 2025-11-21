<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\AssignedTest;
use App\Models\TakeAnswer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Assign;

use function PHPUnit\Framework\isEmpty;

class HomeController extends Controller
{
    public function home(){
        return view('welcome');
    }

    public function dashboards(){
        if(Auth::user()->role == '2'){
            $valid_time = Carbon::now()->subHours(3);
            $tests = AssignedTest::where('user_id', Auth::user()->id)->where('status', 'pending')->where('startdatetime', '>', $valid_time)->get();
            return view('Students.dashboard', compact('tests'));
        }elseif(Auth::user()->role == '1'){
            return view('Teachers.dashboard');
        }
    }

    public function start_test(Request $request)
    {
        $test = AssignedTest::find($request->test_id);
        if (!$test) {
            return redirect()->route('dashboards')->with('fail', 'Invalid test selected');
        }
        $start_time = Carbon::parse($test->startdatetime);
        $end_time = $start_time->copy()->addHours(3);
        if ($end_time->isPast() || $test->status === 'completed') {
            return redirect()->route('dashboards')->with('fail', 'Good attempt but test is over');
        }
        return view('Students.test', compact('test'));
    }
    public function submit_answers(Request $request){
        $test_status_check = AssignedTest::where('id', $request->test_id)->where('status', 'completed')->first();
        if($test_status_check){
            // dd('yes');
            return redirect()->route('dashboards')->with('fail', 'Nice try but test alreayd completed');
        }
        foreach($request->question as $question_id){
                foreach($request->answer as $que_id => $answer_id){
                if($question_id == $que_id){
                    $submit = TakeAnswer::create([
                        'test_id' => $request->test_id,
                        'candidate_id' => Auth::user()->id,
                        'question_id' => $que_id,
                        'answer_id' => $answer_id
                    ]);
                }
            }
        }

        if($submit){
            AssignedTest::where('id', $request->test_id)->update(['status' => 'completed']);

            $assigned_test = AssignedTest::where('id', $request->test_id)->first();
            $questions = explode(',',$assigned_test->question_ids);
            $my_answers = TakeAnswer::where('test_id', $request->test_id)->get();

           $total_questions = 0;

           foreach($questions as $question){
               ++$total_questions;
            }

            $correct = 0;
            $question_attempted = 0;

            foreach($my_answers as $my_answer){
                if(!$my_answer->answer_id == NULL){
                   $answer = Answer::where('id', $my_answer->answer_id)->first();
                   if($answer->correct == 1){
                    ++$correct;
                   }
                    ++$question_attempted;
                }
            }

            // dd($correct);
            return view('students.result', compact('total_questions', 'question_attempted', 'correct'));
    }




    }

}
