<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ২২/৭/২১
 * Time: ৯:৫২ PM
 * Copyright jibon <jibon.bikash@gmail.com>
 */
?>
@extends('layouts.vertical')
@section('title', 'Password Change')

@section('content')
    <div class="row page-title align-items-center">
        <div class="col-md-3 col-xl-6">
            <h4 class="mb-1 mt-0">Password Change</h4>
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
                    {!! Form::open(array('route' => 'admin.changeed_password','method'=>'POST')) !!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password" >Current Password</label> <span class="font-weight-bold text-danger">*</span>
                                <input id="password" type="password" class="form-control form-control-lg" autofocus name="current_password" autocomplete="current-password">
                            </div>
                        </div>
                        <div class="clearfix d-block"></div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password" >New Password</label><span class="font-weight-bold text-danger">*</span>
                                <input id="new_password" type="password" class="form-control form-control-lg" name="new_password" autocomplete="current-password">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password" >New Confirm Password</label><span class="font-weight-bold text-danger">*</span>
                                <input id="new_confirm_password" type="password" class="form-control form-control-lg" name="new_confirm_password" autocomplete="current-password">
                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">
                                    Update Password
                                </button>
                            </div>
                        </div>


                    </div>
                    {!! Form::close() !!}
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
