@extends('layout')
@section('hero')
    <div class="container mt-3 border border-dark">
        <h1 class="text-center">Test</h1>
        <b>Time: <span>{{ Illuminate\Support\Carbon::now()->toDayDateTimeString() }}</span></b>
        <div class="d-flex justify-content-between bg-secondary mb-3">
            @php
                $startTime = Illuminate\Support\Carbon::parse($test->startdatetime);
            @endphp
            <div class="p-2 bg-info">Start Time : {{ $startTime->toDayDateTimeString() }}</div>
            <div class="p-2 bg-warning">Subject : {{ $test->title }}</div>
            <div class="p-2 bg-danger">End Time :
                <span id="testendtime">{{ $startTime->addHours(3)->toDayDateTimeString() }}</span>
                <p id="hiddentendtime" class="d-none">{{ $startTime->copy()->timestamp }}</p>

            </div>
        </div>

        @php
            $question_ids = explode(',', $test->question_ids);
            $i = 0;
        @endphp
        <form action="{{ route('submit_answers') }}" method="POST" id="submitanswerform">
            <input type="hidden" name="test_id" value="{{ $test->id }}">
            @csrf
            @foreach ($question_ids as $question_id)
                @php
                    $question = App\Models\Question::where('id', $question_id)->first();
                @endphp
                @if (!isset($question->title))
                    'NA'
                @else
                    <div id="questions" class="bg-light">
                        <div class="row mt-3 ">
                            <div class="col">
                                <h3> Question {{ ++$i }}: {{ $question->title }}</h3>
                                <p> Description: {{ $question->description }}</p>
                            </div>
                            <div class="col">
                                Image : <img src="{{ asset('questions12/images') . '/' . $question->image }}"
                                    style="object-fit:cover max-width: 300px; max-height: 300px;" class="img-thumbnail">
                            </div>
                        </div>
                        <div>
                            <fieldset class="row mb-3">
                                <legend class="col-form-label col-sm-2 pt-0">Choose Answers:</legend>
                                <div class="col-sm-10">
                                    @php
                                        $answers = App\Models\Answer::where('question_id', $question->id)->get();

                                    @endphp
                                    <input type="hidden" name="question[{{ $question->id }}]"
                                        value="{{ $question->id }}">
                                    <input type="hidden" name="answer[{{ $question->id }}]" value="">
                                    @foreach ($answers as $answer)
                                        <div class="form-check">
                                            {{ $answer->answer }}
                                            <input class="form-check-input" type="radio"
                                                name="answer[{{ $question->id }}]" value="{{ $answer->id }}">
                                        </div>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>
                    </div>
                @endif
            @endforeach
            <button class="btn btn-outline-success">Submit</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            var endtime = parseInt($("#hiddentendtime").text()) * 1000;

            if ($.now() >= endtime) {
                confirm('text is over and now it is submitting');
                $("#submitanswerform").submit();
            }
        });
    </script>
@endsection
