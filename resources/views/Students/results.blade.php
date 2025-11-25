@extends('layout')
@section('hero')

    <div class="container mt-3">
        @forelse ($results as $result)
            @php
                $question_ids = explode(
                    ',',
                    App\Models\AssignedTest::where('id', $result->test_id)->value('question_ids'),
                );
                // dd($questions);
            @endphp
            <div class="card mt-2">
                <h5 class="card-header">
                    Test Name : {{ App\Models\AssignedTest::where('id', $result->test_id)->value('title') }}
                </h5>

                <div class="card-body">
                    <div class="row align-items-center">

                        <div class="col">
                            @if (auth()->user()->role == '2')
                                <h4 class="card-title">Candidate Name : {{ auth()->user()->name }}</h4>
                            @else
                                <h4 class="card-title">Candidate Name :
                                    {{ App\Models\User::where('id', $result->user_id)->value('name') }}</h4>
                            @endif
                            </h5>
                            <div class="fw-bold">
                                Total Questions :
                                {{ $result->total_questions }}
                            </div>

                            <p>Start Date & Time :
                                {{ App\Models\AssignedTest::where('id', $result->test_id)->value('startdatetime') }}

                            </p>
                        </div>

                        <div class="col-auto">
                            SCORE: {{ number_format($result->score, 2, '.', ',') }}%

                        </div>

                        <div class="col-auto">
                            <button type="submit" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#viewresult_modal{{ $result->id }}">View Question Answers</button>
                            </form>
                        </div>

                        <div class="modal fade" id="viewresult_modal{{ $result->id }}" tabindex="-1"
                            aria-labelledby="viewresult_modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-responsive">
                                            <tr>
                                                <th>Question</th>
                                                <th>Submitted Answer</th>
                                                <th>Correct ?</th>
                                            </tr>
                                            @foreach ($question_ids as $question_id)
                                                <tr>
                                                    <td>
                                                        {{ App\Models\Question::where('id', $question_id)->value('title') ?? 'Question Not found' }}
                                                    </td>
                                                    @php
                                                        $answer_id = App\Models\TakeAnswer::where(
                                                            'question_id',
                                                            $question_id,
                                                        )
                                                            ->where('test_id', $result->test_id)
                                                            ->value('answer_id');
                                                        $answer = App\Models\Answer::where('id', $answer_id)->first();
                                                        if ($answer == 'NULL') {
                                                            $answer->correct = 0;
                                                        }
                                                        // dd($answer);
                                                    @endphp
                                                    <td>
                                                        {{ $answer->answer ?? 'NULL' }}
                                                    </td>
                                                    <td>
                                                        @if (!isset($answer->correct))
                                                            <i class="bi bi-x-circle text-danger"></i>
                                                        @elseif (!$answer->correct == '0')
                                                            <i class="bi bi-hand-thumbs-up-fill text-primary"></i>
                                                        @else
                                                            <i class="bi bi-x-circle text-danger"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            No Tests given Yet
        @endforelse

    </div>
@endsection
