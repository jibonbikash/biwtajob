<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ১১/৩/২৩
 * Time: ৩:৩৬ PM
 * Copyright jibon <jibon.bikash@gmail.com>
 */
$sscList= collect($joninfo->examSubject);
?>

@extends('layouts.vertical')


@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="{{ URL::asset('assets/css/jquery.toast.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <div class="row page-title align-items-center">
        <div class="col-sm-4 col-xl-6">
            <h4 class="mb-1 mt-0">Job Setting</h4>
        </div>
        <div class="col-sm-6 col-xl-6">
            <a href="{{route('jobs.index')}}" class="btn btn-info btn-lg float-right"><i data-feather="arrow-left-circle"></i> Back</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('layouts.shared.message')
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(array('route' => ['jobs.settingsave', $joninfo->id] ,'method'=>'POST', 'files' => false)) !!}
                            <div class="row">
                                <div class="col-md-12">
                                <div class="card mt-4 border border-info rounded">
                                    <div class="card-header bg-soft-info" id="accordionExample">
                                      Education Setting
                                    </div>
                                    <div class="card-body">
{{--                                        @if($joninfo->ssc)--}}
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card border mt-4 rounded">
                                                        <div class="card-header">
                                                            <a href="" class="text-dark" data-toggle="collapse"
                                                               data-target="#collapseOne" aria-expanded="true"
                                                               aria-controls="collapseOne">
                                                                <div class="card-header" id="headingOne">
                                                                    <h5 class="m-0 font-size-16">
                                                                        SSC Equivalent <i
                                                                            class="uil uil-angle-down float-right accordion-arrow"></i>
                                                                    </h5>
                                                                </div>
                                                            </a>

                                                        </div>
                                                        <div class="card-body collapse show" id="collapseOne" ria-labelledby="headingOne"
                                                             data-parent="#accordionExample">
                                                            <?php
                                                            $SSC = \App\Models\ExamlevelGroup::where('examlevel_id', 2)
                                                                ->get();

                                                            ?>
                                                            @foreach($SSC as $examssc)
                                                                <?php
                                                                   $name= \App\Helpers\StaticValue::clean($examssc->name);
                                                                 $sscSubjectList= collect($sscList)->where('examlevel_group_id', $examssc->id)->pluck('examlevel_subject_id','examlevel_subject_id')->all();

                                                                ?>
                                                                <div
                                                                    class="row border border-primary rounded pt-2 mb-2">
                                                                    <div class="col-md-3">
                                                                        {{ Form::checkbox('SSCExam[]', $examssc->id, false, array( 'id'=>$name, 'onclick'=>'ExamLevel("'.$name.'");')) }}
                                                                        {!! Form::label('SSC',  $examssc->name) !!}
                                                                    </div>
                                                                    <div class="col-md-8 {{$name}}"
                                                                         id="{{$name}}"  style="display: none">
                                                                        <?php
                                                                        $sscsubjects = \App\Models\ExamlevelSubject::where('examlevel_id', 2)->where('examlevel_group_id', $examssc->id)
                                                                            ->get();
                                                                          //  $sscsubjectss = collect($sscsubjects)->pluck('name','id')])

                                                                            $sscsubjectss = \App\Models\ExamlevelSubject::where('examlevel_id', 2)->where('examlevel_group_id', $examssc->id)->pluck('name','id');
                                                                        ?>

                                                                        @foreach($sscsubjects as $subjects)
                                                                            {{ Form::checkbox('sscExamsubject[]', $subjects->id, in_array($subjects->id, $sscSubjectList) ? true : false, array( 'id'=>$name,'class'=>$name)) }}
                                                                            {!! Form::label('SSCSubject',  $subjects->name) !!}
                                                                        @endforeach

                                                                    </div>
                                                                    <div class="col-md-1 {{\App\Helpers\StaticValue::clean($examssc->name)}}" style="display: none">
