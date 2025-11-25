@extends('layout')
@section('hero')
    <div class="container mt-3">
        <h3>Create Questions</h3>
        <form method="POST" enctype="multipart/form-data" action="{{ route('submit_questions') }}">
            @csrf
            <div class="row mb-3">
                <label for="selectcategory" class="col-sm-2 col-form-label">Select Category</label>
                <div class="col-sm-10">
                    <select name="category_id" class="form-control-sm">
                        <option selected>--Please select=-</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputquestiontitle3" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                    <input type="text" name="title" class="form-control" id="inputquestiontitle3" />
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputimage3" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    <input type="file" accept="image/*" name="image" class="form-control" id="inputimage3" />
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputDescription3" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <input type="text" name="description" class="form-control" id="inputDescription3">
                </div>
            </div>
            <fieldset class="row mb-3">
                <legend class="col-form-label col-sm-2 pt-0">Answers</legend>
                <div class="col-sm-10">

                    <div class="form-check">
                        <input type="text" placeholder="answer 1" name="answer[1]">
                        <input class="form-check-input" type="radio" name="answers" value="1">
                    </div>
                    <div class="form-check">
                        <input type="text" placeholder="answer 2" name="answer[2]">
                        <input class="form-check-input" type="radio" name="answers" value="2">

                    </div>
                    <div class="form-check">
                        <input type="text" placeholder="answer 3" name="answer[3]">
                        <input class="form-check-input" type="radio" name="answers" value="3">

                    </div>
                    <div class="form-check">
                        <input type="text" placeholder="answer 4" name="answer[4]">
                        <input class="form-check-input" type="radio" name="answers" value="4">

                    </div>
                </div>
            </fieldset>
            <button type="submit" class="btn btn-primary">Add Question</button>
        </form>
    </div>
    <script>
        // var i = 0;

        // function add_answers() {


        //     $('#answersappend').append(`<div class="form-check">
    //                 <input type="text" placeholder="answer " name="answer[]">
    //                 <input class="form-check-input" type="radio" name="answers" value="${i}">
    //             </div>`);
        //     ++i;
        // }
    </script>
@endsection
