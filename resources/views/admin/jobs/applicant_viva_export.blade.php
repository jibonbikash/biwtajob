<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ২১/১/২৩
 * Time: ৮:৫১ PM
 * Copyright jibon <jibon.bikash@gmail.com>
 */
?>
@extends('layouts.non-auth')
@section('title', 'Applicant List(Viva)')

@section('content')
    <div class="row filedlist">
    <div class="col-md-12 mt-3 ml-2 mr-2">
        @foreach(\App\Helpers\StaticValue::DYNAMIC_FIELDS_VIVA as $field => $label)

            {{ Form::checkbox($field, $value = 1, false, ['class'=>$field, 'onchange'=>'toggleCheckbox(this)']) }}
            {{ Form::label($field, $label, ['class' => '']) }}

        @endforeach
    </div>
    </div>


        <table class="table table-striped table-hover table-bordered">
            <thead class="table-info">
            <tr>
                <th scope="col">#</th>
                <th scope="col" class="roll">রোল</th>
                <th scope="col" class="job_position">পদের নাম</th>
                <th scope="col" class="photo">ছবি</th>
                <th scope="col" class="code_name">কোড</th>
                <th scope="col" class="name_bn"> নাম</th>
                <th scope="col" class="father_name">পিতার নাম</th>
                <th scope="col" class="mobile">মোবাইল</th>
                <th scope="col" class="gender_name">জেন্ডার</th>
                <th scope="col" class="bplace_name">নিজ জেলা</th>
                <th scope="col" class="exam_time_place">পরীক্ষার সময় ও স্থান </th>
                <th scope="col" class="pr_house_pr_village_pr_union_pr_postoffice_pr_postcode">স্থায়ী  ঠিকানা</th>

                <th scope="col" class="educations_name">শিক্ষাগত যোগ্যতা</th>
                <th scope="col" class="experience_name">সংশ্লিষ্ট ক্ষেত্রে অভিজ্ঞতা</th>
                <th scope="col" class="experiencemonth_name">অভিজ্ঞতার  বিবরণ</th>
                <th scope="col" class="experienceyear_name">অভিজ্ঞতার মেয়াদ</th>
                <th scope="col" class="quota_name">কোটা</th>
                <th scope="col" class="division_appli_name">বিভাগীয়</th>
            </tr>
            </thead>
            <tbody>
            @foreach($applicants as $applicant)
                <tr>
                    <td scope="row">{{ $loop->iteration}}</td>
                    <td class="roll">
                        {{ $applicant->roll }}
                    </td>
                    <td class="job_position">
                        <span title="{{ $applicant->job ? $applicant->job->title:'' }}">{!! Str::words($applicant->job ? $applicant->job->title:'', 5, ' ...') !!}</span>
                    </td>
                    <td class="photo">
                        <img src="{{ \App\Helpers\StaticValue::getDirecrotory($applicant->job->job_id, \Carbon\Carbon::parse($applicant->job->created_at)->format('Y')) }}/{{ $applicant->picture }}" width="80">

                    </td>
                    <td class="code_name">
                        {{ $applicant->applicant ? $applicant->applicant->code:'---' }}
                    </td class="job_position">
                    <td class="name_bn">
                        {{ $applicant->applicant ? $applicant->applicant->name_bn:'' }}
                    </td>
                    <td class="father_name">
                        {{ $applicant->applicant ? $applicant->applicant->father_name:'' }}
                    </td>
                    <td class="mobile">
                        {{ $applicant->applicant ? $applicant->applicant->mobile:'' }}
                    </td>

                    <td class="gender_name">
                        {{ $applicant->applicant ? $applicant->applicant->gender:'' }}
                    </td>
                    <td class="bplace_name">
                        {{ $applicant->applicant->birthplace ? $applicant->applicant->birthplace->zilla_name :'' }}

                    </td>
                    <td class="exam_time_place">
                        স্থান: {{ $applicant->place }}<br/>
                        পরীক্ষার সময়: {{ $applicant->date }} -
                        {{ $applicant->time }}<br/>
                    </td>
                    <td class="pr_house_pr_village_pr_union_pr_postoffice_pr_postcode">
                        বাসা ও সড়ক (নাম/নম্বর): {{ $applicant->pr_house }}<br />
                        গ্রাম/পাড়া/মহল্লা: {{ $applicant->pr_village }}<br />
                        ইউনিয়ন/ওয়ার্ড: {{ $applicant->pr_union }}<br />
                        ডাকঘর: {{ $applicant->pr_postoffice }}<br />
                        পোস্টকোড: {{ $applicant->pr_postcode }}<br />
                        উপজেলা /থানা:{{ $applicant->permanentupozilla ? $applicant->permanentupozilla->upozilla:'' }}<br />
                        জেলা: {{ $applicant->permanentzila ? $applicant->permanentzila->zilla_name:'' }}

                    </td>

                    <td class="educations_name">
                        @foreach($applicant->applicant->educations as $education)
                            পরীক্ষার নাম: {{ $education->examLevelGroups ? $education->examLevelGroups->name :'---' }} <br />
                            বিষয়:  @if ($education->other)
                                {{ $education->other }}
                            @else
                                {{ $education->ExamlevelSubject ? $education->ExamlevelSubject->name :'' }}<br />
                            @endif
                        @endforeach
                    </td>

                    <td class="experience_name">{{ $applicant->applicant->experience }}</td>
                    <td class="experiencemonth_name">{{ $applicant->applicant->experiencemonth }}</td>
                    <td class="experienceyear_name">{{ $applicant->applicant->experienceyear }}</td>
                    <td class="quota_name">
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
                    <td class="division_appli_name">{{ $applicant->applicant->division_appli }}</td>


                </tr>

            @endforeach
            </tbody>
        </table>



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
        }
            @media print {
                .filedlist {
                    visibility: hidden;
                }
            }
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

        function toggleCheckbox(checkbox)
        {

            var className = checkbox.className;
            var thElement = $('th.' + className);
            var tdElement = $('td.' + className);
            // Check if the checkbox is checked
            if (checkbox.checked) {
                tdElement.hide();
                thElement.hide();
            } else {
                tdElement.show();
                thElement.show();

            }

            //  console.log(checkbox.checked)

        }

    </script>

@endsection
