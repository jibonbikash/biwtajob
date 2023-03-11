<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ১১/৩/২৩
 * Time: ৩:৩৬ PM
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
                                    <div class="card-header bg-soft-info">
                                      Education Setting
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card border mt-4">
                                                    <div class="card-header bg-soft-secondary">
                                                        H.S.C Equivalent
                                                    </div>
                                                    <div class="card-body">
                                                        <?php
                                                        $hsc = \App\Models\ExamlevelGroup::where('examlevel_id',3)
                                                            ->get();

                                                        ?>
                                                        @foreach($hsc as $examHSC)
                                                        <div class="row border border-primary rounded pt-2 mb-2">
                                                            <div class="col-md-3">
                                                                {{ Form::checkbox('HSCExam[]', $examHSC->id, false, array( 'id'=>'HSC')) }}
                                                                {!! Form::label('HSC',  $examHSC->name) !!}
                                                            </div>
                                                            <div class="col-md-9" id="{{\App\Helpers\StaticValue::clean($examHSC->name)}}">
<?php
                                                                $hscsubjects = \App\Models\ExamlevelSubject::where('examlevel_id',3)->where('examlevel_group_id',$examHSC->id)
                                                                    ->get();
?>
                                                                @foreach($hscsubjects as $subjects)
    {{ Form::checkbox('HSCExamsubject[]', $subjects->id, false, array( 'id'=>'HSCExamsubject')) }}
    {!! Form::label('HSCSubject',  $subjects->name) !!}
                                                                   @endforeach

                                                            </div>
                                                        </div>
                                                            @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card mt-4 border">
                                                    <div class="card-header bg-soft-secondary">
                                                        Graduation
                                                    </div>
                                                    <div class="card-body">
                                                        <?php
                                                        $Graduation = \App\Models\ExamlevelGroup::where('examlevel_id',4)
                                                            ->get();

                                                        ?>
                                                        @foreach($Graduation as $examGraduation)
                                                            <div class="row border border-primary rounded pt-2 mb-2">
                                                                <div class="col-md-3">
                                                                    {{ Form::checkbox('HSCExam[]', $examGraduation->id, false, array( 'id'=>'Graduation')) }}
                                                                    {!! Form::label('Graduation',  $examGraduation->name) !!}
                                                                </div>
                                                                <div class="col-md-9" id="{{\App\Helpers\StaticValue::clean($examGraduation->name)}}">

                                                                    <?php
                                                                    $hscsubjects = \App\Models\ExamlevelSubject::where('examlevel_id',4)->where('examlevel_group_id',$examGraduation->id)
                                                                        ->get();
                                                                    ?>
                                                                    @foreach($hscsubjects as $subjects)
                                                                        {{ Form::checkbox('HSCExamsubject[]', $subjects->id, false, array( 'id'=>'GraduationExamsubject')) }}
                                                                        {!! Form::label('GraduationSubject',  $subjects->name) !!}
                                                                    @endforeach

                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group pl-3">
                                                <button type="submit" class="btn btn-success btn-lg"><i data-feather="save"></i> Save</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                </div>
                            </div>

                            </div>

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

@endsection

@section('script-bottom')

    <script type="text/javascript">

        $( function() {

        } );
    </script>

@endsection


