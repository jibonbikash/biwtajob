<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ৮/৩/২৩
 * Time: ৯:১৪ PM
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
            <h4 class="mb-1 mt-0">Exam Levels group add </h4>
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
                            <strong>Exam Levels: {{ $examLevel->name }}</strong>
                            {!! Form::open(array('route' => ['examlevels.groupaddsave', $examLevel->id] ,'method'=>'POST', 'files' => false)) !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Name</strong>
                                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>Job Description</strong>
                                        {!! Form::select('status',\App\Helpers\StaticValue::STATUS,null,['class'=>'form-control','placeholder'=>'Select ']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-lg"><i data-feather="save"></i> Save</button>
                                    </div>
                                </div>

                            </div>
                            {!! Form::close() !!}

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

