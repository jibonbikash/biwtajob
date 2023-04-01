@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Vacancies') }}</div>
                <div class="card-body">
                    @include('layouts.shared.message')
                    <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                        <tr class="table-secondary">
                            <th scope="col">#</th>
                            <th scope="col">Position</th>
                            <th scope="col">Number of total post</th>
                            <th scope="col">Job circular no</th>
                            <th scope="col">Last date of application</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($jobs as $job)
                        <tr>

                            <th scope="row">{{ $loop->iteration + $jobs->firstItem() - 1 }}</th>
                            <td>
                                <a href="{{ route('details',['uuid'=>$job->uuid]) }}">
                                {{$job->title}}
                                </a></td>
                            <td>{{$job->vacancies}}</td>
                            <td>{{$job->job_id}}</td>
                            <td>{{ Carbon\Carbon::parse($job->application_deadline)->format('F j, Y') }}
                        @endforeach


                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example">
                    {{ $jobs->appends(Request::all())->links('pagination::bootstrap-5') }}
                    </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
