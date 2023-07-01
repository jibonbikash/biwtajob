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
@section('title', 'Roll & Date Time Setting')

@section('content')
    <div class="row page-title align-items-center">
        <div class="col-md-3 col-xl-6">
            <h4 class="mb-1 mt-0">Roll & Date Time Setting</h4>
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

                                <div class="card-body">
                                
                                    {!! Form::open(['route' => array('rollSettingconfigure'), 'files' => false, 'method'=>'POST']) !!}
                                    <div class="row">
                                        <div class="col-md-3">
                                            {!! Form::select('job_id',$jobs,request()->get('job_id'),['class'=>'form-control select2','placeholder'=>'Select Job']) !!}
                                        </div>
                                        <div class="col-md-2">
                                            {!! Form::text('rollstart', request()->get('rollstart'), array('placeholder' => 'Roll Start From','class' => 'form-control')) !!}
                                        </div>
                                        <div class="col-md-2">
                                            {!! Form::text('examdate', request()->get('examdate'), array('placeholder' => 'Exam Date','class' => 'form-control')) !!}
                                        </div>
                                        <div class="col-md-2">
                                            {!! Form::text('examtime', request()->get('examtime'), array('placeholder' => 'Exam Time','class' => 'form-control')) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" name="search" value="q" class="btn btn-primary btn-lg float-end" title="Search">Submit</button>
                                        </div>
                                    </div>   
                                    {!! Form::close() !!}
                                </div>
                            </div>
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



        });
    </script>

@endsection
