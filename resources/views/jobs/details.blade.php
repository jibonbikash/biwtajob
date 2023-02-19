<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ৩/২/২৩
 * Time: ৮:১১ PM
 * Copyright jibon <jibon.bikash@gmail.com>
 */
?>
@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-bordered">

            <tbody>
            <tr>
                <th scope="row">Title</th>
                <td>{{$job->title}}</td>
            </tr>
            <tr>
                <th scope="row">Application Fee</th>
                <td><span class="badge bg-primary rounded-pill">{{$job->apply_fee}}</span> BDT</td>
            </tr>
            <tr>
                <th scope="row">No. of Vacancies</th>
                <td>{{$job->vacancies}}</td>
            </tr>

           <tr>
                <th scope="row">Application Deadline</th>
                <td>{{ Carbon\Carbon::parse($job->application_deadline)->format('F j, Y') }}</td>
            </tr>
            <tr>
                <th scope="row" class="align-top">Job Description / Responsibility</th>
                <td>{!! $job->description !!}</td>
            </tr>

            </tbody>
            <tfoot>
            <tr>
                <td colspan="2">
                    <div class="float-end">
                        <a class="btn btn-primary btn-lg" href="{{ route('applyform',['uuid'=>$job->uuid]) }}"> Apply  <i data-feather="arrow-right-circle"></i> </a>
                    </div>

                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
