<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ১/৪/২৩
 * Time: ৮:১৯ PM
 * Copyright jibon <jibon.bikash@gmail.com>
 */
?>
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header fw-bold">
                    Applicant Copy Print
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => array('PrintCopy'), 'files' => true, 'method' => 'get']) !!}
                    <div class="input-group mb-3">
                        {!! Form::text('applied_code', request()->get('applied_code'), array('placeholder' => 'Applied Code','class' => 'form-control')) !!}
                        <button class="btn btn-primary" type="submit" id="button-addon2"><i data-feather="search"></i></button>
                    </div>
                    {!! Form::close() !!}

                    @if($applicationinfo)
                    <a class="btn btn-success" role="button" href="{{route('applicationPrint', ['uuid' => $applicationinfo->uuid])}}" target="_blank">
                  <strong> Print CV <i data-feather="external-link"></i></strong>
                    </a>
                    @else
                    @if( request()->get('applied_code') )
                    <div class="text-wrap text-center fs-2 text-danger" style="width: 100%;">
                        No Result Found.
                      </div>
                @endif

                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

