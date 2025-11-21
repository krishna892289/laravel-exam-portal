<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\AssignedTest;
use App\Models\Category;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function remove_tests(Request $request){
        AssignedTest::where('id', $request->test_id)->delete();
        return redirect()->route('view_tests')->with('success', 'Test Deleted Successfull');
    }
    public function view_tests(){
        $tests = AssignedTest::with('user')->get();
        // dd($tests);
        return view('teachers.view_tests', compact('tests'));
    }
    public function add_questions(){
        $time = Carbon::now();
        $categories = Category::all();
        return view('Teachers.add_questions', compact('time', 'categories'));
    }

    public function view_questions(){
        $questions = Question::with('answers')->get();

        return view('teachers.view_questions', compact('questions'));
    }

    public function add_category(Request $request){
        return view('teachers.add_category');
    }

    public function add_category_submit(Request $request){
        $request->validate([
            'category_name' => 'required|string'
        ]);
        Category::create([
            'category_name' => $request->category_name
        ]);

        return redirect()->route('add_category')->with('success', 'category_added successfully');
    }

    public function delete_category(Request $request){
        Category::where('id', $request->category_id)->delete();
        return redirect()->route('view_categories')->with('success', 'Category Deleted successfully');
    }

    public function edit_category_submit(Request $request){
        $Category = Category::where('id', $request->category_id)->update(['category_name' => $request->category_name]);
        if($Category){
        return redirect()->route('view_categories')->with('success', 'Category Updated Success');
        }
    }
     public function view_categories(){
        $categories = Category::all();
        return view('teachers.view_categories', compact('categories'));
    }
    public function submit_questions(Request $request){
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'title' =>'required|min:2|max:50',
            'description' => 'required|min:2',
            'image' => 'required|image',
            'answers' => 'required',
            'answer' => 'required|array|min:4',
            'answer.*' => 'required|string|distinct|min:1',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if($request->hasFile('image')){
            $imagename = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('questions12/images'), $imagename);
        }

       $question =  Question::create([
            'category_id' => $request->category_id,
            'title' =>$request->title,
            'description' => $request->description,
            'image' => $imagename,
        ]);
        // dd($request->answer, $request->answers);
        if($question){
            foreach($request->answer as $answer => $value){
                if($answer == $request->answers){
                    $answer = Answer::create([
                        'question_id' => $question->id,
                        'answer' => $value,
                        'correct' => '1'
                    ]);
                }else{
                    $answer = Answer::create([
                        'question_id' => $question->id,
                        'answer' => $value,
                        'correct' => '0'
                    ]);
                }
            }
            return redirect()->route('add_questions')->with('success', 'question submitted successfully');
            }

        }

    public function delete_question(Request $request){
        Question::where('id', $request->question_id)->delete();
        return redirect()->route('add_questions')->with('success', 'question deleted successfully');
    }

    public function assign_tests(){
        $questions = Question::with('category')->get();
        // dd($questions);
        $students = User::where('role', '2')->get();
        return view('teachers.assign_tests', compact('questions', 'students'));
    }

    public function show_single_question(Request $request){
        $question = Question::where('id', $request->question_id)->first();
        return response()->json($question);

    }

    public function assign_test(Request $request){
        $validated = Validator::make($request->all(), [
            'title' => 'required|string',
            'questions' => 'required|array|min:1',
            'student'=>'required',
            'startdatetime' => 'required'
        ]);

        $startdatetime = Carbon::make($request->startdatetime);

        if($validated->fails()){
            return redirect()->back()->withErrors($validated);
        }

        $questions = [];
        foreach($request->questions as $data){
            $questions[] = $data;
        }
        // dd(implode($questions));
        $assigntest = AssignedTest::create([
            'title' => $request->title,
            'question_ids' => implode(',',$questions),
            'user_id' => $request->student,
            'startdatetime' => $startdatetime
        ]);

        if($assigntest){
            return redirect()->route('assign_tests')->with('success', 'Test Assigned Successfully');
        }else{
            return redirect()->route('assign_tests')->with('fail', 'Test Not Assigned  Successfully');
        }


    }

}

