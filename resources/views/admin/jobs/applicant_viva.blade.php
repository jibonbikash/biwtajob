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
            <h4 class="mb-1 mt-0">Applicant List(Viva)</h4>
        </div>
        <div class="col-md-9 col-xl-6 text-md-right">
            <div class="mt-4 mt-md-0">
                <a class="btn btn-primary" href="{{ route('dashboard') }}"> <i data-feather="arrow-left-circle" class="icon-dual text-white"></i> Dashboard</a>
                <a class="btn btn-info" href="{{ route('ApplicantVivaexport') }}??job_id={{ app('request')->input('job_id') }}"> <i data-feather="download" class="icon-dual text-white"></i> Export</a>
                <a class="btn btn-warning" href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"> <i data-feather="upload" class="icon-dual text-white"></i> Import</a>


            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="card mb-2">
                <div class="card-header bg-primary text-white font-size-17 font-bold font-weight-bold">
                Search
                </div>
     {!! Form::open(['route' => array('ApplicantViva'), 'files' => false, 'method'=>'get']) !!}
<div class="row mt-1 mb-3">
    <div class="col-md-4">
        {!! Form::select('job_id',$jobs,request()->get('job_id'),['class'=>'form-control select2','placeholder'=>'Select Job']) !!}
    </div>
    <div class="col-md-8">
        <button type="submit" name="search" value="q" class="btn btn-success btn-lg float-end" title="Search"><i data-feather="search"></i></button>
        @if (request()->input('search')=='q')
            <a href="{{ route('ApplicantViva') }}" class="btn btn-warning btn-lg" title="Reset"><i data-feather="refresh-cw" class="text-white"></i></a>
        @endif
    </div>
</div>

               {!! Form::close() !!}
            </div>

            <div class="card">
                <div class="card-body">
                    @include('layouts.shared.message')
                    <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-info">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">পদের নাম</th>
                            <th scope="col">প্রার্থীর  নাম  ও পিতার নাম</th>
                            <th scope="col">জেন্ডার</th>
                            <th scope="col">স্থায়ী  ঠিকানা</th>
                            <th scope="col">মোবাইল</th>
                            <th scope="col">নিজ জেলা</th>
                            <th scope="col">শিক্ষাগত যোগ্যতা</th>
                            <th scope="col">সংশ্লিষ্ট ক্ষেত্রে অভিজ্ঞতা</th>
                            <th scope="col">অভিজ্ঞতার  বিবরণ</th>
                            <th scope="col">অভিজ্ঞতার মেয়াদ</th>
                            <th scope="col">কোটা</th>
                            <th scope="col">বিভাগীয়</th>
                            <th scope="col">Action</th>

                        </tr>
                        </thead>
                        <tbody>
@foreach($applicants as $applicant)
    <tr>
        <td scope="row">{{ $loop->iteration + $applicants->firstItem() - 1 }}</td>
        <td>
            <span title="{{ $applicant->job ? $applicant->job->title:'' }}">{!! Str::words($applicant->job ? $applicant->job->title:'', 5, ' ...') !!}</span>
        </td>
        <td>
            {{ $applicant->applicant ? $applicant->applicant->name_bn:'' }}<br />
            {{ $applicant->applicant ? $applicant->applicant->father_name:'' }}
        </td>
        <td>
            {{ $applicant->applicant ? $applicant->applicant->gender:'' }}
        </td>
        <td>স্থায়ী  ঠিকানা</td>
        <td>
            {{ $applicant->applicant ? $applicant->applicant->mobile:'' }}
        </td>
        <td>
            {{ $applicant->applicant->birthplace ? $applicant->applicant->birthplace->zilla_name :'' }}

        </td>
        <td>
            @foreach($applicant->applicant->educations as $education)
                পরীক্ষার নাম: {{ $education->examLevelGroups ? $education->examLevelGroups->name :'---' }} <br />
                বিষয়:  @if ($education->other)
                    {{ $education->other }}
                @else
                    {{ $education->ExamlevelSubject ? $education->ExamlevelSubject->name :'' }}<br />
                @endif
            @endforeach
        </td>
        </td>
        <td>{{ $applicant->applicant->experience }}</td>
        <td>{{ $applicant->applicant->experiencemonth }}</td>
        <td>{{ $applicant->applicant->experienceyear }}</td>
        <td>
                <?php
                if($applicant->applicant->quota){
                    $dbValue = $applicant->applicant->quota;
                    $myArray = json_decode($dbValue, true);
                    foreach ($myArray as $key => $value) {
                        echo $value.'<br />';
                    }
                }
                ?>
        </td>
        <td>{{ $applicant->applicant->division_appli }}</td>
        <td>
            <a href="{{ route('print',$applicant->id) }}" target="_blank" title="Print Details" class="btn btn-sm btn-primary"><i data-feather="printer"></i></a>
            <a href="{{ route('adminCard',$applicant->id) }}" target="_blank"  title="Admin Card" class="btn btn-sm btn-primary"><i data-feather="credit-card"></i></a>


        </td>

    </tr>

@endforeach
                        </tbody>
                    </table>
                    </div>
                    {{ $applicants->onEachSide(5)->appends(Request::all())->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Applicant List(Viva)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => array('ApplicantVivaimport'), 'files' => true, 'method'=>'POST']) !!}
                    @include('admin.jobs._commonForm',['jobs'=>$jobs])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
                {!! Form::close() !!}
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
