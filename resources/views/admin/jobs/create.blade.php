<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ২০/১/২৩
 * Time: ১১:০৫ PM
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
            <h4 class="mb-1 mt-0">Add New Job</h4>
        </div>

    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('layouts.shared.message')
                    {!! Form::open(array('route' => 'jobs.store' ,'method'=>'post', 'files' => true)) !!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>Job Title</strong>
                                {!! Form::text('title', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>Job Description</strong>
                                {!! Form::textarea('description', null, array('placeholder' => '','class' => 'form-control','id'=>'description')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Application Deadline</strong>
                                {!! Form::text('application_deadline', null, array('placeholder' => '','class' => 'form-control', 'id'=>'application_deadline','autocomplete'=>'off')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Job ID</strong>
                                {!! Form::text('job_id', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Application Fee</strong>
                                {!! Form::text('apply_fee', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
{{--                        <div class="col-md-6">--}}
{{--                            <div class="form-group">--}}
{{--                                <strong>Minimum Education</strong>--}}
{{--                                {!! Form::select('min_education',\App\Helpers\StaticValue::MINEDUCATION,null,['class'=>'form-control','placeholder'=>'Select Minimum Education']) !!}--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Age Calculation Date</strong>
                                {!! Form::text('age_calculation', null, array('placeholder' => '','class' => 'form-control','id'=>'age_calculation','autocomplete'=>'off')) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>No. of Vacancies</strong>
                                {!! Form::text('vacancies', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Salary Range</strong>
                                {!! Form::text('salary_range', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Job Location</strong>
                                {!! Form::text('job_location', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Experience</strong>
                                {!! Form::text('job_experience', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Minimum Age</strong>
                                {!! Form::text('min_age', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Maximum Age</strong>
                                {!! Form::text('max_age', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Freedom fighter Age</strong>
                                {!! Form::text('freedom_fighter', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Handicapped Age</strong>
                                {!! Form::text('handicapped_age', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Petition Age Age</strong>
                                {!! Form::text('petition_age', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Division Age</strong>
                                {!! Form::text('divisioncaplicant_age', null, array('placeholder' => '','class' => 'form-control')) !!}
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
                                        {!! Form::select('min_education',$examLevels,null,['class'=>'form-control min_education','placeholder'=>'Select ','id'=>'min_education']) !!}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Condition</strong>
                                            {!! Form::select('min_education_con',['OR'=>'OR', 'AND'=>'AND'],null,['class'=>'form-control min_education','placeholder'=>'Select ','id'=>'min_education']) !!}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Education</strong>
                                            {!! Form::select('min_education_with',$examLevels,null,['class'=>'form-control min_education','placeholder'=>'Select ','id'=>'min_education']) !!}
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

                                            {{ Form::checkbox('JSCExam', 'JSC', false, array('id'=>'jsc')) }}
                                            {!! Form::label('JSC',  "JSC") !!}
                                        </div>
                                        <div class="col-md-6" id="JSCshow">

                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-3">
                                            {{ Form::checkbox('SSCExam', 'SSC', false, array('id'=>'SSC')) }}
                                            {!! Form::label('SSC',  "SSC") !!}
                                        </div>
                                        <div class="col-md-6" id="SSCshow">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            {{ Form::checkbox('HSCExam', 'HSC', false, array( 'id'=>'HSC')) }}
                                            {!! Form::label('HSC',  "HSC") !!}
                                        </div>
                                        <div class="col-md-3" id="HSCshow">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            {{ Form::checkbox('GradExam', 'graduation', false, array( 'id'=>'Grad')) }}
                                            {!! Form::label('Graduation/Equivalent Level',  "Graduation/Equivalent Level") !!}
                                        </div>
                                        <div class="col-md-3" id="Grad">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            {{ Form::checkbox('MastersExam', 'Masters', false, array( 'id'=>'Masters')) }}
                                            {!! Form::label('Masters/Equivalent Level',  "Masters/Equivalent Level") !!}
                                        </div>
                                        <div class="col-md-3" id="Masters">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            {{ Form::checkbox('certificates', 'YES', false, array( 'id'=>'certificates')) }}
                                            {!! Form::label('Certificates',  "Certificates") !!}
                                        </div>
                                        <div class="col-md-6" id="Certificateslist">

                                        </div>
                                        <div class="col-md-3" id="certificate_isrequired">
                                            {{ Form::checkbox('certificate_isrequired', '1', false, array( 'id'=>'certificates')) }}
                                            {!! Form::label('Is required?',  "Is required?") !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-lg"><i data-feather="save"></i> Save</button>
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
    <!-- optional plugins -->

@endsection

@section('script-bottom')
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
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
//             $('#jsc').on('click',function(e) {
// alert('dfdfd ffgf')
//             });
            // <input id="jsc" name="JSC" type="checkbox" value="JSC">
            /*
            $('#jsc, #SSC, #HSC, #Grad, #Masters').on('change', function() {
                if(this.checked) {
                    var val = this.checked ? this.value : '';
                    $.ajax({
                        url:"{{ route('educationtype') }}",
                        type:"GET",
                        data: {
                            type: val
                        },
                        success:function (data) {
                          //  console.log(data.data);
                          //  $("#"+val+'show').empty();
                           // console.log(val+'show');
                            $("#"+val+'show').html(data.data);

                            // $.each(data.data, function (i, ex) {
                            //     $('<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" id="'+val+'--'+ex.id+'" value="'+ex.id+'" name="'+val+'[]"><label class="form-check-label" for="'+val+'--'+ex.id+'" >' + ex.name + '</label></div>').appendTo($("div#"+val+'show'));
                            // });
                        }
                    })
                }
                else{
                    //alert($("div#"+$(this).val()+'show'));
                    $("div#"+$(this).val()+'show').empty();
                  // alert('uncheckd ' + $(this).val()+'show');
                }
            });
*/
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
                            //  console.log(data.data);
                              $("#Certificateslist").empty();
                            // console.log(val+'show');
                            $("#Certificateslist").html(data.data);

                            // $.each(data.data, function (i, ex) {
                            //     $('<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" id="'+val+'--'+ex.id+'" value="'+ex.id+'" name="'+val+'[]"><label class="form-check-label" for="'+val+'--'+ex.id+'" >' + ex.name + '</label></div>').appendTo($("div#"+val+'show'));
                            // });
                        }
                    })
                }

            });
        } );

    </script>

@endsection