@if(count($sscsubjects) > 0)


                                                                            <input type="checkbox" id="all_{{$name}}"  onclick="all_check('{{$name}}')" class="css-checkbox"  name="{{$name}}"/>Selectall<br>
                                                                        <button type="button" class="btn btn-success btn-lg mb-2" onclick="save('sscExamsubject','ssc', {{$examssc->id}})"><i data-feather="save"></i> Save</button>
                                                                        @endif
                                                                </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
{{--                                        @endif--}}
{{--                                        @if($joninfo->hsc)--}}
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card border mt-4 rounded">
                                                        <div class="card-header">
                                                            <a href="" class="text-dark" data-toggle="collapse"
                                                               data-target="#collapseTwo" aria-expanded="true"
                                                               aria-controls="collapseOne">
                                                                <div class="card-header" id="headingTwo">
                                                                    <h5 class="m-0 font-size-16">
                                                                        H.S.C Equivalent <i
                                                                            class="uil uil-angle-down float-right accordion-arrow"></i>
                                                                    </h5>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="card-body collapse" id="collapseTwo" ria-labelledby="headingTwo"
                                                             data-parent="#accordionExample">
                                                            <?php
                                                            $hsc = \App\Models\ExamlevelGroup::where('examlevel_id', 3)
                                                                ->get();

                                                            ?>
                                                            @foreach($hsc as $examHSC)
                                                                    <?php
                                                                $name= \App\Helpers\StaticValue::clean($examHSC->name);

                                                                    $HSCSubjectList= collect($sscList)->where('examlevel_group_id', $examHSC->id)->pluck('examlevel_subject_id','examlevel_subject_id')->all();

                                                                    ?>
                                                                <div
                                                                    class="row border border-primary rounded pt-2 mb-2">
                                                                    <div class="col-md-3">
                                                                        {{ Form::checkbox('HSCExam[]', $examHSC->id, false, array( 'id'=>$name, 'onclick'=>'ExamLevel("'.$name.'");')) }}
                                                                        {!! Form::label('HSC',  $examHSC->name) !!}
                                                                    </div>
                                                                    <div class="col-md-8 {{$name}}"
                                                                         id="{{$name}}" style="display: none">
                                                                        <?php
                                                                        $hscsubjects = \App\Models\ExamlevelSubject::where('examlevel_id', 3)->where('examlevel_group_id', $examHSC->id)
                                                                            ->get();
                                                                        ?>
                                                                        @foreach($hscsubjects as $subjects)
                                                                            {{ Form::checkbox('HSCExamsubject[]', $subjects->id, in_array($subjects->id, $HSCSubjectList) ? true : false, array( 'id'=>$name,'class'=>$name)) }}
                                                                            {!! Form::label('HSCSubject',  $subjects->name) !!}
                                                                        @endforeach

                                                                    </div>
                                                                    <div class="col-md-1 {{$name}}" style="display: none">
                                                                        @if(count($hscsubjects) > 0)
                                                                            <input type="checkbox" id="all_{{$name}}"  onclick="all_check('{{$name}}')" class="css-checkbox"  name="{{$name}}"/>Selectall<br>
                                                                                <button type="button" class="btn btn-success btn-lg mb-2" onclick="save('HSCExamsubject','hsc', {{$examHSC->id}})"><i data-feather="save"></i> Save</button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
{{--                                        @endif--}}
{{--                                        @if($joninfo->graduation)--}}
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card mt-4 border rounded">
                                                        <div class="card-header">
                                                            <a href="" class="text-dark" data-toggle="collapse"
                                                               data-target="#collapseThree" aria-expanded="true"
                                                               aria-controls="collapseThree">
                                                                <div class="card-header" id="headingThree">
                                                                    <h5 class="m-0 font-size-16">
                                                                        Graduation <i class="uil uil-angle-down float-right accordion-arrow"></i>
                                                                    </h5>
                                                                </div>
                                                            </a>


                                                        </div>
                                                        <div class="card-body collapse" id="collapseThree" ria-labelledby="headingThree"
                                                             data-parent="#accordionExample">
                                                            <?php
                                                            $Graduation = \App\Models\ExamlevelGroup::where('examlevel_id', 4)
                                                                ->get();

                                                            ?>
                                                            @foreach($Graduation as $examGraduation)
                                                                    <?php
                                                                    $name= \App\Helpers\StaticValue::clean($examGraduation->name);
                                                                    $GraduationSubjectList= collect($sscList)->where('examlevel_group_id', $examGraduation->id)->pluck('examlevel_subject_id','examlevel_subject_id')->all();

                                                                    ?>

                                                                <div
                                                                    class="row border border-primary rounded pt-2 mb-2">
                                                                    <div class="col-md-3">
                                                                        {{ Form::checkbox('GraduationExam[]', $examGraduation->id, false, array( 'id'=>$name, 'onclick'=>'ExamLevel("'.$name.'");')) }}
                                                                        {!! Form::label('Graduation',  $examGraduation->name) !!}
                                                                    </div>
                                                                    <div class="col-md-8 {{$name}}"
                                                                         id="{{$name}}" style="display: none">

                                                                        <?php
                                                                        $Graduationsubjects = \App\Models\ExamlevelSubject::where('examlevel_id', 4)->where('examlevel_group_id', $examGraduation->id)
                                                                            ->get();
                                                                        ?>
                                                                        @foreach($Graduationsubjects as $subjects)
                                                                            {{ Form::checkbox('GraduationExamsubject[]', $subjects->id, in_array($subjects->id, $GraduationSubjectList) ? true : false, array( 'id'=>$name,'class'=>$name)) }}
                                                                            {!! Form::label('GraduationSubject',  $subjects->name) !!}
                                                                        @endforeach

                                                                    </div>
                                                                    <div class="col-md-1 {{$name}}" style="display: none">
                                                                        @if(count($Graduationsubjects) > 0)
                                                                            <input type="checkbox" id="all_{{$name}}"  onclick="all_check('{{$name}}')" class="css-checkbox"  name="{{$name}}"/>Selectall<br>
                                                                            <button type="button" class="btn btn-success btn-lg mb-2" onclick="save('GraduationExamsubject','graduation', {{$examGraduation->id}})"><i data-feather="save"></i> Save</button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
{{--                                        @endif--}}
{{--                                        @if($joninfo->masters)--}}
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card mt-4 border rounded rounded">
                                                        <div class="card-header">

                                                            <a href="" class="text-dark" data-toggle="collapse"
                                                               data-target="#collapseFour" aria-expanded="true"
                                                               aria-controls="collapseFour">
                                                                <div class="card-header" id="headingFour">
                                                                    <h5 class="m-0 font-size-16">
                                                                        Masters <i class="uil uil-angle-down float-right accordion-arrow"></i>
                                                                    </h5>
                                                                </div>
                                                            </a>

                                                        </div>
                                                        <div class="card-body collapse" id="collapseFour" ria-labelledby="headingFour"
                                                             data-parent="#accordionExample">
                                                            <?php
                                                            $Masters = \App\Models\ExamlevelGroup::where('examlevel_id', 5)
                                                                ->get();

                                                            ?>
                                                            @foreach($Masters as $Master)
                                                                    <?php
                                                                    $name= \App\Helpers\StaticValue::clean($Master->name);
                                                                    $MastersSubjectList= collect($sscList)->where('examlevel_group_id', $Master->id)->pluck('examlevel_subject_id','examlevel_subject_id')->all();

                                                                    ?>
                                                                <div
                                                                    class="row border border-primary rounded pt-2 mb-2">
                                                                    <div class="col-md-3">
                                                                        {{ Form::checkbox('MastersExam[]', $Master->id, false, array( 'id'=>$name, 'onclick'=>'ExamLevel("'.$name.'");')) }}
                                                                        {!! Form::label('Masters',  $Master->name) !!}
                                                                    </div>
                                                                    <div class="col-md-8 {{$name}}"
                                                                         id="{{$name}}" style="display: none">

                                                                        <?php
                                                                        $Mastersubjects = \App\Models\ExamlevelSubject::where('examlevel_id', 5)->where('examlevel_group_id', $Master->id)
                                                                            ->get();
                                                                        ?>
                                                                        @foreach($Mastersubjects as $subjects)
                                                                            {{ Form::checkbox('MastersExamsubject[]', $subjects->id, in_array($subjects->id, $MastersSubjectList) ? true : false, array( 'id'=>$name,'class'=>$name)) }}
                                                                            {!! Form::label('MastersSubject',  $subjects->name) !!}
                                                                        @endforeach

                                                                    </div>
                                                                    <div class="col-md-1 {{$name}}" style="display: none">
                                                                        @if(count($Mastersubjects) > 0)
                                                                            <input type="checkbox" id="all_{{$name}}"  onclick="all_check('{{$name}}')" class="css-checkbox"  name="{{$name}}"/>Selectall<br>
                                                                            <button type="button" class="btn btn-success btn-lg mb-2" onclick="save('MastersExamsubject','masters', {{$Master->id}})"><i data-feather="save"></i> Save</button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
{{--                                        @endif--}}
                                    </div>

{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <div class="form-group pl-3">--}}
{{--                                                <button type="submit" class="btn btn-success btn-lg"><i data-feather="save"></i> Save</button>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                    </div>--}}
                                </div>
                                </div>
                            </div>

                            </div>
                        {{ Form::hidden('jobID', $joninfo->id) }}
                            {!! Form::close() !!}

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <!-- optional plugins -->
    <script src="{{ URL::asset('assets/js/jquery.toast.min.js') }}"></script>
@endsection

@section('script-bottom')


    <script type="text/javascript">

        $( function() {
            $('.select2').select2({
                placeholder: 'নির্বাচন করুন',
            });
            $('#select_all').on('click',function(){
                if(this.checked){
                    $('.SSC').each(function(){
                        this.checked = true;
                    });
                }else{
                    $('.SSC').each(function(){
                        this.checked = false;
                    });
                }
            });
            });
        function all_check(name){
            $('#all_'+name).on('click',function(){
                if(this.checked){
                    $('.'+name).each(function(){
                        this.checked = true;
                    });
                }else{
                    $('.'+name).each(function(){
                        this.checked = false;
                    });
                }
            });
        }
        function ExamLevel(name){


            if ($('#'+name).is(":checked"))
            {
                $('.'+name).show();
            }
           else{

                $('.'+name).hide();
            }

        }

        function save(name, type, group_id){
           // console.log(name, type);
            var checked = [];
            $("input[name='"+name+"[]']:checked").each(function ()
            {
                checked.push(parseInt($(this).val()));
            });
            $.ajax({
                url:"{{ route('examlevels.examsubject') }}",
                type:"POST",
                data: {
                    job_id: $('input[name=jobID]').val(),
                    type: type,
                    examlevel_group_id: group_id,
                    examlevelSubject: checked,
                    _token: "{{ csrf_token() }}",
                },
                success:function (data) {
                    //alert(data);
                    if(data.success==true){
                        $.toast({
                            position: 'top-right',
                            heading: 'Success',
                            text: 'Data updated.',
                            showHideTransition: 'slide',
                            icon: 'success'
                        })
                    }
                    else {
                        $.toast({
                            position: 'top-right',
                            heading: 'error',
                            text: 'Data not updated.',
                            showHideTransition: 'slide',
                            icon: 'error'
                        })
                    }



                }
            })
        }


    </script>

@endsection


