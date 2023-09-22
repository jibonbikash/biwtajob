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
                            {{ $applicationinfo->job ? date("F j, Y", strtotime($applicationinfo->job->jobcurbday)) :'' }}
                        </div>


                    </div>
                    {!! Form::open(['route' => array('applicantPreviewConfirm', $applicationinfo->uuid), 'files' => true, 'id' => 'applicationForm', 'class' => 'applicationForm']) !!}
                    {!! Form::hidden('jobcurday', $job->jobcurbday ? $job->jobcurbday:'') !!}
                    {!! Form::hidden('age_calculation', $job->age_calculation) !!}
                    {!! Form::hidden('min_age', $job->min_age) !!}
                    {!! Form::hidden('max_age', $job->max_age) !!}
                    {!! Form::hidden('handicapped_age', $job->handicapped_age) !!}
                    {!! Form::hidden('divisioncaplicant_age', $job->divisioncaplicant_age) !!}
                    {!! Form::hidden('petition_age', $job->petition_age) !!}
                    {!! Form::hidden('freedom_fighter', $job->freedom_fighter) !!}
                     {!! Form::hidden('date_of_birth_cal', '') !!}
                     {!! Form::hidden('RndID', $job->id, ['id'=>'RndID']) !!}
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
                                            <td style="width: 40%">প্রার্থীর নাম ইংরেজীতে (বড় অক্ষরে) <span class="text-danger">*</span> </td>
                                            <td style="width: 60%"> {!! Form::text('name_en', $applicationinfo->name_en, array('placeholder' => '','class' => 'form-control')) !!}
                                                @if ($errors->has('name_en'))
                                                    <span class="text-danger">{{ $errors->first('name_en') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>প্রার্থীর নাম বাংলায় <span class="text-danger">*</span></td>
                                            <td> {!! Form::text('name_bn', $applicationinfo->name_bn, array('placeholder' => '','class' => 'form-control banglainput')) !!}
                                                @if ($errors->has('name_bn'))
                                                    <span class="text-danger">{{ $errors->first('name_bn') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>পিতার নাম <span class="text-danger">*</span></td>
                                            <td>{!! Form::text('father_name', $applicationinfo->father_name, array('placeholder' => '','class' => 'form-control banglainput')) !!}
                                                @if ($errors->has('father_name'))
                                                    <span class="text-danger">{{ $errors->first('father_name') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>মাতার নাম <span class="text-danger">*</span></td>
                                            <td>{!! Form::text('mother_name', $applicationinfo->mother_name, array('placeholder' => '','class' => 'form-control banglainput')) !!}
                                                @if ($errors->has('mother_name'))
                                                    <span class="text-danger">{{ $errors->first('mother_name') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>জন্ম তারিখ <span class="text-danger">*</span></td>
                                            <td>{!! Form::text('date_of_birth', $applicationinfo->bday, array('placeholder' => '','class' => 'form-control', 'id'=>'date_of_birth')) !!}
                                                @if ($errors->has('date_of_birth'))
                                                    <span class="text-danger">{{ $errors->first('date_of_birth') }}</span>
                                                @endif
                                                <span class="text-danger date_of_birth"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>মোবাইল/টেলিফোন নম্বর <span class="text-danger">*</span></td>
                                            <td> {!! Form::text('mobile_no', $applicationinfo->mobile, array('placeholder' => '','class' => 'form-control banglainput',)) !!}
                                                @if ($errors->has('mobile_no'))
                                                    <span class="text-danger">{{ $errors->first('mobile_no') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>জাতীয় পরিচয় নম্বর/জন্ম নিবন্ধন নম্বর<span class="text-danger">*</span></td>
                                            <td> 
                                                
                                                {!! Form::select('nidorbrn',\App\Helpers\StaticValue::NIDORBRN,$applicationinfo->nid ? 'NID':'BRN',['class'=>'form-control select2 nidorbrn','placeholder'=>'' ,'id'=>'nidorbrn']) !!}
                                                
                                                {!! Form::text('nidorbrnnumber', $applicationinfo->nid ? $applicationinfo->nid:$applicationinfo->brn, array('class' => 'form-control banglainput nidorbrnnumber', 'required'=>true, )) !!}
                                                @if ($errors->has('nidorbrnnumber'))
                                                    <span class="text-danger">{{ $errors->first('nidorbrnnumber') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        
                                        <tr>
                                            <td>জাতীয়তা <span class="text-danger">*</span></td>
                                            <td> {!! Form::select('nationality',\App\Helpers\StaticValue::NATIONALITY,$applicationinfo->nationality,['class'=>'form-control select2','placeholder'=>'']) !!}
                                                @if ($errors->has('nationality'))
                                                    <span class="text-danger">{{ $errors->first('nationality') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>ধর্ম <span class="text-danger">*</span></td>
                                            <td> {!! Form::select('religion',\App\Helpers\StaticValue::RELIGIONS,$applicationinfo->religious,['class'=>'form-control select2','placeholder'=>'']) !!}
                                                @if ($errors->has('religion'))
                                                    <span class="text-danger">{{ $errors->first('religion') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>জেন্ডার <span class="text-danger">*</span></td>
                                            <td> {!! Form::select('gender',\App\Helpers\StaticValue::GENDER,$applicationinfo->gender,['class'=>'form-control select2','placeholder'=>'']) !!}
                                                @if ($errors->has('gender'))
                                                    <span class="text-danger">{{ $errors->first('gender') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>জন্ম স্থান (জেলা)<span class="text-danger">*</span></td>
                                            <td> {!! Form::select('date_of_place',$district,$applicationinfo->bplace,['class'=>'form-control select2','placeholder'=>'', 'id'=>'date_of_place']) !!}
                                                @if ($errors->has('date_of_place'))
                                                    <span class="text-danger">{{ $errors->first('date_of_place') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>পেশা</td>
                                            <td>{!! Form::text('occupation', $applicationinfo->occupation, array('placeholder' => '','class' => 'form-control banglainput')) !!}
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
                                            <td> {!! Form::text('present_house_no', $applicationinfo->pa_house, array('placeholder' => '','class' => 'form-control banglainput','id'=>'present_house_no')) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>গ্রাম/পাড়া/মহল্লা</td>
                                            <td> {!! Form::text('present_village', $applicationinfo->pa_village, array('placeholder' => '','class' => 'form-control banglainput','id'=>'present_village')) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>ইউনিয়ন/ওয়ার্ড</td>
                                            <td> {!! Form::text('present_union', $applicationinfo->pa_union, array('placeholder' => '','class' => 'form-control banglainput','id'=>'present_union')) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>ডাকঘর <span class="text-danger">*</span></td>
                                            <td> {!! Form::text('present_postoffice', $applicationinfo->pa_postoffice, array('placeholder' => '','class' => 'form-control banglainput','id'=>'present_postoffice')) !!}
                                                @if ($errors->has('present_postoffice'))
                                                    <span class="text-danger">{{ $errors->first('present_postoffice') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>পোস্টকোড নম্বর <span class="text-danger">*</span></td>
                                            <td> {!! Form::text('present_postcode', $applicationinfo->pa_postcode, array('placeholder' => '','class' => 'form-control banglainput','id'=>'present_postcode')) !!}
                                                @if ($errors->has('present_postcode'))
                                                    <span class="text-danger">{{ $errors->first('present_postcode') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>জেলা <span class="text-danger">*</span></td>
                                            <td>
                                                {!! Form::select('present_zilla',[],$applicationinfo->pa_zilla,['class'=>'form-control present_zilla select2','id'=>'present_zilla']) !!}
                                                @if ($errors->has('present_zilla'))
                                                    <span class="text-danger">{{ $errors->first('present_zilla') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>উপজেলা/থানা <span class="text-danger">*</span></td>
                                            <td>
                                                {!! Form::select('present_upozilla',[],$applicationinfo->pa_upozilla,['class'=>'form-control present_upozilla select2','id'=>'present_upozilla']) !!}
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
                                            <td> {!! Form::text('permanent_house_no', $applicationinfo->pr_house, array('placeholder' => '','class' => 'form-control banglainput','id'=>'permanent_house_no')) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>গ্রাম/পাড়া/মহল্লা</td>
                                            <td> {!! Form::text('permanent_village', $applicationinfo->pr_village, array('placeholder' => '','class' => 'form-control banglainput','id'=>'permanent_village')) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>ইউনিয়ন/ওয়ার্ড</td>
                                            <td> {!! Form::text('permanent_union', $applicationinfo->pr_union, array('placeholder' => '','class' => 'form-control banglainput','id'=>'permanent_union')) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>ডাকঘর <span class="text-danger">*</span></td>
                                            <td> {!! Form::text('permanent_postoffice', $applicationinfo->pr_postoffice, array('placeholder' => '','class' => 'form-control banglainput','id'=>'permanent_postoffice')) !!}
                                                @if ($errors->has('permanent_postoffice'))
                                                    <span class="text-danger">{{ $errors->first('permanent_postoffice') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>পোস্টকোড নম্বর <span class="text-danger">*</span></td>
                                            <td> {!! Form::text('permanent_postcode', $applicationinfo->pr_postcode, array('placeholder' => '','class' => 'form-control banglainput','id'=>'permanent_postcode')) !!}
                                                @if ($errors->has('permanent_postcode'))
                                                    <span class="text-danger">{{ $errors->first('permanent_postcode') }}</span>
                                                @endif</td>
                                        </tr>
                                        <tr>
                                            <td>জেলা <span class="text-danger">*</span></td>
                                            <td>
                                                {!! Form::select('permanent_zilla',[],$applicationinfo->pr_zilla,['class'=>'form-control permanent_zilla select2','id'=>'permanent_zilla']) !!}
                                                @if ($errors->has('permanent_zilla'))
                                                    <span class="text-danger">{{ $errors->first('permanent_zilla') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>উপজেলা/থানা <span class="text-danger">*</span></td>
                                            <td>
                                                {!! Form::select('permanent_upozilla',[],$applicationinfo->pr_upozilla,['class'=>'form-control permanent_upozilla select2','id'=>'permanent_upozilla']) !!}
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
                                                                           $jscresult= collect($applicationinfo->educations)->where('edu_level', 1);
                                                                                $jsc = \App\Models\Examlevel::join('examlevel_groups', 'examlevels.id', '=', 'examlevel_groups.examlevel_id')
                                                                              ->where('examlevels.id',1)
                                                                              ->pluck('examlevel_groups.name','examlevel_groups.id')
                                                                              ->all();
                                   if(count((array)$jscresult)){
                                    if(isset($jscresult[0])){
                                    $jscresult=$jscresult[0];

                                  }
                                  elseif ($jscresult[1]) {
                                    $jscresult=$jscresult[1];
                                  }

                                  elseif ($SSresult[2]) {
                                    $jscresult=$jscresult[2];
                                  }

                                  }
                            
                                  else{
                                    $jscresult=[];
                                  }

//dd($jscresult);
                                                                        @endphp
                                                                        {!! Form::select('jscexamlevel',$jsc,$jscresult ? $jscresult->edu_level:null,['class'=>'form-control select2','placeholder'=>'']) !!}
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
                                                                        {!! Form::text('jscinstitute_name', $jscresult ? $jscresult->institute_name:null, array('placeholder' => '','class' => 'form-control banglainput')) !!}
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
                                                                        {!! Form::select('jscresult',\App\Helpers\StaticValue::RESULTJSC,$jscresult ? $jscresult->result:null,['class'=>'select2 form-control','placeholder'=>'','id'=>'jscresult']) !!}
                                                                        @if ($errors->has('jscresult'))
                                                                            <span class="text-danger">{{ $errors->first('jscresult') }}</span>
                                                                        @endif
                                                                        {!! Form::text('jscresult_score', $jscresult->cgpa, array('placeholder' => '','class' => 'form-control jscresult_score banglainput','style'=>$jscresult->result=='জিপিএ(আউট অফ ৪)' || $jscresult->result=='জিপিএ(আউট অফ ৫)' ? '':'display:none')) !!}
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

                                                                        {!! Form::select('jscboard',collect($boards)->where('type',1)->pluck('name','id'),$jscresult ? $jscresult->board_university:null,['class'=>'select2 form-control','placeholder'=>'']) !!}
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
                                                                        {!! Form::text('jscpassyear', $jscresult ? $jscresult->passing_year:null, array('placeholder' => '','class' => 'form-control banglainput', 'maxlength'=>4, 'maxlength'=>4)) !!}
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


                                    $SSresult= collect($applicationinfo->educations)->whereIn('edu_level', \App\Models\ExamlevelGroup::where('examlevel_id', 2)->pluck('id'));
                                //  dd(count((array)$SSresult));
                                  if(count((array)$SSresult)){
                                    if(isset($SSresult[0])){
                                    $SSresult=$SSresult[0];

                                  }
                                  elseif ($SSresult[1]) {
                                    $SSresult=$SSresult[1];
                                  }

                                  elseif ($SSresult[2]) {
                                    $SSresult=$SSresult[2];
                                  }
                                  elseif ($SSresult[3]) {
                                    $SSresult=$SSresult[3];
                                  }
                                  elseif ($SSresult[4]) {
                                     
                                    $SSresult=$SSresult[4];
                                  }

                                  }
                            
                                  else{
                                    $SSresult=[];
                                  }
                              //    dd($SSresult);
                                
                                
                                                                            @endphp
                                                                           
                                                                            {!! Form::select('sscexamlevel',$ssc,$SSresult->edu_level,['class'=>'select2 form-control','placeholder'=>'','id'=>'sscexamlevel']) !!}
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
                                                                            {!! Form::text('sscinstitute_name', $SSresult->institute_name, array('placeholder' => '','class' => 'form-control banglainput')) !!}
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
                                                                            {!! Form::select('sscresult',\App\Helpers\StaticValue::RESULTSSC,$SSresult->result,['class'=>'select2 form-control','placeholder'=>'','id'=>'sscresult']) !!}
                                                                            @if ($errors->has('sscresult'))
                                                                                <span class="text-danger">{{ $errors->first('sscresult') }}</span>
                                                                            @endif
                                                                            {!! Form::text('sscresult_score', $SSresult->cgpa, array('placeholder' => '','class' => 'form-control sscresult_score banglainput','style'=>$SSresult->result=='জিপিএ/সিজিপিএ(আউট অফ ৪)' || $SSresult->result=='জিপিএ/সিজিপিএ(আউট অফ ৫)' ? '':'display:none')) !!}
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
                                                                        
                                                                            {!! Form::select('sscSubject',[],$SSresult->group_subject,['class'=>'form-control sscsubject select2','placeholder'=>'','id'=>'sscsubject']) !!}
                                                                            @if ($errors->has('sscSubject'))
                                                                                <span class="text-danger">{{ $errors->first('sscSubject') }}</span>
                                                                            @endif
                                                                            {!! Form::text('sscSubject_other', $SSresult->other, array('placeholder' => '', 'class' => 'form-control banglainput', 'id'=>'sscSubject_other', 'required'=>true, 'style'=>'display:none')) !!}
                                                                            @if ($errors->has('sscSubject_other'))
                                                                                <span class="text-danger">{{ $errors->first('sscSubject_other') }}</span>
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

                                                                            {!! Form::select('sscboard',collect($boards)->where('type',1)->pluck('name','id'),$SSresult->board_university,['class'=>'form-control select2','placeholder'=>'']) !!}
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
                                                                            {!! Form::text('sscpassyear', $SSresult->passing_year, array('placeholder' => '','class' => 'form-control sscpassyear banglainput', 'maxlength'=>4, 'maxlength'=>4)) !!}
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

                                                                                $HSCresult= collect($applicationinfo->educations)->whereIn('edu_level', \App\Models\ExamlevelGroup::where('examlevel_id', 3)->pluck('id'));

                                                                                    $hsc = \App\Models\Examlevel::join('examlevel_groups', 'examlevels.id', '=', 'examlevel_groups.examlevel_id')
                                                                                  ->where('examlevels.id',3)
                                                                                  ->pluck('examlevel_groups.name','examlevel_groups.id')
                                                                                  ->all();
                                                                                  //  dd($HSCresult);
                                                                                    if(isset($HSCresult[0])){
                                                                                        $HSCresult=$HSCresult[0];

                                                                                    }
                                                                                    elseif (isset($HSCresult[1])) {
                                                                                        $HSCresult=$HSCresult[1];
                                                                                    }
                                                                                    elseif (isset($HSCresult[2])) {
                                                                                        $HSCresult=$HSCresult[2];
                                                                                    }
                                                                                    else{
                                                                                        $HSCresult=$HSCresult[3];
                                                                                    }
                                                                                    
                                                                                                                                @endphp
                                                                            {!! Form::select('hscexamlevel',$hsc,$HSCresult->edu_level,['class'=>'form-control select2','placeholder'=>'', 'id'=>'hscexamlevel']) !!}
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
                                                                            {!! Form::text('hscinstitute_name', $HSCresult->institute_name, array('placeholder' => '','class' => 'form-control banglainput')) !!}
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
                                                                            {!! Form::select('hscresult',\App\Helpers\StaticValue::RESULTSSC,$HSCresult->result,['class'=>'select2 form-control','id'=>'hscresult']) !!}
                                                                            @if ($errors->has('hscresult'))
                                                                                <span class="text-danger">{{ $errors->first('hscresult') }}</span>
                                                                            @endif
                                                                            {!! Form::text('hscresult_score', $HSCresult->cgpa, array('placeholder' => '','class' => 'form-control hscresult_score banglainput','style'=>$HSCresult->result=='জিপিএ/সিজিপিএ(আউট অফ ৪)' || $HSCresult->result=='জিপিএ/সিজিপিএ(আউট অফ ৫)' ? '':'display:none',)) !!}
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
                                                                            {!! Form::select('hscubject',[],$HSCresult->group_subject,['class'=>'form-control select2 hscubject','id'=>'hscubject']) !!}
                                                                            @if ($errors->has('hscubject'))
                                                                                <span class="text-danger">{{ $errors->first('hscubject') }}</span>
                                                                            @endif
                                                                            {!! Form::text('hscubject_other', $HSCresult->other, array('placeholder' => '',  'class' => 'form-control banglainput', 'id'=>'hscubject_other', 'required'=>true, 'style'=>'display:none')) !!}
                                                                            @if ($errors->has('hscubject_other'))
                                                                                <span class="text-danger">{{ $errors->first('hscubject_other') }}</span>
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

                                                                            {!! Form::select('hscboard',collect($boards)->where('type',1)->pluck('name','id'),$HSCresult->board_university,['class'=>'form-control select2']) !!}
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
                                                                            {!! Form::text('hscpassyear', $HSCresult->passing_year, array('placeholder' => '','class' => 'form-control banglainput','maxlength'=>4, 'maxlength'=>4)) !!}
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
                            $GRADresult= collect($applicationinfo->educations)->whereIn('edu_level', \App\Models\ExamlevelGroup::where('examlevel_id', 4)->pluck('id'));
                     //  dd($GRADresult);
                       if(count((array)$GRADresult)> 0){
                        
                        if(isset($GRADresult[0])){
                          
                                                                                        $GRADresult=$GRADresult[0];
                                                                                        

                                                                                    }
                                                                                    elseif (isset($GRADresult[1])) {
                                                                                        $GRADresult=$GRADresult[1];
                                                                                       
                                                                                    }
                                                                                    elseif (isset($GRADresult[2])) {
                                                                                        $GRADresult=$GRADresult[2];
                                                                                       
                                                                                    }
                                                                                    elseif (isset($GRADresult[3])) {
                                                                                        $GRADresult=$GRADresult[3];
                                                                                       
                                                                                    }

                                                                                    else{
                                                                                        $GRADresult=$GRADresult[4];
                                                                                        
                                                                                    }
                                                                                    
                       }
                       else{
                           
                        $GRADresult=[];
                     //  dd('dddddddddddddddddddddd');
                       }
                    //   dd($GRADresult);
                       
                                                                            @endphp
                                                                            {!! Form::select('graduationexamlevel',$graduation,$GRADresult->edu_level??'',['class'=>'select2 form-control','placeholder'=>'','id'=>'graduationexamlevel']) !!}
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
                                                                            {!! Form::text('graduationinstitute_name', $GRADresult->institute_name??'', array('placeholder' => '','class' => 'form-control banglainput')) !!}
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
                                                                        <label for="graduationresult"
                                                                               class="col-sm-4 col-form-label">গ্রেড/শ্রেণি/বিভাগ <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::select('graduationresult',\App\Helpers\StaticValue::RESULTSSC,$GRADresult ? $GRADresult->result:'',['class'=>' select2 form-control','placeholder'=>'','id'=>'graduationresult']) !!}
                                                                            @if ($errors->has('graduationresult'))
                                                                                <span class="text-danger">{{ $errors->first('graduationresult') }}</span>
                                                                            @endif
                                                                            {!! Form::text('graduationresult_score',  $GRADresult ? $GRADresult->cgpa:"", array('placeholder' => '','class' => 'form-control graduationresult_score banglainput','style'=>$GRADresult ? ($GRADresult->result=='জিপিএ/সিজিপিএ(আউট অফ ৪)' || $GRADresult->result=='জিপিএ/সিজিপিএ(আউট অফ ৫)' ? '':'display:none'):"",)) !!}
                                                                        
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="graduationsubject"
                                                                               class="col-sm-4 col-form-label">বিষয় <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::select('graduationsubject',[],$GRADresult ? $GRADresult->group_subject:'',['class'=>'form-control graduationsubjecttt','placeholder'=>'','id'=>'graduationsubject']) !!}
                                                                            @if ($errors->has('graduationsubject'))
                                                                                <span class="text-danger">{{ $errors->first('graduationsubject') }}</span>
                                                                            @endif

                                                                            {!! Form::text('graduationsubject_other', $GRADresult->other, array('placeholder' => '',  'class' => 'form-control banglainput', 'id'=>'graduationsubject_other', 'required'=>true, 'style'=>'display:none')) !!}
                                                                            @if ($errors->has('graduationsubject_other'))
                                                                                <span class="text-danger">{{ $errors->first('graduationsubject_other') }}</span>
                                                                            @endif

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="graduationuniversity"
                                                                               class="col-sm-4 col-form-label">বিশ্ববিদ্যালয়/ইনস্টিটিউট  <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::select('graduationuniversity',collect($boards)->where('type',2)->pluck('name','id'),$GRADresult ? $GRADresult->board_university:'',['class'=>'select2 form-control','placeholder'=>'']) !!}
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
                                                                            {!! Form::text('graduationpassyear', $GRADresult ? $GRADresult->passing_year:"", array('placeholder' => '','class' => 'form-control banglainput', 'maxlength'=>4, 'maxlength'=>4)) !!}
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
 $Mastresult= collect($applicationinfo->educations)->whereIn('edu_level', \App\Models\ExamlevelGroup::where('examlevel_id', 5)->pluck('id'));
// dd($Mastresult);
 if(count($Mastresult)> 0){
                        
                        if(isset($Mastresult[0])){
                          
                                                                                        $Mastresult=$Mastresult[0];
                                                                                        

                                                                                    }
                                                                                    elseif (isset($Mastresult[1])) {
                                                                                        $Mastresult=$Mastresult[1];
                                                                                       
                                                                                    }
                                                                                    elseif (isset($Mastresult[2])) {
                                                                                        $Mastresult=$Mastresult[2];
                                                                                       
                                                                                    }
                                                                                    elseif (isset($Mastresult[3])) {
                                                                                        $Mastresult=$Mastresult[3];
                                                                                       
                                                                                    }

                                                                                    elseif (isset($Mastresult[4])) {
                                                                                        $Mastresult=$Mastresult[4];
                                                                                       
                                                                                    }
                                                                                    elseif (isset($Mastresult[5])) {
                                                                                        $Mastresult=$Mastresult[5];
                                                                                       
                                                                                    }

                                                                                    else{
                                                                                        $Mastresult=$Mastresult[6];
                                                                                        
                                                                                    }
                                                                                    
                       }
                       else{
                           
                        $Mastresult=[];
                     //  dd('dddddddddddddddddddddd');
                       }
                    //   dd($Mastresult);


                                                                            @endphp
                                                                            {!! Form::select('mastersexamlevel',$masters,$Mastresult ? $Mastresult->edu_level:'',['class'=>'form-control select2','placeholder'=>'','id'=>'mastersexamlevel']) !!}
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
                                                                            {!! Form::text('mastersinstitute_name',$Mastresult  ? $Mastresult->institute_name:'', array('placeholder' => '','class' => 'form-control banglainput')) !!}
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
                                                                            {!! Form::select('mastersresult',\App\Helpers\StaticValue::RESULTSSC,$Mastresult ? $Mastresult->result:'',['class'=>'select2 form-control','placeholder'=>'','id'=>'mastersresult']) !!}
                                                                            @if ($errors->has('mastersexamlevel'))
                                                                                <span class="text-danger">{{ $errors->first('mastersexamlevel') }}</span>
                                                                            @endif
                                                                            {!! Form::text('mastersresult_score', $Mastresult ? $Mastresult->cgpa:'', array('placeholder' => '','class' => 'form-control mastersresult_score banglainput','style'=>$Mastresult ? ($Mastresult->result=='জিপিএ/সিজিপিএ(আউট অফ ৪)' || $Mastresult->result=='জিপিএ/সিজিপিএ(আউট অফ ৫)' ? '':'display:none'):'display:none',)) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3 row">
                                                                        <label for="inputPassword"
                                                                               class="col-sm-4 col-form-label">বিষয় <span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {!! Form::select('mastersSubject',[],$Mastresult ? $Mastresult->group_subject:'',['class'=>'form-control mastersSubject select2','placeholder'=>'','id'=>'mastersSubject']) !!}
                                                                            @if ($errors->has('mastersSubject'))
                                                                                <span class="text-danger">{{ $errors->first('mastersSubject') }}</span>
                                                                            @endif

                                                                            {!! Form::text('mastersSubject_other', $Mastresult ? $Mastresult->other:'', array('placeholder' => '', 'class' => 'form-control banglainput', 'id'=>'mastersSubject_other', 'required'=>true, 'style'=>'display:none')) !!}
                                                                            @if ($errors->has('mastersSubject_other'))
                                                                                <span class="text-danger">{{ $errors->first('mastersSubject_other') }}</span>
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
<?php
//dd(collect($boards)->where('type',2)->pluck('name','id'), $Mastresult->board_university);
?>
                                                                            {!! Form::select('mastersuniversity',collect($boards)->where('type',2)->pluck('name','id'),$Mastresult ? $Mastresult->board_university:null,['class'=>' select2 form-control','placeholder'=>'']) !!}
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
                                                                            {!! Form::text('masterspassyear', $Mastresult ? $Mastresult->passing_year:null, array('placeholder' => '','class' => 'form-control banglainput', 'maxlength'=>4, 'maxlength'=>4)) !!}
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
                                                @php
                                              //  dd($applicationinfo->applicantCertificate);    

                                                @endphp
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
                                                                        {!! Form::select('certificate',$certificates, $applicationinfo->applicantCertificate()->exists() ?? $applicationinfo->applicantCertificate->edu_level,['class'=>'form-control select2','placeholder'=>'']) !!}
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
                                                                        {!! Form::text('certificateinstitute_name', $applicationinfo->applicantCertificate()->exists() ?  $applicationinfo->applicantCertificate->institute_name:'', array('placeholder' => '','class' => 'form-control banglainput')) !!}
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
                                                                           class="col-sm-4 col-form-label">সার্টিফিকেট/লাইসেন্স নম্বর @if($job->certificate_isrequired==1) <span class="text-danger">*</span>@endif </label>
                                                                    <div class="col-sm-8">
                                                                        {!! Form::text('certificate_no', $applicationinfo->applicantCertificate->certificate_no, array('placeholder' => '','class' => 'form-control')) !!}
                                                                        @if ($errors->has('certificate_no'))
                                                                            <span class="text-danger">{{ $errors->first('certificate_no') }}</span>
                                                                        @endif

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3 row">
                                                                    <label for="inputPassword"
                                                                           class="col-sm-4 col-form-label">সার্টিফিকেট/লাইসেন্সের মেয়াদ শেষ হওয়ার তারিখ @if($job->certificate_isrequired==1) <span class="text-danger">*</span>@endif </label>
                                                                    <div class="col-sm-8">
                                                                        {!! Form::text('certificate_expire', $applicationinfo->applicantCertificate->certificate_expire, array('placeholder' => '','class' => 'form-control certificate_expire')) !!}
                                                                        @if ($errors->has('certificate_expire'))
                                                                            <span class="text-danger">{{ $errors->first('certificate_expire') }}</span>
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
                                            {!! Form::textarea('extQualification', $applicationinfo->extra_qualification, array('placeholder' => '', 'rows'=>'2', 'class' => 'form-control','id'=>'extQualification')) !!}

                                        </div>

                                        <div class="col-md-3">
                                            <label for="extrq1" class="form-label"> সংশ্লিষ্ট ক্ষেত্রে অভিজ্ঞতা</label>
                                            {!! Form::select('Experience',['আছে'=>'আছে '],$applicationinfo->experience,['class'=>'form-control','placeholder'=>'','id'=>'Experience']) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <label for="extrq" class="form-label"> অভিজ্ঞতার বিবরণ (যদি থাকে)</label>
                                            {!! Form::textarea('experiencemonth', $applicationinfo->experiencemonth, array('placeholder' => '', 'rows'=>'2', 'class' => 'form-control','id'=>'experiencemonth')) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <label for="extrq" class="form-label">অভিজ্ঞতার মেয়াদ (বৎসর )</label>
                                            <?php 
                                        $experience=[];
                                        for ($x = $job->minimum_job_experience; $x <= 12; $x++) {
                                        $experience[]=\App\Helpers\StaticValue::englishToBengaliNumberConverter($x); 

                                        } 

$experience= array_combine($experience, $experience);
                                            ?>
                                            {!! Form::select('experienceyear',array_merge($experience,['১২+'=>'১২+']),$applicationinfo->experienceyear,['class'=>'form-control','placeholder'=>'','id'=>'experienceyear']) !!}

                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 5px">
                                        <div class="col-md-3">
                                            <label for="extrq" class="form-label"> কোটা</label>
                                            <?php
                                            $dbValue = $applicationinfo->quota;
                                             $myArray = json_decode($dbValue, true);                                       
                                            ?>
                                            {!! Form::select('quota[]',\App\Helpers\StaticValue::QTOTA,$myArray,['class'=>'form-control quota','id'=>'quota', 'multiple'=>true]) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <label for="extrq" class="form-label">বিভাগীয় প্রার্থী কিনা</label>
                                            {!! Form::select('divisioncaplicant',\App\Helpers\StaticValue::DIVISIONAPPLIANT,$applicationinfo->division_appli,['class'=>'form-control','placeholder'=>'','id'=>'divisioncaplicant']) !!}
                                        </div>
                                        @if($job->repetition)
                                        <div class="col-md-3">
                                            {{ Form::checkbox('repetition', '1', $applicationinfo->repetition==1 ? true: false, array( 'id'=>'repetition')) }}
                                            <label for="extrq" class="form-label">{{ $job->repetition}}</label>
                                        </div>
                                       @endif   
                                    </div>

                                    <div class="row" style="margin-top: 5px">
                                        <div class="col-md-6">
                                            <label for="formFile" class="form-label">প্রার্থীর ছবি <span class="text-danger">*</span></label>

                                            {!! Form::file('image', ['class'=>'form-control file-input','accept'=>'.jpg,.jpeg,.png,.gif']) !!}
                                            <div id="divImageMediaPreview"><img class="img-responsive" src="{{URL::to('/assets/applicants')}}/{{ $applicationinfo->picture }}" alt="" style="width: 150px"/></div>
                                            @if ($errors->has('image'))
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="formFile1" class="form-label">প্রার্থীর স্বাক্ষর <span class="text-danger">*</span></label>

                                            {!! Form::file('signature', ['class'=>'form-control signature','accept'=>'.jpg,.jpeg,.png,.gif',]) !!}
                                            <div id="divImagesignaturePreview"><img class="img-responsive" src="{{URL::to('/assets/applicants')}}/{{ $applicationinfo->signature }}" alt="" style="width: 150px"/></div>
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
                            <button type="submit" class="btn btn-primary mt-4 btn-lg float-end" id="submitb">Submit Application & Preview </button>
                        </div>

                    </div>

                    {!! Form::close() !!}
                </div>

            </div>

        </div>
    </div>
    <?php
           // dd($HSCresult, count($HSCresult));
           
            ?>

@endsection
@section('script-bottom')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/bn.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.bangla@1/dist/jquery.bangla.js"></script>
<script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var District_upozilla={!! json_encode($district_Upozilla) !!};
        var Examlist={!! json_encode($examlist) !!};
        var RndID = $('#RndID').val();

        $(document).ready(function () {
            $('.banglainput').bangla({ enable: true });
            $( "#date_of_birth" ).datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                yearRange: "-80:+0",
               // maxDate: "+1m +1w"
            });

            $( ".certificate_expire" ).datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
               // maxDate: "+1m +1w"
            });
            $('.select2').select2({
                placeholder: 'নির্বাচন করুন',
                language: "bn",
                minimumResultsForSearch: -1
            });

       $('.quota').select2({
                placeholder: 'নির্বাচন করুন',
                language: "bn",
            
            });

           var selectElem = $("#present_zilla");
           var date_of_place = $("#date_of_place");
           var permanent = $("#permanent_zilla");
           var permanentUpoZilla = $("#permanent_upozilla");
           var present_upozilla = $("#present_upozilla");
            var filterednames = District_upozilla.filter(function(obj) {
                return (obj.zilla_id == "0");
            });
            var filterednamesPres = District_upozilla.filter(function(obj) {
                return (obj.zilla_id == "{{ $applicationinfo->pa_zilla}}");
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

            $(".present_zilla").val("{{ $applicationinfo->pa_zilla}}").change();

            $.each(filterednames, function(index, value){
                $("<option/>", {
                    value: value.id,
                    text: value.zilla_name
                }).appendTo(date_of_place);
            });

            $( ".present_upozilla" ).empty();
            // console.log(filterednames);
            $.each(filterednamesPres, function(index, value){
                $("<option/>", {
                    value: value.id,
                    text: value.upozilla
                }).appendTo("#present_upozilla");
            });

          $.each(filterednames, function(index, value){
                $("<option/>", {
                    value: value.id,
                    text: value.zilla_name
                }).appendTo(permanent);
            });
            $(".permanent_zilla").val("{{ $applicationinfo->pr_zilla}}").change();
            var filterednamess = District_upozilla.filter(function(obj) {
                return (obj.zilla_id == {{$applicationinfo->pr_zilla}});
            });
            $( ".permanent_upozilla" ).empty();
           // console.log(filterednames);
            $.each(filterednamess, function(index, value){
                $("<option/>", {
                    value: value.id,
                    text: value.upozilla
                }).appendTo("#permanent_upozilla");
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
                    //   alert('phouseno');
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
                if(valueSelected=='জিপিএ(আউট অফ ৪)' || valueSelected=='জিপিএ(আউট অফ ৫)'){

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
                if(valueSelected=='জিপিএ/সিজিপিএ(আউট অফ ৪)' || valueSelected=='জিপিএ/সিজিপিএ(আউট অফ ৫)'){

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
                if(valueSelected=='জিপিএ/সিজিপিএ(আউট অফ ৪)' || valueSelected=='জিপিএ/সিজিপিএ(আউট অফ ৫)'){
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
                if(valueSelected=='জিপিএ/সিজিপিএ(আউট অফ ৪)' || valueSelected=='জিপিএ/সিজিপিএ(আউট অফ ৫)'){

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
                if(valueSelected=='জিপিএ/সিজিপিএ(আউট অফ ৪)' || valueSelected=='জিপিএ/সিজিপিএ(আউট অফ ৫)'){

                    $('.mastersresult_score').css("display","block")
                }
                else{
                    $('.mastersresult_score').css("display","none")
                    
                }
            });
<?php
if(count((array)$SSresult)> 0){
?>
            var selectElemssc = $("#sscsubject");
$.ajax({
    url:"{{ route('examSubject') }}",
    type:"GET",
    data: {
        examgroup: {{$SSresult->edu_level}},
        exam: 2,
        JobID:RndID,
    },
    success:function (data) {
         console.log(data);
        $( ".sscsubject" ).empty();
        $.each(data.data, function(index, value){
            $("<option/>", {
                value: value.id,
                text: value.name
            }).appendTo(selectElemssc);
        });
        $(".sscsubject").val("{{ $SSresult ? $SSresult->group_subject:''}}").change();

    }
})
  
<?php
}
?>
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
                        JobID:RndID,
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
            <?php
           
            if(count((array)$HSCresult)> 0){
            ?>
            var selectElemHSC = $("#hscubject");
          //  console.log({{$HSCresult ? $HSCresult->edu_level:''}});
            $.ajax({
                url:"{{ route('examSubject') }}",
                type:"GET",
                data: {
                    examgroup: {{$HSCresult ? $HSCresult->edu_level:''}},
                    exam: 3,
                    JobID:RndID,
                },
                success:function (data) {
                    console.log(data);
                    $( ".hscubject" ).empty();
                    $.each(data.data, function(index, value){
                        $("<option/>", {
                            value: value.id,
                            text: value.name
                        }).appendTo(selectElemHSC);
                    });
                  //  $("#hscubject option[value='{{ $HSCresult ? $HSCresult->group_subject:''}}']").prop('selected',true);
                    $(".hscubject").val("{{ $HSCresult ? $HSCresult->group_subject:''}}").change();
                }
            })
           

        

            <?php
            }
            ?>
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
                        JobID:RndID,
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

            <?php
            if(count((array)$GRADresult)> 0){
            ?>
            var selectElemGra = $("#graduationsubject");
            $.ajax({
                url:"{{ route('examSubject') }}",
                type:"GET",
                data: {
                    examgroup: {{$GRADresult ? $GRADresult->edu_level:''}},
                    exam: 4,
                    JobID:RndID,
                },
                success:function (data) {
                    
                      console.log(data);
                    $(".graduationsubjecttt").empty();
                    $.each(data.data, function(index, value){
                        $("<option/>", {
                            value: value.id,
                            text: value.name
                        }).appendTo(selectElemGra);
                    });
                    $(".graduationsubjecttt").val("{{ $GRADresult ? $GRADresult->group_subject:''}}").change();
             
            }
                })

               // $("#graduationsubject option[value='14']").prop('selected',true);
           
           // $("#graduationsubject").val("14").change();
            <?php
            }
            ?>

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
                        JobID:RndID,
                    },
                    success:function (data) {
                        console.log(data);
                        $( ".graduationsubjecttt" ).empty();
                        $.each(data.data, function(index, value){
                            $("<option/>", {
                                value: value.id,
                                text: value.name
                            }).appendTo(selectElem);
                        });

                    }
                })

            });
            <?php
            if(count((array)$Mastresult)> 0){
            ?>
            var selectElemMAS = $("#mastersSubject");
            $.ajax({
                url:"{{ route('examSubject') }}",
                type:"GET",
                data: {
                    examgroup: {{$Mastresult ? $Mastresult->edu_level:''}},
                    exam: 5,
                    JobID:RndID,
                },
                success:function (data) {
                    console.log(data);
                    $( ".mastersSubject" ).empty();
                    $.each(data.data, function(index, value){
                        $("<option/>", {
                            value: value.id,
                            text: value.name
                        }).appendTo(selectElemMAS);
                    });
                    $(".mastersSubject").val("{{ $Mastresult ? $Mastresult->group_subject:''}}").change();
                }
            })
            

            <?php
            }
            ?>


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
                        JobID:RndID,
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

            $('#sscsubject').on('change', function (e) {
                var optionSelected = $("option:selected", this);
            console.log(optionSelected.text());
            if(optionSelected.text()==='Other'){
                $('#sscSubject_other').css("display","block")
            }
            else{
            $('#sscSubject_other').css("display","none")
            }
                
            });


           $('#hscubject').on('change', function (e) {
                var optionSelected = $("option:selected", this);
            console.log(optionSelected.text());
            if(optionSelected.text()==='Other'){
                $('#hscubject_other').css("display","block")
            }
            else{
                $('#hscubject_other').css("display","none")
            }
                
            });
            $('#graduationsubject').on('change', function (e) {
                var optionSelected = $("option:selected", this);
            console.log(optionSelected.text());
            if(optionSelected.text()==='Other'){
                $('#graduationsubject_other').css("display","block")
            }
            else{
                $('#graduationsubject_other').css("display","none")
            }
                
            });
            $('#mastersSubject').on('change', function (e) {
                var optionSelected = $("option:selected", this);
            console.log(optionSelected.text());
            if(optionSelected.text()==='Other'){
                $('#mastersSubject_other').css("display","block")
            }
            else{
                $('#mastersSubject_other').css("display","none")
            }
                
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


            $('#date_of_birth').on('change', function (e) {

var date_of_birth = $('#date_of_birth').val();
var ageCalculationDate = {{$job->age_calculation}};
var min_age = {{$job->min_age}};
var max_age = {{$job->max_age}};
var handicapped_age = {{$job->handicapped_age}};
var divisioncaplicant_age = {{$job->divisioncaplicant_age}};
var petition_age = {{$job->petition_age}};
var quota= $('#quota').val();
var divisioncaplicant= $('#divisioncaplicant').val();
console.log(quota);



$.ajax({
    url:"{{ route('ageCalculation') }}",
    type:"POST",
    cache: false,
    data: {
        "bday": date_of_birth,
        "fixedday": "{{$job->age_calculation}}",
        "_token": "{{ csrf_token() }}",
    },
    success:function (data) {
      console.log(data);
      $('span.date_of_birth').html(data.data);
    }
});

 applicationAgeCalculation(date_of_birth, quota, divisioncaplicant);

});

function getWordCount(wordString) {
  var words = wordString.split(" ");
  words = words.filter(function(words) { 
    return words.length > 0
  }).length;
  return words;
}

//add the custom validation method
$.validator.addMethod("wordCount",
   function(value, element, params) {
      var count = getWordCount(value);
     
      if(count < params[0]) {
         return true;
      }
   },
   $.validator.format("A maximum of {0} words is required here.")
);
$("#applicationForm").validate({
			rules: {
				name_en: "required",
				name_bn: "required",
                father_name: "required",
                mother_name: "required",
                date_of_birth: "required",
                mobile_no: "required",
                nidorbrn: "required",
                nidorbrnnumber: "required",
                nationality: "required",
                religion: "required",
                gender: "required",
                date_of_place: "required",
                present_postoffice: "required",
                present_postcode: "required",
                present_zilla: "required",
                present_upozilla: "required",
                permanent_postoffice: "required",
                permanent_postcode: "required",
                permanent_zilla: "required",
                permanent_upozilla: "required",
                agree: "required",
                image: {
                    required: false,
                //    extension: "jpeg|jpg|png",
				//	filesize : 102400
					
                },
                signature: {
                    required: false,
                 //   extension: "jpeg|jpg|png",
				//	 filesize : 102400
					
                },
                experiencemonth:
            {
                required: false,
                wordCount: ['300']
            },
            extQualification:
            {
                required: false,
                wordCount: ['300']
            },
                <?php
                if((($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  ($job->jsc==1))){
                ?>
            jscexamlevel: "required",
            jscinstitute_name: "required",
            jscresult: "required",
            jscboard: "required",
            jscpassyear: "required",
            <?php
            }
            ?>

            <?php
              if((( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1)){
                ?>
            sscexamlevel: "required",
            sscinstitute_name: "required",
            sscresult: "required",
            sscSubject: "required",
            sscboard: "required",
            sscpassyear: "required",
            <?php
            }
            ?>

            <?php
              if(( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1){
                ?>
            hscexamlevel: "required",
            hscinstitute_name: "required",
            hscresult: "required",
            hscubject: "required",
            hscboard: "required",
            hscpassyear: "required",
            <?php
            }
            ?>
            <?php
              if(( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1){
                ?>
           graduationexamlevel: "required",
           graduationinstitute_name: "required",
           graduationresult: "required",
           graduationsubject: "required",
           graduationuniversity: "required",
           graduationpassyear: "required",
            <?php
            }
            ?>
            <?php
            if(( $job->min_education=='Masters') AND  $job->masters==1){
                ?>
           mastersexamlevel: "required",
           mastersinstitute_name: "required",
           mastersresult: "required",
           mastersSubject: "required",
           mastersuniversity: "required",
           masterspassyear: "required",
            <?php
            }
            ?>
            <?php
            if($job->certificate_isrequired==1){
                ?>
                certificate: "required",
                certificateinstitute_name: "required",
                certificate_no: "required",
                certificate_expire: "required",
            <?php
            }
            ?>

            },
            messages: {
				name_en: "প্রার্থীর নাম ইংরেজীতে (বড় অক্ষরে) লিখুন",
				name_bn: "প্রার্থীর নাম বাংলায় লিখুন",
                father_name: "পিতার নাম লিখুন",
                mother_name: "মাতার নাম লিখুন",
                date_of_birth: "'জন্ম তারিখ লিখুন",
                mobile_no: "মোবাইল/টেলিফোন নম্বর লিখুন",
                nidorbrn: "জাতীয় পরিচয় নম্বর/জন্ম নিবন্ধন নম্বর নির্বাচন করুন",
                nidorbrnnumber: "নিবন্ধন নম্বর লিখুন",
                nationality: "জাতীয়তা নির্বাচন করুন",
                religion: "ধর্ম নির্বাচন করুন",
                gender: "জেন্ডার নির্বাচন করুন",
                date_of_place: "জন্ম স্থান (জেলা) নির্বাচন করুন",


                present_postoffice: "ডাকঘর লিখুন",
                present_postcode: "পোস্টকোড নম্বর লিখুন",
                present_zilla: "জেলা নির্বাচন করুন",
                present_upozilla: "উপজেলা/থানা নির্বাচন করুন",

                permanent_postoffice: "ডাকঘর লিখুন",
                permanent_postcode: "পোস্টকোড নম্বর লিখুন",
                permanent_zilla: "জেলা নির্বাচন করুন",
                permanent_upozilla: "উপজেলা/থানা নির্বাচন করুন",
                image: {
					required: "প্রার্থীর ছবি নির্বাচন করুন",
				//	extension: "প্রার্থীর ছবি jpeg|jpg|png নির্বাচন করুন"
				},
                signature: {
					required: "প্রার্থীর স্বাক্ষর নির্বাচন করুন",
				//	extension: "প্রার্থীর স্বাক্ষর jpeg|jpg|png নির্বাচন করুন"
				},
                agree: "নির্বাচন করুন",
                <?php
                if(($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  ($job->jsc==1)){
                ?>
                jscexamlevel: 'জে.এস.সি/ সমমান পরীক্ষার নাম নির্বাচন করুন',
                jscinstitute_name : 'শিক্ষা প্রতিষ্ঠানের নাম লিখুন',
                jscresult : 'গ্রেড/শ্রেণি/বিভাগ নির্বাচন করুন',
                jscboard : 'বোর্ড নির্বাচন করুন',
                jscpassyear : 'পাসের সন লিখুন',
             <?php
            }
            ?>
            <?php
            if((( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1)){
                ?>
                sscexamlevel: 'এস.এস.সি/ সমমান পরীক্ষার নাম নির্বাচন করুন',
                sscinstitute_name : 'শিক্ষা প্রতিষ্ঠানের নাম লিখুন',
                sscresult : 'গ্রেড/শ্রেণি/বিভাগ নির্বাচন করুন',
                sscSubject : 'বিষয় নির্বাচন করুন',
                sscboard : 'বোর্ড নির্বাচন করুন',
                sscpassyear : 'পাসের সন লিখুন',
             <?php
            }
            ?>
            <?php
            if(( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1){
                ?>
                hscexamlevel: 'এইচএসসি /সমমূল্য পরীক্ষার নাম নির্বাচন করুন',
                hscinstitute_name : 'শিক্ষা প্রতিষ্ঠানের নাম লিখুন',
                hscresult : 'গ্রেড/শ্রেণি/বিভাগ নির্বাচন করুন',
                hscubject : 'বিষয় নির্বাচন করুন',
                hscboard : 'বোর্ড নির্বাচন করুন',
                hscpassyear : 'পাসের সন লিখুন',
             <?php
            }
            ?>
            <?php
            if(( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1){
                ?>
                graduationexamlevel: 'স্নাতক ডিগ্রী পরীক্ষার নাম নির্বাচন করুন',
                graduationinstitute_name : 'শিক্ষা প্রতিষ্ঠানের নাম লিখুন',
                graduationresult : 'গ্রেড/শ্রেণি/বিভাগ নির্বাচন করুন',
                graduationsubject : 'বিষয় নির্বাচন করুন',
                graduationuniversity : 'বিশ্ববিদ্যালয়/ইনস্টিটিউট নির্বাচন করুন',
                graduationpassyear : 'পাসের সন লিখুন',
             <?php
            }
            ?>
            <?php
            if(( $job->min_education=='Masters') AND  $job->masters==1){
                ?>
                mastersexamlevel: 'স্নাতকোত্তর পরীক্ষার নাম নির্বাচন করুন',
                mastersinstitute_name : 'শিক্ষা প্রতিষ্ঠানের নাম লিখুন',
                mastersresult : 'গ্রেড/শ্রেণি/বিভাগ নির্বাচন করুন',
                mastersSubject : 'বিষয় নির্বাচন করুন',
                mastersuniversity : 'বিশ্ববিদ্যালয়/ইনস্টিটিউট নির্বাচন করুন',
                masterspassyear : 'পাসের সন লিখুন',
             <?php
            }
            ?>
            <?php
            if($job->certificate_isrequired==1){
                ?>
                certificate: "সার্টিফিকেশন নাম নির্বাচন করুন",
                certificateinstitute_name: "প্রতিষ্ঠান নাম লিখুন",
                certificate_no: "সার্টিফিকেট/লাইসেন্স নম্বর লিখুন",
                certificate_expire: "সার্টিফিকেট/লাইসেন্সের মেয়াদ শেষ হওয়ার তারিখ নির্বাচন করুন",
            <?php
            }
            ?>
				
			},
            errorPlacement: function(label, element) {
    if (element.hasClass('select2')) {
      label.insertAfter(element.next('.select2-container')).addClass('mt-2 text-danger');
      select2label = label
    } else {
      label.addClass('mt-2 text-danger');
      label.insertAfter(element);
    }
   
  },
            });


$('#quota').on('change', function (e) {
var quota= $('#quota').val();
var date_of_birth = $('#date_of_birth').val();
var divisioncaplicant = $('#divisioncaplicant').val();
console.log(quota);
applicationAgeCalculation(date_of_birth, quota, divisioncaplicant);

});

$('#divisioncaplicant').on('change', function (e) {
var quota= $('#quota').val();
var date_of_birth = $('#date_of_birth').val();
var divisioncaplicant = $('#divisioncaplicant').val();
console.log(quota);
applicationAgeCalculation(date_of_birth, quota, divisioncaplicant);

});


function applicationAgeCalculation(date_of_birth, quota=[], divisioncaplicant=''){
    if ($('input#repetition').is(':checked')) {
                    var repetition = true;
                }
                else{
                    var repetition = false;
                }

$.ajax({
    url:"{{ route('applyAgeCalculation') }}",
    type:"POST",
    cache: false,
    data: {
        "bday": date_of_birth,
        "fixedday": "{{$job->age_calculation}}",
        "quota": quota,
        "divisioncaplicant": divisioncaplicant,
         "minimumage": "{{$job->min_age}}",
         "mamximumage": "{{$job->max_age}}",
         "divisional": "{{$job->divisioncaplicant_age}}",
         "freedom_fighter": "{{$job->freedom_fighter}}",
         "handicapped_age": "{{$job->handicapped_age}}",
         "repetition": repetition,
          "RndID": $('#RndID').val(),
        "_token": "{{ csrf_token() }}",
    },
    success:function (data) {
      console.log(data);
      if(data=='Yes'){
$("#submitb").attr("disabled", false);
}
if(data=='No'){
	$("#submitb").attr("disabled", true);
Swal.fire({
icon: 'error',
text: 'বয়স এর কারণে আপনি এই পদে আবেদন করতে পারবেন না । কোটা  বা বিভাগীয় প্রাথী হলে OK ক্লিক করুন এবং ফর্মের নিচের দিকে  কোটা বা বিভাগীয় অপশন সিলেক্ট করলে আবেদন করতে পারবেন।',

});


}

      
    }
});
}

        });
    </script>

@endsection
