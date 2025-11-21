@extends('layout')
@section('hero')
    <div class="container p-3 border-primary border  rounded ">
        <h3> My Tests</h3>
        <p>Current Time: {{ $currentTime = \Carbon\Carbon::now() }}</p>
        @if (!$tests->isEmpty())
            <div class="px-5">
                <div class="row">
                    <div class="col">Test Name</div>
                    <div class="col">Start Time:</div>
                    <div class="col">End Time:</div>
                    <div class="col">Action</div>
                </div>
            </div>
        @else
            No test found
        @endif
        @foreach ($tests as $test)
            @php
                $startTime = \Carbon\Carbon::parse($test->startdatetime);
                $endTime = $startTime->copy()->addHours(3);

            @endphp

            <div class="mt-4 p-5 bg-primary text-white rounded">
                <div class="row">
                    <div class="col">{{ $test->title }}</div>
                    <div class="col">{{ $startTime->toDayDateTimeString() }}</div>
                    <div class="col">{{ $endTime->toDayDateTimeString() }}</div>

                    <div class="col">
                        @if ($startTime->lessThanOrEqualTo($currentTime))
                            @if ($endTime->greaterThan($currentTime))
                                <form action="{{ route('start_test') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="test_id" value="{{ $test->id }}">
                                    <button class="btn btn-danger" type="submit">Attempt Test</button>
                                </form>
                            @else
                                <span class="bg-dark p-1 rounded">Test Expired</span>
                            @endif
                        @else
                            <span class="bg-secondary p-1 rounded">Test Not Started Yet</span>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection
