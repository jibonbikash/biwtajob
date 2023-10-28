<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ২১/১/২৩
 * Time: ৭:৫৮ PM
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
            <h4 class="mb-1 mt-0">Update Job</h4>
        </div>

    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('layouts.shared.message')
                    {!! Form::open(array('route' => array('jobs.update', $job->id) ,'method'=>'PATCH', 'files' => true)) !!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>Job Title</strong>
                                {!! Form::text('title', $job->title, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>Job Description</strong>
                                {!! Form::textarea('description', $job->description, array('placeholder' => '','class' => 'form-control','id'=>'description')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Application Deadline</strong>
                                {!! Form::text('application_deadline', $job->application_deadline, array('placeholder' => '','class' => 'form-control', 'id'=>'application_deadline')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Job ID</strong>
                                {!! Form::text('job_id', $job->job_id, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Job Circular</strong>
                                {!! Form::text('circular_no', $job->circular_no, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Application Fee</strong>
                                {!! Form::text('apply_fee', $job->apply_fee, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Minimum Education</strong>
                                {!! Form::select('min_education',\App\Helpers\StaticValue::MINEDUCATION,$job->min_education,['class'=>'form-control','placeholder'=>'Select Minimum Education']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Age Calculation Date</strong>
                                {!! Form::text('age_calculation', $job->age_calculation, array('placeholder' => '','class' => 'form-control','id'=>'age_calculation')) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Job circular Date</strong>
                                {!! Form::text('jobcurbday', $job->jobcurbday, array('placeholder' => '','class' => 'form-control','id'=>'jobcurbday','autocomplete'=>'off')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>No. of Vacancies</strong>
                                {!! Form::text('vacancies', $job->vacancies, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Salary Range</strong>
                                {!! Form::text('salary_range', $job->salary_range, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Job Location</strong>
                                {!! Form::text('job_location', $job->job_location, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Experience</strong>
                                {!! Form::text('job_experience', $job->job_experience, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Minimum Age</strong>
                                {!! Form::text('min_age', $job->min_age, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Maximum Age</strong>
                                {!! Form::text('max_age', $job->max_age, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Freedom fighter Age</strong>
                                {!! Form::text('freedom_fighter', $job->freedom_fighter, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Handicapped Age</strong>
                                {!! Form::text('handicapped_age', $job->handicapped_age, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Petition Age</strong>
                                {!! Form::text('petition_age', $job->petition_age, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Division Age</strong>
                                {!! Form::text('divisioncaplicant_age', $job->divisioncaplicant_age, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card-header">
                                <h5>Minimum Education</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Education</strong>

                                        {!! Form::select('min_education',$examLevels,$job->min_education,['class'=>'form-control min_education','placeholder'=>'Select ','id'=>'min_education']) !!}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Condition</strong>
                                        {!! Form::select('min_education_con',['OR'=>'OR', 'AND'=>'AND'],$job->min_education_con,['class'=>'form-control min_education','placeholder'=>'Select ','id'=>'min_education']) !!}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Education</strong>
                                        {!! Form::select('min_education_with',$examLevels,$job->min_education_with,['class'=>'form-control min_education','placeholder'=>'Select ','id'=>'min_education']) !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Required Education Setting</h5>
                                </div>
                                <div class="card-body">

                                    <div class="row mt-2">
                                        <div class="col-md-3">

                                            {{ Form::checkbox('JSCExam', 'JSC', $job->jsc, array('id'=>'jsc')) }}
                                            {!! Form::label('JSC',  "জে এস সি") !!}
                                        </div>
                                        <div class="col-md-6" id="JSCshow">

                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-3">
                                            {{ Form::checkbox('SSCExam', 'SSC', $job->ssc, array('id'=>'SSC')) }}
                                            {!! Form::label('SSC',  "এস এস সি") !!}
                                        </div>
                                        <div class="col-md-6" id="SSCshow">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            {{ Form::checkbox('HSCExam', 'HSC', $job->hsc, array( 'id'=>'HSC')) }}
                                            {!! Form::label('HSC',  "এইচ এস সি") !!}
                                        </div>
                                        <div class="col-md-3" id="HSCshow">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            {{ Form::checkbox('GradExam', 'graduation', $job->graduation, array( 'id'=>'Grad')) }}
                                            {!! Form::label('Graduation/Equivalent Level',  "স্নাতক ডিগ্রী") !!}
                                        </div>
                                        <div class="col-md-3" id="Grad">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            {{ Form::checkbox('MastersExam', 'Masters', $job->masters, array( 'id'=>'Masters')) }}
                                            {!! Form::label('Masters/Equivalent Level',  "মাস্টার্স / স্নাতকোত্তর") !!}
                                        </div>
                                        <div class="col-md-3" id="Masters">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            {{ Form::checkbox('certificates', 'YES', $job->certificate, array( 'id'=>'certificates')) }}
                                            {!! Form::label('Certificates',  "Certificates") !!}
                                        </div>
                                        <div class="col-md-6" id="Certificateslist">
                                            {!! Form::text('certificate_text', $job->certificate_text, array('placeholder' => 'Certificate Text Heading','class' => 'form-control')) !!}
                                        <div id="Certificateslistname"></div>
                                        </div>
                                        <div class="col-md-3" id="certificate_isrequired">
                                            {{ Form::checkbox('certificate_isrequired', '1', $job->certificate_isrequired, array( 'id'=>'certificatesre')) }}
                                            {!! Form::label('Is required?',  "Is required?") !!}
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Others Setting</h5>
                                </div>
                                <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Experience in related field Text </strong>
                                        {!! Form::text('related_experience_text', $job->related_experience_text, array('placeholder' => '','class' => 'form-control')) !!}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Experience in related field selection </strong>
                                        <?php
$dbValue = $job->related_experience;
$myArray = json_decode($dbValue, true);

$graduation_result= $job->graduation_result;
$graduation_result= json_decode($graduation_result, true);

$masters_result= $job->masters_result;
$masters_result= json_decode($masters_result, true);


?>

                                        {!! Form::select('related_experience[]',\App\Helpers\StaticValue::RELATED_EXPERIENCE,$myArray,['class'=>'form-control select2','id'=>'related_experience', 'multiple'=>true, ]) !!}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Writ Petitioner  </strong>
                                        {!! Form::text('repetition', $job->repetition, array('placeholder' => '','class' => 'form-control')) !!}
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <strong>Minimum Duration of Experience (Years)</strong>
                                        {!! Form::number('minimum_job_experience', $job->minimum_job_experience, array('placeholder' => '','class' => 'form-control')) !!}
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <strong>Graduation/Equivalent grade/class </strong>
                                        {!! Form::select('Graduation_grade[]',\App\Helpers\StaticValue::RESULTSSC,$graduation_result,['class'=>'form-control select2','id'=>'Graduation_grade', 'multiple'=>true, ]) !!}
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <strong>Masters/Equivalent grade/class</strong>
                                        {!! Form::select('Masters_grade[]',\App\Helpers\StaticValue::RESULTSSC,$masters_result,['class'=>'form-control select2','id'=>'Masters_grade', 'multiple'=>true, ]) !!}
                                    </div>

                                </div>
                            </div>

                                </div>

                            </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Status</strong>
                            {!! Form::select('status',\App\Helpers\StaticValue::STATUS_ADMIN,$job->status,['class'=>'form-control','placeholder'=>'Select ']) !!}

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-lg"><i data-feather="save"></i> Update</button>
                            </div>
                        </div>

                    </div>
                    {!! Form::close() !!}
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

    </div>



    <!-- end row -->
@endsection

@section('script')

<style>
    .select2-container .select2-selection--multiple .select2-selection__choice{
        background-color: #5369f8 !important;
    }
     </style>
@endsection

@section('script-bottom')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/libs/multiselect/multiselect.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/multiselect/multiselect.min.js') }}"></script>
    <script type="text/javascript">
        CKEDITOR.replace('description', {
            filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        $( function() {
            $( "#application_deadline" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd"
            });
            $( "#age_calculation" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd"
            });

            $( "#jobcurbday" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd"
            });

            $('.select2').select2({
                placeholder: 'নির্বাচন করুন',
                language: "bn",
                minimumResultsForSearch: -1
            });

            $('#certificates').on('change', function() {
                if(this.checked) {
                    var val = this.checked ? this.value : '';
                    $.ajax({
                        url:"{{ route('admin.certificateslist') }}",
                        type:"GET",
                        data: {
                            type: val
                        },
                        success:function (data) {
                            $("#Certificateslistname").empty();
                            $("#Certificateslistname").html(data.data);
                        }
                    })
                }
                else{
                    $("#Certificateslistname").empty();
                }
            });

        } );
    </script>

@endsection

