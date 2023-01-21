<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ৫/৩/২১
 * Time: ১০:৫৭ PM
 * Copyright jibon <jibon.bikash@gmail.com>
 */
?>
@extends('layouts.vertical')


@section('content')

    <div class="row page-title align-items-center">
        <div class="col-md-3 col-xl-6">
            <h4 class="mb-1 mt-0">Edit New User</h4>
        </div>
        <div class="col-md-9 col-xl-6 text-md-right">
            <div class="mt-4 mt-md-0">
                <a class="btn btn-primary" href="{{ route('admin.users.index') }}"> <i data-feather="arrow-left-circle"></i>Back</a>

            </div>
        </div>
    </div>

    <div class="card">
        <h5 class="card-header"></h5>
        <div class="card-body">
            @include('layouts.shared.message')
            {!! Form::model($user, ['method' => 'PATCH','route' => ['admin.users.update', $user->id]]) !!}
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-7 col-sm-12 col-md-7">
                    <div class="form-group">
                        <strong>National ID:</strong>
                        {!! Form::text('nid_no', null, array('placeholder' => 'NID','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-7 col-sm-12 col-md-7">
                    <div class="form-group">
                        <strong>Mobile No:</strong>
                        {!! Form::text('phone_no', null, array('placeholder' => 'Mobile No','class' => 'form-control')) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Password:</strong>
                        {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Confirm Password:</strong>
                        {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Role:</strong>
                        {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-left">
                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>


@endsection
