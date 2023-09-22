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
                            {{ $job->jobcurbday ? date("F j, Y", strtotime($job->jobcurbday)) :'' }}
                        </div>


                    </div>
                    
                  

                    {!! Form::open(['route' => array('jobApply'), 'files' => true,'id' => 'applicationForm', 'class' => 'applicationForm']) !!}
                    {!! Form::hidden('uuid', $uuid) !!}
                    {!! Form::hidden('RndID', $job->id, ['id'=>'RndID']) !!}
                    {!! Form::hidden('jobcurday', $job->jobcurbday ? $job->jobcurbday:'') !!}
                    {!! Form::hidden('age_calculation', $job->age_calculation) !!}
                    {!! Form::hidden('min_age', number_format($job->min_age,1)) !!}
                    {!! Form::hidden('max_age', number_format($job->max_age,1)) !!}
                    {!! Form::hidden('handicapped_age', number_format($job->handicapped_age,1)) !!}
                    {!! Form::hidden('divisioncaplicant_age', number_format($job->divisioncaplicant_age,1)) !!}
                    {!! Form::hidden('petition_age', number_format($job->petition_age,1)) !!}
                    {!! Form::hidden('freedom_fighter', number_format($job->freedom_fighter,1)) !!}
                     {!! Form::hidden('date_of_birth_cal', '') !!}
                    <?php
        if($job->min_education_con){
            echo Form::hidden('min_education_con', $job->min_education_con);
        }
                    ?>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            {{-- @include('layouts.shared.message') --}}
                            <div class="card">
                                <div class="card-header bg-secondary fw-bold text-white">
                                    ব্যক্তিগত তথ্য
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <td style="width: 40%">প্রার্থীর নাম ইংরেজীতে (বড় অক্ষরে) <span class="text-danger">*</span> </td>
                                            <td style="width: 60%"> {!! Form::text('name_en', null, array('placeholder' => '','class' => 'form-control')) !!}
                                                @if ($errors->has('name_en'))
                                                    <span class="text-danger">{{ $errors->first('name_en') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>প্রার্থীর নাম বাংলায় <span class="text-danger">*</span></td>
                                            <td> {!! Form::text('name_bn', null, array('placeholder' => '','class' => 'form-control banglainput','id'=>'name_bn')) !!}
                                                @if ($errors->has('name_bn'))
                                                    <span class="text-danger">{{ $errors->first('name_bn') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    
                                        <tr>
                                            <td>পিতার নাম <span class="text-danger">*</span></td>
                                            <td>{!! Form::text('father_name', null, array('placeholder' => '','class' => 'form-control banglainput')) !!}
                                                @if ($errors->has('father_name'))
                                                    <span class="text-danger">{{ $errors->first('father_name') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>মাতার নাম <span class="text-danger">*</span></td>
                                            <td>{!! Form::text('mother_name', null, array('placeholder' => '','class' => 'form-control banglainput')) !!}
                                                @if ($errors->has('mother_name'))
                                                    <span class="text-danger">{{ $errors->first('mother_name') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>জন্ম তারিখ <span class="text-danger">*</span></td>
                                            <td>{!! Form::text('date_of_birth', null, array('placeholder' => '','class' => 'form-control', 'id'=>'date_of_birth', 'autocomplete'=>'off')) !!}
                                                @if ($errors->has('date_of_birth'))
                                                    <span class="text-danger">{{ $errors->first('date_of_birth') }}</span>
                                                @endif
                                                  @if ($errors->has('date_of_birth_cal'))
                                                    <span class="text-danger">বয়স এর কারণে আপনি এই পদে আবেদন করতে পারবেন না!</span>
                                                @endif 
                                                <span class="text-danger date_of_birth"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>মোবাইল/টেলিফোন নম্বর <span class="text-danger">*</span></td>
                                            <td> {!! Form::text('mobile_no', null, array('placeholder' => '','class' => 'form-control banglainput',)) !!}
                                                @if ($errors->has('mobile_no'))
                                                    <span class="text-danger">{{ $errors->first('mobile_no') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>জাতীয় পরিচয় নম্বর/জন্ম নিবন্ধন নম্বর<span class="text-danger">*</span></td>
                                            <td> 
                                                {!! Form::select('nidorbrn',\App\Helpers\StaticValue::NIDORBRN,null,['class'=>'form-control select2 nidorbrn','placeholder'=>'' ,'id'=>'nidorbrn']) !!}
                                                @if (request()->get('nidorbrn'))
                                                {!! Form::text('nidorbrnnumber', request()->get('nidorbrnnumber'), array('placeholder' => '','class' => 'form-control banglainput nidorbrnnumber', 'required'=>true)) !!}
                                                @else
                                                {!! Form::text('nidorbrnnumber', null, array('placeholder' => '','class' => 'form-control banglainput nidorbrnnumber', 'required'=>true, 'style'=>'display:none')) !!}
                                                @endif
                                                
                                                
                                                @if ($errors->has('nidorbrnnumber'))
                                                    <span class="text-danger">{{ $errors->first('nidorbrnnumber') }}</span>
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
                                            <td> {!! Form::select('date_of_place',$district,null,['class'=>'form-control select2 banglainput','placeholder'=>'', 'id'=>'date_of_place']) !!}
                                                @if ($errors->has('date_of_place'))
                                                    <span class="text-danger">{{ $errors->first('date_of_place') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>পেশা</td>
                                            <td>{!! Form::text('occupation', null, array('placeholder' => '','class' => 'form-control banglainput')) !!}
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
                                            <td> {!! Form::text('present_house_no', null, array('placeholder' => '','class' => 'form-control banglainput','id'=>'present_house_no')) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>গ্রাম/পাড়া/মহল্লা</td>
                                            <td> {!! Form::text('present_village', null, array('placeholder' => '','class' => 'form-control banglainput','id'=>'present_village')) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>ইউনিয়ন/ওয়ার্ড</td>
                                            <td> {!! Form::text('present_union', null, array('placeholder' => '','class' => 'form-control banglainput','id'=>'present_union')) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>ডাকঘর <span class="text-danger">*</span></td>
                                            <td> {!! Form::text('present_postoffice', null, array('placeholder' => '','class' => 'form-control banglainput','id'=>'present_postoffice')) !!}
                                                @if ($errors->has('present_postoffice'))
                                                    <span class="text-danger">{{ $errors->first('present_postoffice') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>পোস্টকোড নম্বর <span class="text-danger">*</span></td>
                                            <td> {!! Form::text('present_postcode', null, array('placeholder' => '','class' => 'form-control banglainput','id'=>'present_postcode')) !!}
                                                @if ($errors->has('present_postcode'))
                                                    <span class="text-danger">{{ $errors->first('present_postcode') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>জেলা <span class="text-danger">*</span></td>
                                            <td>
                                                {!! Form::select('present_zilla',$district,null,['class'=>'form-control present_zilla ','placeholder'=>'','id'=>'present_zilla']) !!}
                                                @if ($errors->has('present_zilla'))
                                                    <span class="text-danger">{{ $errors->first('present_zilla') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>উপজেলা/থানা <span class="text-danger">*</span></td>
                                            <td>
                                                {!! Form::select('present_upozilla',$Upozilla,null,['class'=>'form-control present_upozilla','placeholder'=>'','id'=>'present_upozilla']) !!}
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
                                            <td> {!! Form::text('permanent_house_no', null, array('placeholder' => '','class' => 'form-control banglainput','id'=>'permanent_house_no')) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>গ্রাম/পাড়া/মহল্লা</td>
                                            <td> {!! Form::text('permanent_village', null, array('placeholder' => '','class' => 'form-control banglainput','id'=>'permanent_village')) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>ইউনিয়ন/ওয়ার্ড</td>
                                            <td> {!! Form::text('permanent_union', null, array('placeholder' => '','class' => 'form-control banglainput','id'=>'permanent_union')) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>ডাকঘর <span class="text-danger">*</span></td>
                                            <td> {!! Form::text('permanent_postoffice', null, array('placeholder' => '','class' => 'form-control banglainput','id'=>'permanent_postoffice')) !!}
                                                @if ($errors->has('permanent_postoffice'))
                                                    <span class="text-danger">{{ $errors->first('permanent_postoffice') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>পোস্টকোড নম্বর <span class="text-danger">*</span></td>
                                            <td> {!! Form::text('permanent_postcode', null, array('placeholder' => '','class' => 'form-control banglainput','id'=>'permanent_postcode')) !!}
                                                @if ($errors->has('permanent_postcode'))
                                                    <span class="text-danger">{{ $errors->first('permanent_postcode') }}</span>
                                                @endif</td>
                                        </tr>
                                        <tr>
                                            <td>জেলা <span class="text-danger">*</span></td>
                                            <td>
                                                {!! Form::select('permanent_zilla',$district,null,['class'=>'form-control permanent_zilla','placeholder'=>'','id'=>'permanent_zilla']) !!}
                                                @if ($errors->has('permanent_zilla'))
                                                    <span class="text-danger">{{ $errors->first('permanent_zilla') }}</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>উপজেলা/থানা <span class="text-danger">*</span></td>
                                            <td>
                                                {!! Form::select('permanent_upozilla',$Upozilla,null,['class'=>'form-control permanent_upozilla','placeholder'=>'','id'=>'permanent_upozilla']) !!}
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
                                                                        {!! Form::text('jscinstitute_name', null, array('placeholder' => '','class' => 'form-control banglainput')) !!}
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
                                                                        {!! Form::text('jscresult_score', null, array('placeholder' => '','class' => 'form-control banglainput jscresult_score','required'=>true, 'style'=>'display:none',)) !!}
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
                                                                        {!! Form::text('jscpassyear', null, array('placeholder' => '','class' => 'form-control banglainput')) !!}
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
                                                                            {!! Form::text('sscinstitute_name', null, array('placeholder' => '','class' => 'form-control banglainput')) !!}
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
                                                                            {!! Form::text('sscresult_score', null, array('placeholder' => '','class' => 'form-control sscresult_score banglainput',  'required'=>true, 'style'=>'display:none',)) !!}
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
                                                                            {!! Form::text('sscSubject_other', null, array('placeholder' => '', 'class' => 'form-control banglainput', 'id'=>'sscSubject_other', 'style'=>'display:none')) !!}
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
                                                                            {!! Form::text('sscpassyear', null, array('placeholder' => '','class' => 'form-control banglainput')) !!}
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
                                                                            {!! Form::text('hscinstitute_name', null, array('placeholder' => '','class' => 'form-control banglainput')) !!}
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
                                                                            {!! Form::text('hscresult_score', null, array('placeholder' => '','class' => 'form-control hscresult_score banglainput','required'=>true,'style'=>'display:none',)) !!}
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
                                                                            {!! Form::text('hscubject_other', null, array('placeholder' => '',  'class' => 'form-control banglainput', 'id'=>'hscubject_other', 'style'=>'display:none')) !!}
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
                                                                            {!! Form::text('hscpassyear', null, array('placeholder' => '','class' => 'form-control banglainput')) !!}
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
                                                                            {!! Form::text('graduationinstitute_name', null, array('placeholder' => '','class' => 'form-control banglainput')) !!}
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
                                                                            <?php
                                                                            $graduation = $job->graduation_result;
                                                                            $graduation_result= json_decode($graduation, true);
                                                                            $array_graduation= array_combine($graduation_result, $graduation_result);
                                
                                                                            ?>
                                                                           

                                                                            {!! Form::select('graduationresult',$array_graduation,null,['class'=>' select2 form-control','placeholder'=>'','id'=>'graduationresult']) !!}
                                                                            @if ($errors->has('graduationresult'))
                                                                                <span class="text-danger">{{ $errors->first('graduationresult') }}</span>
                                                                            @endif
                                                                            {!! Form::text('graduationresult_score', null, array('placeholder' => '','class' => 'form-control graduationresult_score banglainput','required'=>true, 'style'=>'display:none',)) !!}
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

                                                                            {!! Form::text('graduationsubject_other', null, array('placeholder' => '',  'class' => 'form-control banglainput', 'id'=>'graduationsubject_other', 'style'=>'display:none')) !!}
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
                                                                            {!! Form::text('graduationpassyear', null, array('placeholder' => '','class' => 'form-control banglainput')) !!}
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
                                                                            {!! Form::text('mastersinstitute_name', null, array('placeholder' => '','class' => 'form-control banglainput')) !!}
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
                                             <?php
                                            $dbValue = $job->masters_result;
                                            $masters_result = json_decode($dbValue, true);
                                           $array_masters= array_combine($masters_result, $masters_result);
                                            ?>

                                                                            {!! Form::select('mastersresult',$array_masters,null,['class'=>'select2 form-control','placeholder'=>'','id'=>'mastersresult']) !!}
                                                                            @if ($errors->has('mastersexamlevel'))
                                                                                <span class="text-danger">{{ $errors->first('mastersexamlevel') }}</span>
                                                                            @endif
                                                                            {!! Form::text('mastersresult_score', null, array('placeholder' => '','class' => 'form-control mastersresult_score banglainput','required'=>true, 'style'=>'display:none',)) !!}
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
                                                                            {!! Form::text('mastersSubject_other', null, array('placeholder' => '', 'class' => 'form-control banglainput', 'id'=>'mastersSubject_other', 'style'=>'display:none')) !!}
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
                                                                            {!! Form::text('masterspassyear', null, array('placeholder' => '','class' => 'form-control banglainput')) !!}
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
                                                            {{ $job->certificate_text}}
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
                                                                            {!! Form::text('certificateinstitute_name', null, array('placeholder' => '','class' => 'form-control banglainput')) !!}
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
                                                                            {!! Form::text('certificate_no', null, array('placeholder' => '','class' => 'form-control')) !!}
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
                                                                            {!! Form::text('certificate_expire', null, array('placeholder' => '','class' => 'form-control certificate_expire')) !!}
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
                                            {!! Form::textarea('extQualification', null, array('placeholder' => '', 'rows'=>'2', 'class' => 'form-control banglainput','id'=>'extQualification')) !!}

                                        </div>

                                        <div class="col-md-3">
                                            <label for="extrq1" class="form-label"> {{ $job->related_experience_text}}</label>
                                            <?php
                                            $dbValue = $job->related_experience;
                                            $related_experience = json_decode($dbValue, true);

                                            ?>

                                            {!! Form::select('Experience',$related_experience,null,['class'=>'form-control','placeholder'=>'','id'=>'Experience']) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <label for="extrq" class="form-label"> অভিজ্ঞতার বিবরণ (যদি থাকে)</label>
                                            {!! Form::textarea('experiencemonth', null, array('placeholder' => '', 'rows'=>'2', 'class' => 'form-control banglainput','id'=>'experiencemonth')) !!}
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

                                            {!! Form::select('experienceyear',array_merge($experience,['১২+'=>'১২+']),null,['class'=>'form-control','placeholder'=>'','id'=>'experienceyear']) !!}

                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 5px">
                                        <div class="col-md-3">
                                            <label for="extrq" class="form-label"> কোটা</label>
                                            {!! Form::select('quota[]',\App\Helpers\StaticValue::QTOTA,null,['class'=>'form-control quota','id'=>'quota', 'multiple'=>true]) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <label for="extrq" class="form-label">বিভাগীয় প্রার্থী কিনা</label>
                                            {!! Form::select('divisioncaplicant',\App\Helpers\StaticValue::DIVISIONAPPLIANT,null,['class'=>'form-control','placeholder'=>'','id'=>'divisioncaplicant']) !!}
                                        </div>
                                        @if($job->repetition)
                                        <div class="col-md-3">
                                            {{ Form::checkbox('repetition', '1', false, array( 'id'=>'repetition')) }}
                                            <label for="extrq" class="form-label">{{ $job->repetition}}</label>
                                        </div>
                                       @endif     
                                    </div>

                                    <div class="row" style="margin-top: 5px">
                                        <div class="col-md-6">
                                            <label for="formFile" class="form-label">প্রার্থীর ছবি <span class="text-danger">*</span></label>
                                            {!! Form::file('image', ['class'=>'form-control file-input']) !!}
                                            <div id="divImageMediaPreview"></div>
                                            @if ($errors->has('image'))
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="formFile1" class="form-label">প্রার্থীর স্বাক্ষর <span class="text-danger">*</span></label>
                                            {!! Form::file('signature', ['class'=>'form-control signature',]) !!}
                                            <div id="divImagesignaturePreview"></div>
                                            @if ($errors->has('signature'))
                                                <span class="text-danger">{{ $errors->first('signature') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label>
                                                <input class="checkbox" id="agree" name="agree" aria-required="true" type="checkbox">
                                              <span class="checkbox-container"> আমি এই মর্মে অঙ্গীকার করছি  যে, ওপরে বর্ণিত তথ্যাদি সম্পূর্ণ সত্য।  মৌখিক পরীক্ষার সময় উল্লেখিত তথ্য প্রমানের জন্য সকল মূল সার্টিফিকেট ও রেকর্ডপত্র উপস্থাপন করব।  কোন তথ্য অসত্য প্রমানিত হলে আইনানুগ শাস্তি ভোগ করতে বাধ্য থাকিব।</span>
                                            </label>
                                        </div>   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-7 ">
                            <button type="submit" class="btn btn-primary mt-4 btn-lg float-end" id="submitb">Submit Registration</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/bn.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery.bangla@1/dist/jquery.bangla.js"></script>
    <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
   
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
          //  $('.select2').bangla({ enable: true });

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
              //  minimumResultsForSearch: -1
            });

       $('.quota').select2({
                placeholder: 'নির্বাচন করুন',
                language: "bn",
            
            });
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

            $('#sscSubject_other').css("display","none")
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

$(".nidorbrn").change(function() {
    var nidorbrn = $('#nidorbrn').val(); 
    console.log(nidorbrn);
    $('.nidorbrnnumber').css("display","block")
    if(nidorbrn==='NID'){
        $(".nidorbrnnumber").attr("placeholder", "জাতীয় পরিচয় নম্বর লিখুন").val("").focus().blur();
    }
    else{
        $(".nidorbrnnumber").attr("placeholder", "জন্ম নিবন্ধন নম্বর লিখুন").val("").focus().blur();
    }
  

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
                    $('.graduationresult_score').css("display","none")
                }
            });

            $('#sscexamlevel').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                var selectElem = $("#sscsubject");
                
                // 
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
                     //   $('#sscsubject').attr("placeholder", "নির্বাচন করুন");
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

            $('#repetition').on('change', function (e) {
                var quota= $('#quota').val();
                var date_of_birth = $('#date_of_birth').val();
                var divisioncaplicant = $('#divisioncaplicant').val();
                console.log(quota);
                applicationAgeCalculation(date_of_birth, quota, divisioncaplicant);


                // if ($('input#repetition').is(':checked')) {
                //     $("#submitb").attr("disabled", false);
                // }
                // else{
                //     $("#submitb").attr("disabled", true);
                // }
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
                mobile_no: {
                    required: true,
                    maxlength:11
					
                },
                image: {
                    required: true,
                    extension: "jpeg|jpg|png",
				//	filesize : 102400
					
                },
                signature: {
                    required: true,
                    extension: "jpeg|jpg|png",
				//	 filesize : 102400
					
                },
                experiencemonth:
            {
                required: true,
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
               // mobile_no: "মোবাইল/টেলিফোন নম্বর লিখুন",
                mobile_no: {
					required: "মোবাইল/টেলিফোন নম্বর লিখুন",
                    maxlength: "অনুগ্রহ করে 11 নম্বরের বেশি লিখবেন না। যেমন ০১৭১১xxxxxx",
			
				},

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
        });

        function bangla_only_string(str, elm = null) {
    for (let i = 0; i < str.length; i++) {
        var charCode = str.charCodeAt(i);
        var res = ((charCode >= 2432 && charCode <= 2559) || charCode == 8 || charCode == 16 || charCode == 17 || charCode == 32 || charCode == 45 || charCode == 46 || charCode == 47 || charCode == 13 || charCode == 44 || charCode == 59 || charCode == 58 || charCode == 2404 || charCode == 40 || charCode == 41);
        if (!res) {
            if (elm) {

                alert('অবশ্যই বাংলা ইউনিকোড ফন্টে পূরণ করতে হবে!');
                $('#name_bn').val('');
                $(elm).focus();
            }
            return false;
        }
    }
    return true;
}

    </script>

@endsection
