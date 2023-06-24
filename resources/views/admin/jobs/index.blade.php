<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ২১/১/২৩
 * Time: ৭:০৫ PM
 * Copyright jibon <jibon.bikash@gmail.com>
 */
?>

@extends('layouts.vertical')


@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endsection

@section('breadcrumb')
    <div class="row page-title align-items-center">
        <div class="col-sm-4 col-xl-6">
            <h4 class="mb-1 mt-0">Jobs</h4>
        </div>

    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                @include('layouts.shared.message')
                    <div class="row">
                        <div class="col-md-12">
                            <div  class="table-responsive">

                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Application Deadline</th>
                                        <th scope="col">Application Fee</th>
                                        <th scope="col">Applied Application</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($jobs as $job)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration + $jobs->firstItem() - 1 }}</th>
                                        <td>{{ $job->title }}</td>
                                        <td>  {{ \Carbon\Carbon::parse($job->application_deadline)->format('F j, Y') }}</td>
                                        <td>{{ $job->apply_fee }}</td>
                                        <td>{{ $job->applicants_count }}</td>
                                        <td>
                                            <a class="btn btn-success  btn-sm" title="Edit" href="{{ route('jobs.edit',$job->id) }}"><i data-feather="edit" class="text-white"></i></a>
                                            <a class="btn btn-warning  btn-sm" title="Setting" href="{{ route('jobs.setting',['uuid'=>$job->uuid]) }}"><i data-feather="settings" class="text-white"></i></a>
                                        @if($job->applicants_count < 1)
                                            {!! Form::open(['method' => 'DELETE','route' => ['jobs.destroy', $job->id],'style'=>'display:inline']) !!}
                                            {!! Form::button('<i data-feather="trash-2"></i>', ['type' => 'submit', 'class' => 'btn btn-danger  btn-sm', 'onclick'=>'return confirm("Are you sure you want to delete this item?");']) !!}

                                            {!! Form::close() !!}
                                            @endif
                                            <a class="btn btn-info  btn-sm" title="Applicant Lits({{ $job->applicants_count }})" href="{{ route('applicants',['job_id'=>$job->id]) }}"><i data-feather="users" class="text-white"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                            {{ $jobs->onEachSide(5)->appends(Request::all())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <!-- optional plugins -->

@endsection

@section('script-bottom')

    <script type="text/javascript">

        $( function() {

        } );
    </script>

@endsection
