@extends('layout')
@section('hero')
    <div class="container">
        <h2>Total Questions = {{ $total_questions }}</h2>
        <h3>Total Question Attempted = {{ $question_attempted }}</h3>
        <h3>Correct = {{ $correct }}</h3>
        <h1>Your Score : </h1>
        <h1 class="display-1">
            @php
                $score = ($correct / $total_questions) * 100;
            @endphp
            {{ $score }}%
        </h1>
    </div>
@endsection
