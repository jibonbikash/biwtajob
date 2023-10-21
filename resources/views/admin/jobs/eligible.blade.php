<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ১৮/১০/২৩
 * Time: ১১:৪৪ PM
 * Copyright jibon <jibon.bikash@gmail.com>
 */
?>
@extends('layouts.vertical')
@section('title', 'Eligible List')

@section('content')
    <div class="row page-title align-items-center">
        <div class="col-md-3 col-xl-6">
            <h4 class="mb-1 mt-0">Applicant Eligible List</h4>
        </div>
        <div class="col-md-9 col-xl-6 text-md-right">
            <div class="mt-4 mt-md-0">
                <a class="btn btn-primary" href="{{ route('dashboard') }}"> <i data-feather="arrow-left-circle" class="icon-dual text-white"></i> Dashboard</a>
                <a class="btn btn-info" href="{{ route('exportApplicants') }}??job_id={{ app('request')->input('job_id') }}&q={{ app('request')->input('q') }}&code={{ app('request')->input('code') }}&gender={{ app('request')->input('gender') }}&religion={{ app('request')->input('religion') }}&minimum_age={{ app('request')->input('minimum_age') }}&maximum_age={{ app('request')->input('maximum_age') }}&experience={{ app('request')->input('experience') }}&certification={{ app('request')->input('certification') }}&quota={{ app('request')->input('quota') }}
                "> <i data-feather="download" class="icon-dual text-white"></i> Export</a>
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
                {!! Form::open(['route' => array('applicant.eligible'), 'files' => false, 'method'=>'get']) !!}
                <div class="row mt-1 mb-3 ml-1">
                    <div class="col-md-4">
                        {!! Form::select('job_cercularID',$jobs,request()->get('job_cercularID'),['class'=>'form-control select2','placeholder'=>'Select Job','id'=>'job_cercular']) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::select('job_id',$jobAll,request()->get('job_id'),['class'=>'form-control select2','placeholder'=>'Select Job','id'=>'job_id_cercular']) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('q', request()->get('q'), array('placeholder' => 'Applicant Name, Mobile, email','class' => 'form-control')) !!}
                    </div>
                </div>
                    <div class="row mt-1 mb-3 ml-1">
                    <div class="col-md-4">
                        {!! Form::text('code', request()->get('code'), array('placeholder' => 'code, roll, transaction id','class' => 'form-control')) !!}
                    </div>


                    <div class="col-md-4">
                        {!! Form::select('gender',\App\Helpers\StaticValue::GENDER,request()->get('gender'),['class'=>'form-control select2','placeholder'=>'Gender']) !!}
                    </div>

                    <div class="col-md-4">
                        {!! Form::select('religion',\App\Helpers\StaticValue::RELIGIONS,request()->get('religion'),['class'=>'form-control select2','placeholder'=>'Religion']) !!}
                    </div>

                </div>
                <div class="row mt-1 mb-3 ml-1">

                    <div class="col-md-4">
                        {!! Form::text('minimum_age', request()->get('minimum_age'), array('placeholder' => 'Minimum Age','class' => 'form-control')) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('maximum_age', request()->get('maximum_age'), array('placeholder' => 'Maximum Age','class' => 'form-control')) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('experience', request()->get('experience'), array('placeholder' => 'Experience','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="row mt-1 mb-3 ml-1">
                    <div class="col-md-4">
                        @php
                            $crtificates = \App\Models\Crtificate::pluck('name','id')
                          ->all();
                        @endphp
                        {!! Form::select('certification',$crtificates,request()->get('certification'),['class'=>'form-control','placeholder'=>'Certification','id'=>'Certification']) !!}

                    </div>
                    <div class="col-md-4">
                        {!! Form::select('quota',\App\Helpers\StaticValue::QTOTA,request()->get('quota'),['class'=>'form-control','placeholder'=>'Quota','id'=>'quota']) !!}
                    </div>


                    <div class="col-md-4">
                        <button type="submit" name="search" value="q" class="btn btn-success btn-lg float-end" title="Search"><i data-feather="search"></i></button>
                        @if (request()->input('search')=='q')
                            <a href="{{ route('applicant.eligible') }}" class="btn btn-warning btn-lg" title="Reset"><i data-feather="refresh-cw" class="text-white"></i></a>
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
                                <th scope="col">কোড</th>
                                <th scope="col">জেন্ডার</th>
                                <th scope="col">স্থায়ী  ঠিকানা</th>
                                <th scope="col">মোবাইল</th>
                                <th scope="col">জন্ম তারিখ  ও বয়স</th>
                                <th scope="col">পেমেন্ট আইডি</th>
                                <th scope="col">নিজ জেলা</th>
                                <th scope="col">শিক্ষাগত যোগ্যতা</th>
                                <th scope="col">সংশ্লিষ্ট ক্ষেত্রে অভিজ্ঞতা</th>
                                <th scope="col">অভিজ্ঞতার  বিবরণ</th>
                                <th scope="col">অভিজ্ঞতার মেয়াদ</th>
                                <th scope="col">কোটা</th>
                                <th scope="col">বিভাগীয়</th>
                                <th scope="col">পরীক্ষার সময়</th>
                                <th scope="col">রোল</th>
                                <th scope="col">Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($applicants as $applicant)
                                <tr>
                                    <th scope="row">{{ $loop->iteration + $applicants->firstItem() - 1 }}</th>
                                    <td>
                                        <span title="{{ $applicant->job ? $applicant->job->title:'' }}">{!! Str::words($applicant->job ? $applicant->job->title:'', 5, ' ...') !!}</span>

                                    </td>

                                    <td>{{ $applicant->name_bn }}<br />
                                        {{ $applicant->father_name }}
                                    </td>
                                    <td>{{ $applicant->code }}</td>
                                    <td>{{ $applicant->gender }}</td>
                                    <td>
                                        বাসা ও সড়ক (নাম/নম্বর): {{ $applicant->pr_house }},
                                        গ্রাম/পাড়া/মহল্লা: {{ $applicant->pr_village }},
                                        ইউনিয়ন/ওয়ার্ড: {{ $applicant->pr_union }},
                                        ডাকঘর: {{ $applicant->pr_postoffice }},
                                        পোস্টকোড: {{ $applicant->pr_postcode }},
                                        উপজেলা /থানা:{{ $applicant->permanentupozilla ? $applicant->permanentupozilla->upozilla:'' }},
                                        জেলা: {{ $applicant->permanentzila ? $applicant->permanentzila->zilla_name:'' }}

                                        {{--                                উপজেলা: {{ $applicant->permanentupozilla ? $applicant->permanentupozilla->upozilla:'' }},--}}
                                        {{--                                জেলা: {{ $applicant->permanentzila ? $applicant->permanentzila->zilla_name:'' }},--}}
                                    </td>
                                    <td>{{ $applicant->mobile }} </td>
                                    <td>
                                        {{ Carbon\Carbon::parse($applicant->bday)->format('F j, Y') }} <br />
                                            <?php
                                            $fixedday = Carbon\Carbon::parse($applicant->age_calculation)->format('F j, Y');
                                            $fixeddaycal = date('d-m-Y', strtotime($fixedday));
                                            $datetime1 = new DateTime($fixeddaycal);
                                            $datetime2 = new DateTime($applicant->bday);
                                            $interval = $datetime1->diff($datetime2);
                                            //  echo $fixedday. ' তারিখে : ';
                                            echo $interval->format('%y বছর %m মাস এবং %d দিন');
                                            ?>
                                    </td>
                                    <td>{{ $applicant->apliyedJob ? $applicant->apliyedJob->token:'' }}</td>
                                    <td>
                                        {{ $applicant->birthplace ? $applicant->birthplace->zilla_name:'' }}
                                        {{--                                 {{ $applicant->permanentzilla_name }}--}}
                                    </td>
                                    <td>
                                        @foreach($applicant->educations as $education)
                                            পরীক্ষার নাম: {{ $education->examLevelGroups ? $education->examLevelGroups->name :'---' }} <br />
                                            বিষয়:  @if ($education->other)
                                                {{ $education->other }}
                                            @else
                                                {{ $education->ExamlevelSubject ? $education->ExamlevelSubject->name :'' }}<br />
                                            @endif
                                        @endforeach

                                    </td>
                                    <td>{{ $applicant->experience }}</td>
                                    <td>{{ $applicant->experiencemonth }}</td>
                                    <td>{{ $applicant->experienceyear }}</td>
                                    <td>
                                            <?php
                                            if($applicant->quota){
                                                $dbValue = $applicant->quota;
                                                $myArray = json_decode($dbValue, true);
                                                foreach ($myArray as $key => $value) {
                                                    echo $value.'<br />';
                                                }
                                            }
                                            ?>

                                    </td>
                                    <td>{{ $applicant->division_appli }}</td>
                                    <td>
                                        @if($applicant->apliyedJob)
                                            রোল:{{ $applicant->apliyedJob->roll }},
                                            {{ $applicant->apliyedJob->exam_hall }},
                                            {{ $applicant->apliyedJob->exam_date }}
                                            {{ $applicant->apliyedJob->exam_time }}

                                        @endif
                                    </td>
                                    <td>
                                        {{ $applicant->apliyedJob->roll }}
                                    </td>
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
                    <h5 class="modal-title" id="exampleModalLabel">Import Eligible List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => array('Applicantimport'), 'files' => true, 'method'=>'POST']) !!}
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
@section('script-bottom')
    <style>
        .select2-container .select2-selection--multiple .select2-selection__choice{
            background-color: #5369f8 !important;
        }
        .select2-container .select2-selection--single{
            height: 43px !important;
            padding-top: 5px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 7px !important;

    </style>

    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/multiselect/multi-select.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/multiselect/multiselect.min.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            $('.select2').select2({
                placeholder: 'নির্বাচন করুন',
                allowClear: true
            });
            $(document).on('change', '#job_cercular',function(){
                var cercularID = $(this).val();
                var token = "{{ csrf_token()}}";
                $.ajax({
                    type:'POST',
                    url:"{{ route('Applicantjoblist') }}",
                    data:{'cercularID':cercularID, _token:token},
                    success:function(data){
                        $("#job_id_cercular").empty();
                        console.log(data);
                        $.each(data,function(index,value){
                            $("<option/>", {
                                value: value.id,
                                text: value.title
                            }).appendTo('#job_id_cercular');
                        });

                        console.log(data);
                    }
                });
            });

        });
    </script>

@endsection

