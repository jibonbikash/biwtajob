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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /*.select2{*/
        /*    width: 100%;*/
        /*}*/
        .select2-container .select2-selection--single{
            min-height: 40px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow{
            top: 5px;
        }
        /*.select2-container--default .select2-selection--single{*/
        /*    border: var(--bs-border-width) solid var(--bs-border-color);*/
        /*    width: 100%;*/
        /*}*/

    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    Application Form
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="alert alert-primary" role="alert">
                            আবেদন এর জন্য নিম্নে উল্লেখিত ফর্মটি অবশ্যই বাংলা ইউনিকোড ফন্টে পূরণ করতে হবে৷ শুধুমাত্র নিজ
                            নাম বাংলা এবং ইংরেজীতে লিখতে হবে। অন্যথায় আপনার আবেদনটি বাতিল হয়ে যাবে । বাংলা ইউনিকোড ফন্টে
                            টাইপ করার জন্য এই লিংকটিতে (http://www.google.com/intl/bn/inputtools/try/) ক্লিক করুন৷ অথবা
                            আপনার কম্পিউটার এ গুগল ইনপুট টুলস এর মাধ্যমে ইউনিকোডে বাংলা টাইপিং প্রক্রিয়া ইনস্টল করার
                            জন্য এই লিঙ্কটিতে যান (http://www.google.com/intl/bn/inputtools/windows/) ৷ এছাড়াও আপনি অভ্র
                            অথবা যেকোনো বাংলা ইউনিকোড ফন্টে এই ফর্মটি পূরণ করতে পারেন।চাকুরীর জন্য আবেদন ফর্মটি সাবমিট
                            করার পর যে Applied ID টি দেয়া হবে সেটা সংরক্ষণ করে রাখুন। পরিবর্তিতে সকল ক্ষেত্রে এই নম্বর
                            টি দরকার হবে।
                        </div>
                        <div class="col-md-2 fw-bold">পদের নাম</div>
                        <div class="col-md-10">
                            {{$job->title}}
                        </div>
                        <div class="col-md-2 fw-bold">নিয়োগ বিজ্ঞপ্তি নম্বর</div>
                        <div class="col-md-10">
                            {{$job->job_id}}
                        </div>

                        <div class="col-md-2 fw-bold">বিজ্ঞপ্তি তারিখ</div>
                        <div class="col-md-10">
                            {{$job->jobcurbday ? $job->jobcurbday:''}}
                        </div>


                    </div>
                    {!! Form::open(['route' => array('jobApply'), 'files' => true]) !!}
                    {!! Form::hidden('uuid', $uuid) !!}
                    {!! Form::hidden('jobcurday', $job->jobcurbday ? $job->jobcurbday:'') !!}
                    <?php
        if($job->min_education_con){
            echo Form::hidden('min_education_con', $job->min_education_con);
        }
                    ?>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            @include('layouts.shared.message')
                            <div class="card">
                                <div class="card-header bg-secondary fw-bold text-white">
                                    ব্যক্তিগত তথ্য
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <td>প্রার্থীর নাম ইংরেজীতে (বড় অক্ষরে) <span class="text-danger">*</span> </td>
                                            <td> {!! Form::text('name_en', null, array('placeholder' => '','class' => 'form-control')) !!}
                                                @if ($errors->has('name_en'))
                                                    <span class="text-danger">{{ $errors->first('name_en') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>প্রার্থীর নাম বাংলায় <span class="text-danger">*</span></td>
                                            <td> {!! Form::text('name_bn', null, array('placeholder' => '','class' => 'form-control')) !!}
                                                @if ($errors->has('name_bn'))
                                                    <span class="text-danger">{{ $errors->first('name_bn') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>পিতার নাম <span class="text-danger">*</span></td>
                                            <td>{!! Form::text('father_name', null, array('placeholder' => '','class' => 'form-control')) !!}
                                                @if ($errors->has('father_name'))
                                                    <span class="text-danger">{{ $errors->first('father_name') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>মাতার নাম <span class="text-danger">*</span></td>
                                            <td>{!! Form::text('mother_name', null, array('placeholder' => '','class' => 'form-control')) !!}
                                                @if ($errors->has('mother_name'))
                                                    <span class="text-danger">{{ $errors->first('mother_name') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>জন্ম তারিখ <span class="text-danger">*</span></td>
                                            <td>{!! Form::text('date_of_birth', null, array('placeholder' => '','class' => 'form-control', 'id'=>'date_of_birth')) !!}
                                                @if ($errors->has('date_of_birth'))
                                                    <span class="text-danger">{{ $errors->first('date_of_birth') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>মোবাইল/টেলিফোন নম্বর <span class="text-danger">*</span></td>
                                            <td> {!! Form::text('mobile_no', null, array('placeholder' => '','class' => 'form-control',)) !!}
                                                @if ($errors->has('mobile_no'))
                                                    <span class="text-danger">{{ $errors->first('mobile_no') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>জাতীয় পরিচয় নম্বর <span class="text-danger">*</span></td>
                                            <td> {!! Form::text('nid', null, array('placeholder' => '','class' => 'form-control',)) !!}
                                                @if ($errors->has('nid'))
                                                    <span class="text-danger">{{ $errors->first('nid') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>জাতীয়তা <span class="text-danger">*</span></td>
                                            <td> {!! Form::select('nationality',\App\Helpers\StaticValue::NATIONALITY,null,['class'=>'form-control select2','placeholder'=>'']) !!}
                                                @if ($errors->has('nationality'))
                                                    <span class="text-danger">{{ $errors->first('nationality') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>ধর্ম <span class="text-danger">*</span></td>
                                            <td> {!! Form::select('religion',\App\Helpers\StaticValue::RELIGIONS,null,['class'=>'form-control select2','placeholder'=>'']) !!}
                                                @if ($errors->has('religion'))
                                                    <span class="text-danger">{{ $errors->first('religion') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>জেন্ডার <span class="text-danger">*</span></td>
                                            <td> {!! Form::select('gender',\App\Helpers\StaticValue::GENDER,null,['class'=>'form-control select2','placeholder'=>'']) !!}
                                                @if ($errors->has('gender'))
                                                    <span class="text-danger">{{ $errors->first('gender') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>জন্ম স্থান (জেলা)<span class="text-danger">*</span></td>
                                            <td> {!! Form::select('date_of_place',[],null,['class'=>'form-control select2','placeholder'=>'', 'id'=>'date_of_place']) !!}
                                                @if ($errors->has('date_of_place'))
                                                    <span class="text-danger">{{ $errors->first('date_of_place') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>পেশা</td>
                                            <td>{!! Form::text('occupation', null, array('placeholder' => '','class' => 'form-control')) !!}
                                                @if ($errors->has('occupation'))
                                                    <span class="text-danger">{{ $errors->first('occupation') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header fw-bold bg-secondary text-white">বর্তমান ঠিকানা</div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <td>বাসা ও সড়ক (নাম/নম্বর)</td>
                                            <td> {!! Form::text('present_house_no', null, array('placeholder' => '','class' => 'form-control','id'=>'present_house_no')) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>গ্রাম/পাড়া/মহল্লা</td>
                                            <td> {!! Form::text('present_village', null, array('placeholder' => '','class' => 'form-control','id'=>'present_village')) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>ইউনিয়ন/ওয়ার্ড</td>
                                            <td> {!! Form::text('present_union', null, array('placeholder' => '','class' => 'form-control','id'=>'present_union')) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>ডাকঘর <span class="text-danger">*</span></td>
                                            <td> {!! Form::text('present_postoffice', null, array('placeholder' => '','class' => 'form-control','id'=>'present_postoffice')) !!}
                                                @if ($errors->has('present_postoffice'))
                                                    <span class="text-danger">{{ $errors->first('present_postoffice') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>পোস্টকোড নম্বর <span class="text-danger">*</span></td>
                                            <td> {!! Form::text('present_postcode', null, array('placeholder' => '','class' => 'form-control','id'=>'present_postcode')) !!}
                                                @if ($errors->has('present_postcode'))
                                                    <span class="text-danger">{{ $errors->first('present_postcode') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>জেলা <span class="text-danger">*</span></td>
                                            <td>
                                                {!! Form::select('present_zilla',[],null,['class'=>'form-control present_zilla select2','placeholder'=>'','id'=>'present_zilla']) !!}
                                                @if ($errors->has('present_zilla'))
                                                    <span class="text-danger">{{ $errors->first('present_zilla') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>উপজেলা/থানা <span class="text-danger">*</span></td>
                                            <td>
                                                {!! Form::select('present_upozilla',[],null,['class'=>'form-control present_upozilla select2','placeholder'=>'','id'=>'present_upozilla']) !!}
                                                @if ($errors->has('present_upozilla'))
                                                    <span class="text-danger">{{ $errors->first('present_upozilla') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-secondary fw-bold text-white">স্থায়ী ঠিকানা <input class="checkbox ispresent"  name="ispresent"  type="checkbox"> বর্তমান ঠিকানা ও স্থায়ী ঠিকানা একই হলে টিক দিন</div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <td>বাসা ও সড়ক (নাম/নম্বর)</td>
                                            <td> {!! Form::text('permanent_house_no', null, array('placeholder' => '','class' => 'form-control','id'=>'permanent_house_no')) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>গ্রাম/পাড়া/মহল্লা</td>
                                            <td> {!! Form::text('permanent_village', null, array('placeholder' => '','class' => 'form-control','id'=>'permanent_village')) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>ইউনিয়ন/ওয়ার্ড</td>
                                            <td> {!! Form::text('permanent_union', null, array('placeholder' => '','class' => 'form-control','id'=>'permanent_union')) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>ডাকঘর <span class="text-danger">*</span></td>
                                            <td> {!! Form::text('permanent_postoffice', null, array('placeholder' => '','class' => 'form-control','id'=>'permanent_postoffice')) !!}
                                                @if ($errors->has('permanent_postoffice'))
                                                    <span class="text-danger">{{ $errors->first('permanent_postoffice') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>পোস্টকোড নম্বর <span class="text-danger">*</span></td>
                                            <td> {!! Form::text('permanent_postcode', null, array('placeholder' => '','class' => 'form-control','id'=>'permanent_postcode')) !!}
                                                @if ($errors->has('permanent_postcode'))
                                                    <span class="text-danger">{{ $errors->first('permanent_postcode') }}</span>
                                                @endif</td>
                                        </tr>
                                        <tr>
                                            <td>জেলা <span class="text-danger">*</span></td>
                                            <td>
                                                {!! Form::select('permanent_zilla',[],null,['class'=>'form-control permanent_zilla select2','placeholder'=>'','id'=>'permanent_zilla']) !!}
                                                @if ($errors->has('permanent_zilla'))
                                                    <span class="text-danger">{{ $errors->first('permanent_zilla') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>উপজেলা/থানা <span class="text-danger">*</span></td>
                                            <td>
                                                {!! Form::select('permanent_upozilla',[],null,['class'=>'form-control permanent_upozilla select2','placeholder'=>'','id'=>'permanent_upozilla']) !!}
                                                @if ($errors->has('permanent_upozilla'))
                                                    <span class="text-danger">{{ $errors->first('permanent_upozilla') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-secondary text-white">
                                    শিক্ষাগত যোগ্যতা
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if($job->jsc==1)
                                                <div class="card">
                                                    <div class="card-header bg-secondary text-white">
                                                        অষ্টম শ্রেনী পাস/জে.এস.সি/ সমমান
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3 row">
                                                                    <label for="inputPassword"
                                                                           class="col-sm-4 col-form-label">পরীক্ষার
                                                                        নাম <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-8">
                                                                        @php
                                                                            $jsc = \App\Models\Examlevel::join('examlevel_groups', 'examlevels.id', '=', 'examlevel_groups.examlevel_id')
                                                                          ->where('examlevels.id',1)
                                                                          ->pluck('examlevel_groups.name','examlevel_groups.id')
                                                                          ->all();
                                                                        @endphp
                                                                        {!! Form::select('jscexamlevel',$jsc,null,['class'=>'form-control select2','placeholder'=>'']) !!}
                                                                        @if ($errors->has('jscexamlevel'))
                                                                            <span class="text-danger">{{ $errors->first('jscexamlevel') }}</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3 row">
                                                                    <label for="inputPassword"
                                                                           class="col-sm-4 col-form-label">শিক্ষা প্রতিষ্ঠান <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-8">
                                                                        {!! Form::text('jscinstitute_name', null, array('placeholder' => '','class' => 'form-control')) !!}
                                                                        @if ($errors->has('jscinstitute_name'))
                                                                            <span class="text-danger">{{ $errors->first('jscinstitute_name') }}</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3 row">
                                                                    <label for="inputPassword"
                                                                           class="col-sm-4 col-form-label">গ্রেড/শ্রেণি/বিভাগ <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-8">
                                                                        {!! Form::select('jscresult',\App\Helpers\StaticValue::RESULTJSC,null,['class'=>'select2 form-control','placeholder'=>'','id'=>'jscresult']) !!}
                                                                        @if ($errors->has('jscresult'))
                                                                            <span class="text-danger">{{ $errors->first('jscresult') }}</span>
                                                                        @endif
                                                                        {!! Form::text('jscresult_score', null, array('placeholder' => '','class' => 'form-control jscresult_score is-invalid','style'=>'display:none',)) !!}
                                                                        @if ($errors->has('jscresult_score'))
                                                                            <span class="text-danger">{{ $errors->first('jscresult_score') }}</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3 row">
                                                                    <label for="inputPassword"
                                                                           class="col-sm-4 col-form-label">বোর্ড <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-8">

                                                                        {!! Form::select('jscboard',collect($boards)->where('type',1)->pluck('name','id'),null,['class'=>'select2 form-control','placeholder'=>'']) !!}
                                                                        @if ($errors->has('jscboard'))
                                                                            <span class="text-danger">{{ $errors->first('jscboard') }}</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3 row">
                                                                    <label for="inputPassword"
                                                                           class="col-sm-4 col-form-label">পাসের সন <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-8">
                                                                        {!! Form::number('jscpassyear', null, array('placeholder' => '','class' => 'form-control')) !!}
                                                                        @if ($errors->has('jscpassyear'))
                                                                            <span class="text-danger">{{ $errors->first('jscpassyear') }}</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            @endif

                                                @if($job->ssc==1)
                                                    <div class="card mt-4">
                                                        <div class="card-header bg-secondary text-white">
                                                            এস.এস.সি/ সমমান
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">পরীক্ষার
                                                                            নাম <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            @php
                                                                                $ssc = \App\Models\Examlevel::join('examlevel_groups', 'examlevels.id', '=', 'examlevel_groups.examlevel_id')
                                                                              ->where('examlevels.id',2)
                                                                              ->whereNull('examlevel_groups.deleted_at')
                                                                              ->pluck('examlevel_groups.name','examlevel_groups.id')
                                                                              ->all();
                                                                            @endphp
                                                                            {!! Form::select('sscexamlevel',$ssc,null,['class'=>'select2 form-control','placeholder'=>'','id'=>'sscexamlevel']) !!}
                                                                            @if ($errors->has('sscexamlevel'))
                                                                                <span class="text-danger">{{ $errors->first('sscexamlevel') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">শিক্ষা প্রতিষ্ঠান <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::text('sscinstitute_name', null, array('placeholder' => '','class' => 'form-control')) !!}
                                                                            @if ($errors->has('sscinstitute_name'))
                                                                                <span class="text-danger">{{ $errors->first('sscinstitute_name') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">গ্রেড/শ্রেণি/বিভাগ <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::select('sscresult',\App\Helpers\StaticValue::RESULTSSC,null,['class'=>'select2 form-control','placeholder'=>'','id'=>'sscresult']) !!}
                                                                            @if ($errors->has('sscresult'))
                                                                                <span class="text-danger">{{ $errors->first('sscresult') }}</span>
                                                                            @endif
                                                                            {!! Form::text('sscresult_score', null, array('placeholder' => '','class' => 'form-control sscresult_score is-invalid','style'=>'display:none',)) !!}
                                                                            @if ($errors->has('sscresult_score'))
                                                                                <span class="text-danger">{{ $errors->first('sscresult_score') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">বিষয় <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::select('sscSubject',[],null,['class'=>'form-control sscsubject select2','placeholder'=>'','id'=>'sscsubject']) !!}
                                                                            @if ($errors->has('sscSubject'))
                                                                                <span class="text-danger">{{ $errors->first('sscSubject') }}</span>
                                                                            @endif

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">বোর্ড <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
<?php

?>
                                                                            {!! Form::select('sscboard',collect($boards)->where('type',1)->pluck('name','id'),null,['class'=>'form-control select2','placeholder'=>'']) !!}
                                                                            @if ($errors->has('sscboard'))
                                                                                <span class="text-danger">{{ $errors->first('sscboard') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">পাসের সন <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::number('sscpassyear', null, array('placeholder' => '','class' => 'form-control')) !!}
                                                                            @if ($errors->has('sscpassyear'))
                                                                                <span class="text-danger">{{ $errors->first('sscpassyear') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                @endif

                                                @if($job->hsc==1)
                                                    <div class="card mt-4">
                                                        <div class="card-header bg-secondary text-white">
                                                            এইচএসসি /সমমূল্য
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">পরীক্ষার
                                                                            নাম <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            @php
                                                                                $hsc = \App\Models\Examlevel::join('examlevel_groups', 'examlevels.id', '=', 'examlevel_groups.examlevel_id')
                                                                              ->where('examlevels.id',3)
                                                                              ->pluck('examlevel_groups.name','examlevel_groups.id')
                                                                              ->all();
                                                                            @endphp
                                                                            {!! Form::select('hscexamlevel',$hsc,null,['class'=>'form-control select2','placeholder'=>'', 'id'=>'hscexamlevel']) !!}
                                                                            @if ($errors->has('hscexamlevel'))
                                                                                <span class="text-danger">{{ $errors->first('hscexamlevel') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">শিক্ষা প্রতিষ্ঠান <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::text('hscinstitute_name', null, array('placeholder' => '','class' => 'form-control')) !!}
                                                                            @if ($errors->has('hscinstitute_name'))
                                                                                <span class="text-danger">{{ $errors->first('hscinstitute_name') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">গ্রেড/শ্রেণি/বিভাগ <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::select('hscresult',\App\Helpers\StaticValue::RESULTSSC,null,['class'=>'select2 form-control','placeholder'=>'','id'=>'hscresult']) !!}
                                                                            @if ($errors->has('hscresult'))
                                                                                <span class="text-danger">{{ $errors->first('hscresult') }}</span>
                                                                            @endif
                                                                            {!! Form::text('hscresult_score', null, array('placeholder' => '','class' => 'form-control hscresult_score is-invalid','style'=>'display:none',)) !!}
                                                                            @if ($errors->has('hscresult_score'))
                                                                                <span class="text-danger">{{ $errors->first('hscresult_score') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">বিষয় <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::select('hscubject',[],null,['class'=>'form-control select2 hscubject','placeholder'=>'','id'=>'hscubject']) !!}
                                                                            @if ($errors->has('hscubject'))
                                                                                <span class="text-danger">{{ $errors->first('hscubject') }}</span>
                                                                            @endif

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">বোর্ড <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">

                                                                            {!! Form::select('hscboard',collect($boards)->where('type',1)->pluck('name','id'),null,['class'=>'form-control select2','placeholder'=>'']) !!}
                                                                            @if ($errors->has('hscboard'))
                                                                                <span class="text-danger">{{ $errors->first('hscboard') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">পাসের সন <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::number('hscpassyear', null, array('placeholder' => '','class' => 'form-control')) !!}
                                                                            @if ($errors->has('hscpassyear'))
                                                                                <span class="text-danger">{{ $errors->first('hscpassyear') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                @endif
                                                @if($job->graduation==1)
                                                    <div class="card mt-4">
                                                        <div class="card-header bg-secondary text-white">
                                                            স্নাতক ডিগ্রী
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">পরীক্ষার
                                                                            নাম <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            @php
                                                                                $graduation = \App\Models\Examlevel::join('examlevel_groups', 'examlevels.id', '=', 'examlevel_groups.examlevel_id')
                                                                              ->where('examlevels.id',4)
                                                                              ->pluck('examlevel_groups.name','examlevel_groups.id')
                                                                              ->all();
                                                                            @endphp
                                                                            {!! Form::select('graduationexamlevel',$graduation,null,['class'=>'select2 form-control','placeholder'=>'','id'=>'graduationexamlevel']) !!}
                                                                            @if ($errors->has('graduationexamlevel'))
                                                                                <span class="text-danger">{{ $errors->first('graduationexamlevel') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">শিক্ষা প্রতিষ্ঠান <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::text('graduationinstitute_name', null, array('placeholder' => '','class' => 'form-control')) !!}
                                                                            @if ($errors->has('graduationinstitute_name'))
                                                                                <span class="text-danger">{{ $errors->first('graduationinstitute_name') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">গ্রেড/শ্রেণি/বিভাগ <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::select('graduationresult',\App\Helpers\StaticValue::RESULTSSC,null,['class'=>' select2 form-control','placeholder'=>'','id'=>'graduationresult']) !!}
                                                                            @if ($errors->has('graduationresult'))
                                                                                <span class="text-danger">{{ $errors->first('graduationresult') }}</span>
                                                                            @endif
                                                                            {!! Form::text('graduationresult_score', null, array('placeholder' => '','class' => 'form-control graduationresult_score is-invalid','style'=>'display:none',)) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">বিষয় <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::select('graduationsubject',[],null,['class'=>'form-control graduationsubject select2','placeholder'=>'','id'=>'graduationsubject']) !!}
                                                                            @if ($errors->has('graduationsubject'))
                                                                                <span class="text-danger">{{ $errors->first('graduationsubject') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">বিশ্ববিদ্যালয়/ইনস্টিটিউট  <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">

                                                                            {!! Form::select('graduationuniversity',collect($boards)->where('type',2)->pluck('name','id'),null,['class'=>'select2 form-control','placeholder'=>'']) !!}
                                                                            @if ($errors->has('graduationuniversity'))
                                                                                <span class="text-danger">{{ $errors->first('graduationuniversity') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">পাসের সন <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::number('graduationpassyear', null, array('placeholder' => '','class' => 'form-control')) !!}
                                                                            @if ($errors->has('graduationpassyear'))
                                                                                <span class="text-danger">{{ $errors->first('graduationpassyear') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                @endif

                                                @if($job->masters==1)
                                                    <div class="card mt-4">
                                                        <div class="card-header bg-secondary text-white">
                                                            স্নাতকোত্তর
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">পরীক্ষার
                                                                            নাম <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            @php
                                                                                $masters = \App\Models\Examlevel::join('examlevel_groups', 'examlevels.id', '=', 'examlevel_groups.examlevel_id')
                                                                              ->where('examlevels.id',5)
                                                                              ->pluck('examlevel_groups.name','examlevel_groups.id')
                                                                              ->all();
                                                                            @endphp
                                                                            {!! Form::select('mastersexamlevel',$masters,null,['class'=>'form-control select2','placeholder'=>'','id'=>'mastersexamlevel']) !!}
                                                                            @if ($errors->has('mastersexamlevel'))
                                                                                <span class="text-danger">{{ $errors->first('mastersexamlevel') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">শিক্ষা প্রতিষ্ঠান <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::text('mastersinstitute_name', null, array('placeholder' => '','class' => 'form-control')) !!}
                                                                            @if ($errors->has('mastersinstitute_name'))
                                                                                <span class="text-danger">{{ $errors->first('mastersinstitute_name') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">গ্রেড/শ্রেণি/বিভাগ <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::select('mastersresult',\App\Helpers\StaticValue::RESULTSSC,null,['class'=>'select2 form-control','placeholder'=>'','id'=>'mastersresult']) !!}
                                                                            @if ($errors->has('mastersexamlevel'))
                                                                                <span class="text-danger">{{ $errors->first('mastersexamlevel') }}</span>
                                                                            @endif
                                                                            {!! Form::text('mastersresult_score', null, array('placeholder' => '','class' => 'form-control mastersresult_score is-invalid','style'=>'display:none',)) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">বিষয় <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::select('mastersSubject',[],null,['class'=>'form-control mastersSubject select2','placeholder'=>'','id'=>'mastersSubject']) !!}
                                                                            @if ($errors->has('mastersSubject'))
                                                                                <span class="text-danger">{{ $errors->first('mastersSubject') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">বিশ্ববিদ্যালয়/ইনস্টিটিউট <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">

                                                                            {!! Form::select('mastersuniversity',collect($boards)->where('type',2)->pluck('name','id'),null,['class'=>' select2 form-control','placeholder'=>'']) !!}
                                                                            @if ($errors->has('mastersuniversity'))
                                                                                <span class="text-danger">{{ $errors->first('mastersuniversity') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">পাসের সন <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::number('masterspassyear', null, array('placeholder' => '','class' => 'form-control')) !!}
                                                                            @if ($errors->has('masterspassyear'))
                                                                                <span class="text-danger">{{ $errors->first('masterspassyear') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                @endif

                                                @if($job->certificate=="YES")
                                                    <div class="card mt-4">
                                                        <div class="card-header bg-secondary text-white">
                                                            সার্টিফিকেশন
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">সার্টিফিকেশন
                                                                            নাম @if($job->certificate_isrequired==1) <span class="text-danger">*</span>@endif</label>
                                                                        <div class="col-sm-8">

                                                                            @php
                                                                               // dd(collect($job->certificates));

                                                                                    $certificates= \App\Models\JobCertificate::join('certificates', 'job_certificates.certificate_id', '=', 'certificates.id')
                                                                                  ->where('job_certificates.job_id',$job->id)
                                                                                  ->pluck('certificates.name','certificates.id')
                                                                                  ->all();
                                                                            @endphp
                                                                            {!! Form::select('certificate',$certificates,null,['class'=>'form-control select2','placeholder'=>'']) !!}
                                                                            @if ($errors->has('certificate'))
                                                                                <span class="text-danger">{{ $errors->first('certificate') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">প্রতিষ্ঠান নাম @if($job->certificate_isrequired==1) <span class="text-danger">*</span>@endif</label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::text('certificateinstitute_name', null, array('placeholder' => '','class' => 'form-control')) !!}
                                                                            @if ($errors->has('certificateinstitute_name'))
                                                                                <span class="text-danger">{{ $errors->first('certificateinstitute_name') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">গ্রেড/শ্রেণি/বিভাগ  @if($job->certificate_isrequired==1) <span class="text-danger">*</span>@endif </label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::number('certificateduration', null, array('placeholder' => '','class' => 'form-control')) !!}
                                                                            @if ($errors->has('certificateduration'))
                                                                                <span class="text-danger">{{ $errors->first('certificateduration') }}</span>
                                                                            @endif

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </div>
                                                    </div>
                                                @endif

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-secondary text-white">
                                    অতিরিক্ত তথ্য
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="extrq" class="form-label"> অতিরিক্ত যোগ্যতা (যদি থাকে)</label>
                                            {!! Form::textarea('extQualification', null, array('placeholder' => '', 'rows'=>'2', 'class' => 'form-control','id'=>'extQualification')) !!}

                                        </div>

                                        <div class="col-md-3">
                                            <label for="extrq1" class="form-label"> সংশ্লিষ্ট ক্ষেত্রে অভিজ্ঞতা</label>
                                            {!! Form::select('Experience',['আছে'=>'আছে '],null,['class'=>'form-control','placeholder'=>'','id'=>'Experience']) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <label for="extrq" class="form-label"> অভিজ্ঞতার বিবরণ (যদি থাকে)</label>
                                            {!! Form::textarea('experiencemonth', null, array('placeholder' => '', 'rows'=>'2', 'class' => 'form-control','id'=>'experiencemonth')) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <label for="extrq" class="form-label">অভিজ্ঞতার মেয়াদ (বৎসর )</label>
                                            {!! Form::select('experienceyear',\App\Helpers\StaticValue::EXPERIENCE,null,['class'=>'form-control','placeholder'=>'','id'=>'experienceyear']) !!}

                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 5px">
                                        <div class="col-md-3">
                                            <label for="extrq" class="form-label"> কোটা</label>
                                            {!! Form::select('quota',\App\Helpers\StaticValue::QTOTA,null,['class'=>'form-control','placeholder'=>'','id'=>'experienceyear']) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <label for="extrq" class="form-label">বিভাগীয় প্রার্থী কিনা</label>
                                            {!! Form::select('divisioncaplicant',\App\Helpers\StaticValue::DIVISIONAPPLIANT,null,['class'=>'form-control','placeholder'=>'','id'=>'divisioncaplicant']) !!}
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 5px">
                                        <div class="col-md-6">
                                            <label for="formFile" class="form-label">প্রার্থীর ছবি <span class="text-danger">*</span></label>
                                            {!! Form::file('image', ['class'=>'form-control file-input','accept'=>'.jpg,.jpeg,.png,.gif']) !!}
                                            <div id="divImageMediaPreview"></div>
                                            @if ($errors->has('image'))
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="formFile1" class="form-label">প্রার্থীর স্বাক্ষর <span class="text-danger">*</span></label>
                                            {!! Form::file('signature', ['class'=>'form-control signature','accept'=>'.jpg,.jpeg,.png,.gif',]) !!}
                                            <div id="divImagesignaturePreview"></div>
                                            @if ($errors->has('signature'))
                                                <span class="text-danger">{{ $errors->first('signature') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-7 ">
                            <button type="submit" class="btn btn-primary mt-4 btn-lg float-end">Submit Registration</button>
                        </div>

                    </div>

                    {!! Form::close() !!}
                </div>

            </div>

        </div>
    </div>
@endsection
@section('script-bottom')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var District_upozilla={!! json_encode($district_Upozilla) !!};
        var Examlist={!! json_encode($examlist) !!};

        $(document).ready(function () {
            $( "#date_of_birth" ).datepicker({
                dateFormat:"mm-dd-yy",
                changeMonth: true,
                changeYear: true,
               // maxDate: "+1m +1w"
            });
            // $('.select2').select2({
            //     placeholder: 'Select'
            // });
           var selectElem = $("#present_zilla");
           var date_of_place = $("#date_of_place");
           var permanent = $("#permanent_zilla");
           var permanentUpoZilla = $("#permanent_upozilla");
            var filterednames = District_upozilla.filter(function(obj) {
                return (obj.zilla_id == "0");
            });
            var allUpozilla = District_upozilla.filter(function(obj) {
                return (obj.zilla_id != "0");
            });
            $.each(filterednames, function(index, value){
                $("<option/>", {
                    value: value.id,
                    text: value.zilla_name
                }).appendTo(selectElem);
            });
            $.each(filterednames, function(index, value){
                $("<option/>", {
                    value: value.id,
                    text: value.zilla_name
                }).appendTo(date_of_place);
            });

          $.each(filterednames, function(index, value){
                $("<option/>", {
                    value: value.id,
                    text: value.zilla_name
                }).appendTo(permanent);
            });

            $.each(allUpozilla, function(index, value){
                $("<option/>", {
                    value: value.id,
                    text: value.upozilla
                }).appendTo(permanentUpoZilla);
            });


            $('#present_zilla').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                var selectElem = $("#present_upozilla");
                var filterednames = District_upozilla.filter(function(obj) {
                    return (obj.zilla_id == valueSelected);
                });
                $( ".present_upozilla" ).empty();
                $.each(filterednames, function(index, value){
                    $("<option/>", {
                        value: value.id,
                        text: value.upozilla
                    }).appendTo(selectElem);
                });

            });

            $('#permanent_zilla').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                var selectElem = $("#permanent_upozilla");
                var filterednames = District_upozilla.filter(function(obj) {
                    return (obj.zilla_id == valueSelected);
                });
                $( ".permanent_upozilla" ).empty();
                $.each(filterednames, function(index, value){
                    $("<option/>", {
                        value: value.id,
                        text: value.upozilla
                    }).appendTo(selectElem);
                });

            });

            $(".ispresent").change(function() {
                if(this.checked) {
                    //Do stuff
                    var phouseno = $('#present_house_no').val();
                    var pvillage = $('#present_village').val();
                    var punion = $('#present_union').val();
                    var ppostoffice = $('#present_postoffice').val();
                    var ppostcode = $('#present_postcode').val();
                    var pupozilla = $('#present_zilla').val();
                    var pzilla = $('#present_upozilla').val();
                    //   alert(pzilla);
                    $('#permanent_house_no').val(phouseno);
                    $('#permanent_village').val(pvillage);
                    $('#permanent_union').val(punion);
                    $('#permanent_postoffice').val(ppostoffice);
                    $('#permanent_postcode').val(ppostcode);
                    $('#permanent_zilla').val(pupozilla);
                    $('#permanent_upozilla').val(pzilla);
                }
                else{
                    $('#permanent_house_no').val('');
                    $('#permanent_village').val('');
                    $('#permanent_union').val('');
                    $('#permanent_postoffice').val('');
                    $('#permanent_postcode').val('');
                    $('#permanent_zilla').val('');
                    $('#permanent_upozilla').val('');
                }
            });

            $('#jscresult').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                console.log(valueSelected);
                if(valueSelected==4 || valueSelected==5){

                    $('.jscresult_score').css("display","block")
                }
                else{
                    $('.jscresult_score').css("display","none")
                }
            });

            $('#sscresult').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                console.log(valueSelected);
                if(valueSelected==4 || valueSelected==5){

                    $('.sscresult_score').css("display","block")
                }
                else{
                    $('.sscresult_score').css("display","none")
                }
            });

            $('#hscresult').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                console.log(valueSelected);
                if(valueSelected==4 || valueSelected==5){

                    $('.hscresult_score').css("display","block")
                }
                else{
                    $('.hscresult_score').css("display","none")
                }
            });
            $('#graduationresult').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                console.log(valueSelected);
                if(valueSelected==4 || valueSelected==5){

                    $('.graduationresult_score').css("display","block")
                }
                else{
                    $('.graduationresult_score').css("display","none")
                }
            });
            $('#mastersresult').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                console.log(valueSelected);
                if(valueSelected==4 || valueSelected==5){

                    $('.mastersresult_score').css("display","block")
                }
                else{
                    $('.graduationresult_score').css("display","none")
                }
            });

            $('#sscexamlevel').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                var selectElem = $("#sscsubject");
                $.ajax({
                    url:"{{ route('examSubject') }}",
                    type:"GET",
                    data: {
                        examgroup: valueSelected,
                        exam: 2,
                    },
                    success:function (data) {
                       // console.log(data);
                        $( ".sscsubject" ).empty();
                        $.each(data.data, function(index, value){
                            $("<option/>", {
                                value: value.id,
                                text: value.name
                            }).appendTo(selectElem);
                        });

                    }
                })
              //  console.log(valueSelected);
              //   var filterednames = Examlist.filter(function(obj) {
              //       return (obj.id === 2);
              //   });
              //   console.log(filterednames[0].exam_groups);

            });

    $('#hscexamlevel').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                var selectElem = $("#hscubject");
                $.ajax({
                    url:"{{ route('examSubject') }}",
                    type:"GET",
                    data: {
                        examgroup: valueSelected,
                        exam: 3,
                    },
                    success:function (data) {
                        console.log(data);
                        $( ".hscubject" ).empty();
                        $.each(data.data, function(index, value){
                            $("<option/>", {
                                value: value.id,
                                text: value.name
                            }).appendTo(selectElem);
                        });

                    }
                })

            });
            $('#graduationexamlevel').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                var selectElem = $("#graduationsubject");
                $.ajax({
                    url:"{{ route('examSubject') }}",
                    type:"GET",
                    data: {
                        examgroup: valueSelected,
                        exam: 4,
                    },
                    success:function (data) {
                        console.log(data);
                        $( ".graduationsubject" ).empty();
                        $.each(data.data, function(index, value){
                            $("<option/>", {
                                value: value.id,
                                text: value.name
                            }).appendTo(selectElem);
                        });

                    }
                })

            });
      $('#mastersexamlevel').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                var selectElem = $("#mastersSubject");
                $.ajax({
                    url:"{{ route('examSubject') }}",
                    type:"GET",
                    data: {
                        examgroup: valueSelected,
                        exam: 5,
                    },
                    success:function (data) {
                        console.log(data);
                        $( ".mastersSubject" ).empty();
                        $.each(data.data, function(index, value){
                            $("<option/>", {
                                value: value.id,
                                text: value.name
                            }).appendTo(selectElem);
                        });

                    }
                })

            });


            $(document).on('change', '.file-input', function() {
                var filesCount = $(this)[0].files.length;
                var textbox = $(this).prev();
                if (filesCount === 1) {
                    var fileName = $(this).val().split('\\').pop();
                  //  textbox.text(fileName);
                } else {
                    textbox.text(filesCount + ' files selected');
                }

                if (typeof (FileReader) != "undefined") {
                    var dvPreview = $("#divImageMediaPreview");
                    dvPreview.html("");
                    $($(this)[0].files).each(function () {
                        var file = $(this);
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var img = $("<img />");
                            img.attr("style", "width: 150px; height:100px; padding: 10px");
                            img.attr("src", e.target.result);
                            dvPreview.append(img);
                        }
                        reader.readAsDataURL(file[0]);
                    });
                } else {
                    alert("This browser does not support HTML5 FileReader.");
                }


            });

            $(document).on('change', '.signature', function() {
                var filesCount = $(this)[0].files.length;
                var textbox = $(this).prev();
                if (filesCount === 1) {
                    var fileName = $(this).val().split('\\').pop();
                  //  textbox.text(fileName);
                } else {
                    textbox.text(filesCount + ' files selected');
                }

                if (typeof (FileReader) != "undefined") {
                    var dvPreview = $("#divImagesignaturePreview");
                    dvPreview.html("");
                    $($(this)[0].files).each(function () {
                        var file = $(this);
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var img = $("<img />");
                            img.attr("style", "width: 150px; height:100px; padding: 10px");
                            img.attr("src", e.target.result);
                            dvPreview.append(img);
                        }
                        reader.readAsDataURL(file[0]);
                    });
                } else {
                    alert("This browser does not support HTML5 FileReader.");
                }


            });
        });
    </script>

@endsection
