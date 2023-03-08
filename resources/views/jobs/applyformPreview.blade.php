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
            <div class="card">
                <div class="card-header bg-success text-white">
                    Application Preview
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-2 fw-bold">পদের নাম</div>
                        <div class="col-md-10">
                            {{$applicationinfo->job ? $applicationinfo->job->title:''}}
                        </div>
                        <div class="col-md-2 fw-bold">নিয়োগ বিজ্ঞপ্তি নম্বর</div>
                        <div class="col-md-10">

                            {{$applicationinfo->job ? $applicationinfo->job->job_id:''}}
                        </div>

                        <div class="col-md-2 fw-bold">বিজ্ঞপ্তি তারিখ</div>
                        <div class="col-md-10">

                            {{$applicationinfo->job ? $applicationinfo->job->jobcurbday:''}}
                        </div>


                    </div>

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
                                            <td style="width: 30%">প্রার্থীর নাম ইংরেজীতে (বড় অক্ষরে) </td>
                                            <td>
                                                {{ $applicationinfo->name_en }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>প্রার্থীর নাম বাংলায় </td>
                                            <td>
                                                {{ $applicationinfo->name_bn }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>পিতার নাম </td>
                                            <td>
                                                {{ $applicationinfo->father_name }}

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>মাতার নাম </td>
                                            <td> {{ $applicationinfo->mother_name }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>জন্ম তারিখ </td>
                                            <td>
                                                {{ Carbon\Carbon::parse($applicationinfo->bday)->format('F j, Y') }}


                                            </td>
                                        </tr>
                                        <tr>
                                            <td>মোবাইল/টেলিফোন নম্বর </td>
                                            <td>
                                                {{ $applicationinfo->mother_name }}

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>জাতীয় পরিচয় নম্বর </td>
                                            <td>
                                                {{ $applicationinfo->nid }}

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>জাতীয়তা </td>
                                            <td>
                                                {{ $applicationinfo->nationality }}

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>ধর্ম </td>
                                            <td>
                                                {{ $applicationinfo->religious }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>জেন্ডার </td>
                                            <td>
                                                {{ $applicationinfo->gender }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>জন্ম স্থান (জেলা)</td>
                                            <td>
                                                {{ $applicationinfo->birthplace? $applicationinfo->birthplace->zilla_name:'' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>পেশা</td>
                                            <td>
                                                {{ $applicationinfo->occupation }}

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
                                            <td>
                                                {{ $applicationinfo->pa_house }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>গ্রাম/পাড়া/মহল্লা</td>
                                            <td>
                                                {{ $applicationinfo->pa_village }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>ইউনিয়ন/ওয়ার্ড</td>
                                            <td>
                                                {{ $applicationinfo->pa_union }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>ডাকঘর </td>
                                            <td>
                                                {{ $applicationinfo->pa_postoffice }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>পোস্টকোড নম্বর </td>
                                            <td>
                                                {{ $applicationinfo->pa_postcode }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>জেলা </td>
                                            <td>
                                                {{ $applicationinfo->zila ? $applicationinfo->zila->zilla_name:'' }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>উপজেলা/থানা </td>
                                            <td>
                                                {{ $applicationinfo->upozilla ? $applicationinfo->upozilla->upozilla:'' }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-secondary fw-bold text-white">স্থায়ী ঠিকানা </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <td>বাসা ও সড়ক (নাম/নম্বর)</td>
                                            <td>
                                                {{ $applicationinfo->pr_house }}

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>গ্রাম/পাড়া/মহল্লা</td>
                                            <td>
                                                {{ $applicationinfo->pr_village }}</td>
                                        </tr>
                                        <tr>
                                            <td>ইউনিয়ন/ওয়ার্ড</td>
                                            <td>
                                                {{ $applicationinfo->pr_union }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>ডাকঘর </td>
                                            <td>
                                                {{ $applicationinfo->pr_postoffice }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>পোস্টকোড নম্বর </td>
                                            <td>
                                                {{ $applicationinfo->pr_postcode }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>জেলা </td>
                                            <td>
                                                {{ $applicationinfo->permanentzila ? $applicationinfo->permanentzila->zilla_name:'' }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>উপজেলা/থানা </td>
                                            <td>
                                                {{ $applicationinfo->permanentzila ? $applicationinfo->permanentzila->upozilla:'' }}
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
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>পরীক্ষার নাম</th>
                                                    <th>বিষয়</th>
                                                    <th>শিক্ষা প্রতিষ্ঠান</th>
                                                    <th>পাসের সন</th>
                                                    <th>বোর্ড/বিশ্ববিদ্যালয়</th>
                                                    <th>গ্রেড/শ্রেণি/বিভাগ</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($applicationinfo->educations as $education)
                                                    <tr>
                                                        <td>{{ $education->examLevelGroups ? $education->examLevelGroups->name :'---' }}</td>
                                                        <td>{{ $education->ExamlevelSubject ? $education->ExamlevelSubject->name :'' }}</td>
                                                        <td>{{ $education->institute_name }} </td>
                                                        <td>{{ $education->passing_year }} </td>
                                                        <td>
                                                            @php
                                                                if(in_array($education->examLevelGroups ? $education->examLevelGroups->examlevel_id:0, range(1, 3))) {
   echo \App\Models\Board::find($education->board_university)->name;

    }
    else{
        echo 'university';

    }

                                                            @endphp
{{--                                                            {{ $education->board_university }}--}}
                                                        </td>
                                                        <td>{{ $education->result }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>



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
                                            <label for="extrq" class="form-label"> অতিরিক্ত যোগ্যতা (যদি থাকে)</label><br />
                                            {{ $applicationinfo->extra_qualification }}

                                        </div>

                                        <div class="col-md-3">
                                            <label for="extrq1" class="form-label"> সংশ্লিষ্ট ক্ষেত্রে অভিজ্ঞতা</label> <br />
                                            {{ $applicationinfo->experience }}
                                        </div>
                                        <div class="col-md-3">
                                            <label for="extrq" class="form-label"> অভিজ্ঞতার বিবরণ (যদি থাকে)</label>
                                            {!! Form::textarea('experiencemonth', null, array('placeholder' => '', 'rows'=>'2', 'class' => 'form-control','id'=>'experiencemonth')) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <label for="extrq" class="form-label">অভিজ্ঞতার মেয়াদ (বৎসর )</label><br />
                                            {{ $applicationinfo->experienceyear }}


                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 5px">
                                        <div class="col-md-3">
                                            <label for="extrq" class="form-label"> কোটা</label><br />
                                            {{ $applicationinfo->quota }}
                                        </div>
                                        <div class="col-md-3">
                                            <label for="extrq" class="form-label">বিভাগীয় প্রার্থী কিনা</label><br />
                                            {{ $applicationinfo->division_appli }}
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 5px">
                                        <div class="col-md-6">
                                            <label for="formFile" class="form-label">প্রার্থীর ছবি </label><br />

                                        </div>
                                        <div class="col-md-6">
                                            <label for="formFile1" class="form-label">প্রার্থীর স্বাক্ষর </label><br />

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-6 ">
                            <a href="#" class="btn btn-primary mt-4 btn-lg float-start"><i data-feather="edit"></i> Edit Information</a> &nbsp;&nbsp;
                        </div>
                        <div class="col-md-6 ">
                            <button type="submit" class="btn btn-success mt-4 btn-lg float-end"><i data-feather="send"></i> Submit Application</button>
                        </div>

                    </div>


                </div>

            </div>

        </div>
    </div>
@endsection
@section('script-bottom')

@endsection