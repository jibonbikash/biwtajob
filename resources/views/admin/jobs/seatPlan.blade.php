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
@section('title', 'Exam Seat Plan')

@section('content')
    <div class="row page-title align-items-center">
        <div class="col-md-3 col-xl-6">
            <h4 class="mb-1 mt-0">Exam Seat Plan(Written Test)</h4>
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
            <div class="card">
                <div class="card-body">
                    @include('layouts.shared.message')

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="card mb-2 border">
                                <div class="card-header bg-primary text-white font-size-17 font-bold font-weight-bold">
                                    Setting
                                </div>
                                {!! Form::open(['route' => array('seatPlansetting'), 'files' => false, 'method'=>'POST']) !!}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                        <div class="form-group">
                                            {!! Form::select('job_cercularID',$jobID,request()->get('job_id'),['class'=>'form-control select2','placeholder'=>'Select Job ID','required'=>true, 'id'=>'job_cercularID_exam']) !!}
                                        </div>
                                        </div>
                                        <div class="col-md-2">
                                            {!! Form::select('job_id',$jobs,request()->get('job_id'),['class'=>'form-control select2','placeholder'=>'Select Job', 'id'=>'job_id']) !!}
                                        </div>
                                        <div class="col-md-2">
                                            {!! Form::text('rollstart', request()->get('rollstart'), array('placeholder' => 'Roll Start From','class' => 'form-control rollstart', 'id'=>'rollstart')) !!}
                                        </div>
                                        <div class="col-md-2">
                                            {!! Form::text('rollend', request()->get('rollend'), array('placeholder' => 'End Roll','class' => 'form-control rollend', 'id'=>'rollend')) !!}
                                        </div>
                                        <div class="col-md-2">
                                            {!! Form::text('institute', request()->get('institute'), array('placeholder' => 'Exam Institute','class' => 'form-control')) !!}
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" name="search" value="q" class="btn btn-primary btn-lg float-end" title="Search">Submit</button>
                                        </div>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                    </div>

                </div>
                    <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="card mb-2 border">
                            <div class="card-header bg-soft-success text-black-50 font-size-17 font-bold font-weight-bold">
                                Seat Plan List
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                {!! Form::open(['route' => array('seatPlan'), 'files' => false, 'method'=>'get']) !!}
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                {!! Form::select('job_cercularID',$jobID,request()->get('job_cercularID'),['class'=>'form-control select2','placeholder'=>'Select Job ID','required'=>true, 'id'=>'cercularID_exam']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            {!! Form::select('job_id',$jobs,request()->get('job_id'),['class'=>'form-control select2','placeholder'=>'Select Job', 'id'=>'job_idsearch']) !!}
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" name="search" value="q" class="btn btn-primary btn-lg float-end" title="Search">Search</button>
                                        </div>
                                    </div>

                                {!! Form::close() !!}
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead class="table-info">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">পদের নাম</th>
                                        <th scope="col">প্রার্থীর  নাম  ও পিতার নাম</th>
                                        <th scope="col">কোড</th>
                                        <th scope="col">রোল</th>
                                        <th scope="col">পরীক্ষার স্থান</th>
                                        <th scope="col">তারিখ</th>
                                        <th scope="col">সময়</th>
                                        <th scope="col">Action</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($applicationinfos as $applicant)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration + $applicationinfos->firstItem() - 1 }}</th>
                                        <td>
                                            <span title="{{ $applicant->job ? $applicant->job->title:'' }}">{!! Str::words($applicant->job ? $applicant->job->title:'', 5, ' ...') !!}</span>
                                        </td>
                                        <td>
                                            {{ $applicant->name_bn }}<br />
                                            {{ $applicant->father_name }}
                                        </td>
                                        <td>{{ $applicant->code }}</td>
                                        <td>{{ $applicant->apliyedJob ? $applicant->apliyedJob->roll:'' }}</td>
                                        <td>{{ $applicant->apliyedJob ? $applicant->apliyedJob->exam_hall:'' }}</td>
                                        <td>{{ $applicant->apliyedJob ? $applicant->apliyedJob->exam_date:'' }}</td>
                                        <td>{{ $applicant->apliyedJob ? $applicant->apliyedJob->exam_time:'' }}</td>
                                        <td> <a href="{{ route('print',$applicant->id) }}" target="_blank" title="Print Details" class="btn btn-sm btn-primary"><i data-feather="printer"></i></a>
                                            <a href="{{ route('adminCard',$applicant->id) }}" target="_blank"  title="Admin Card" class="btn btn-sm btn-primary"><i data-feather="credit-card"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach

                                    </tbody>

                                </table>
                        </div>

                    </div>

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

            $('#job_id').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                console.log(valueSelected);
                $('#rollstart').val('');
                $('#rollend').val('');
                $.ajax({
                    url: "{{ route('seatPlansettingRoll') }}",
                    type: "POST",
                    data: {
                        "job_id": valueSelected,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (data) {

                        console.log(data.data);
                        $('#rollstart').val(data.data.rollStart);
                        $('#rollend').val(data.data.rollEnd);
                    }
                })

            });

            $(document).on('change', '#job_cercularID_exam', function () {
                var cercularID = $(this).val();
                var token = "{{ csrf_token()}}";
                $.ajax({
                    type: 'POST',
                    url: "{{ route('Applicantjoblist') }}",
                    data: {'cercularID': cercularID, _token: token},
                    success: function (data) {
                        $("#job_id").empty();
                        console.log(data);
                        $.each(data, function (index, value) {
                            $("<option/>", {
                                value: value.id,
                                text: value.title
                            }).appendTo('#job_id');
                        });

                        console.log(data);
                    }
                });
            });
            $(document).on('change', '#cercularID_exam', function () {
                var cercularID = $(this).val();
                var token = "{{ csrf_token()}}";
                $.ajax({
                    type: 'POST',
                    url: "{{ route('Applicantjoblist') }}",
                    data: {'cercularID': cercularID, _token: token},
                    success: function (data) {
                        $("#job_idsearch").empty();
                        console.log(data);
                        $.each(data, function (index, value) {
                            $("<option/>", {
                                value: value.id,
                                text: value.title
                            }).appendTo('#job_idsearch');
                        });

                        console.log(data);
                    }
                });
            });



        });
    </script>

@endsection
