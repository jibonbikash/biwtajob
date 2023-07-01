<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ২১/১/২৩
 * Time: ৮:৫১ PM
 * Copyright jibon <jibon.bikash@gmail.com>
 */
?>
@extends('layouts.vertical')
@section('title', 'Applicant List')

@section('content')
    <div class="row page-title align-items-center">
        <div class="col-md-3 col-xl-6">
            <h4 class="mb-1 mt-0">Applicant List</h4>
        </div>
        <div class="col-md-9 col-xl-6 text-md-right">
            <div class="mt-4 mt-md-0">
                <a class="btn btn-primary" href="{{ route('dashboard') }}"> <i data-feather="arrow-left-circle" class="icon-dual text-white"></i> Dashboard</a>
                {{--                <button type="button" class="btn btn-danger mr-4 mb-3  mb-sm-0"><i class="uil-plus mr-1"></i> Create Project</button>--}}

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="card mb-2">
                <div class="card-header bg-primary text-white font-size-17 font-bold font-weight-bold">
                Search
                </div>
     {!! Form::open(['route' => array('applicants'), 'files' => false, 'method'=>'get']) !!}
<div class="row mt-1 mb-3">
    <div class="col-md-3">
        {!! Form::select('job_id',$jobs,request()->get('job_id'),['class'=>'form-control select2','placeholder'=>'Select Job']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::text('q', request()->get('q'), array('placeholder' => 'Applicant Name, Mobile, email','class' => 'form-control')) !!}
    </div>
    <div class="col-md-3">
        {!! Form::text('code', request()->get('code'), array('placeholder' => 'code, roll, transaction id','class' => 'form-control')) !!}
    </div>
    <div class="col-md-3">
        <button type="submit" name="search" value="q" class="btn btn-success btn-lg float-end" title="Search"><i data-feather="search"></i></button>
        @if (request()->input('search')=='q')
         <a href="{{ route('applicants') }}" class="btn btn-warning btn-lg" title="Reset"><i data-feather="refresh-cw" class="text-white"></i></a>
        @endif
    </div>
</div>
               {!! Form::close() !!}
            </div>

            <div class="card">
                <div class="card-body">
                    @include('layouts.shared.message')
                    <table class="table table-striped table-hover">
                        <thead class="table-info">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Job Title</th>
                            <th scope="col">Code</th>
                            <th scope="col">Roll</th>
                            <th scope="col">Applicant Name</th>
                            <th scope="col">Father's Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">DOB</th>
                            {{-- <th scope="col">District</th> --}}
                            <th scope="col">Age</th>
                            {{-- <th scope="col">Quota</th> --}}
                            <th scope="col">Action</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($applicants as $applicant)
                        <tr>
                            <th scope="row">{{ $loop->iteration + $applicants->firstItem() - 1 }}</th>
                            <td>{{ $applicant->job_title }}</td>
                            <td>{{ $applicant->token }}</td>
                            <td>{{ $applicant->roll }}</td>
                            <td>{{ $applicant->name_bn }}</td>
                            <td>{{ $applicant->father_name }}</td>
                            <td>{{ $applicant->mobile }}</td>
                            <td>{{ Carbon\Carbon::parse($applicant->bday)->format('F j, Y') }}</td>
                            {{-- <td> 
                                {{ $applicant->birthplace? $applicant->birthplace->zilla_name:'' }}
                            </td> --}}
                            <td>
                                <?php
                                $fixedday = Carbon\Carbon::parse($applicant->age_calculation)->format('F j, Y');
                                $fixeddaycal = date('d-m-Y', strtotime($fixedday));
                                $datetime1 = new DateTime($fixeddaycal);
                                $datetime2 = new DateTime($applicant->bday);
                                $interval = $datetime1->diff($datetime2);
                                echo $fixedday. ' তারিখে : - ';
                                echo $interval->format('%y বছর %m মাস এবং %d দিন');
                                ?>
                            </td>
                            {{-- <td>{{ $applicant->quota }}</td> --}}
                            <td>
                                <a href="{{ route('print',$applicant->id) }}" target="_blank" title="Print Details" class="btn btn-sm btn-primary"><i data-feather="printer"></i></a>
                                <a href="{{ route('adminCard',$applicant->id) }}" target="_blank"  title="Admin Card" class="btn btn-sm btn-primary"><i data-feather="credit-card"></i></a>
                            </td>

                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $applicants->onEachSide(5)->appends(Request::all())->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>
    </div>


@endsection
@section('script')

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {



        });
    </script>

@endsection
