<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ১০/৩/২৩
 * Time: ১১:২০ PM
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
            <h4 class="mb-1 mt-0">Exam Subject</h4>
        </div>
        <div class="col-sm-6 col-xl-6">
            <a href="{{route('import-subject')}}" class="btn btn-warning btn-lg float-right"><i data-feather="file-text"></i> Import</a>
        <a href="{{route('examlevelgroupsubjects.create')}}" class="btn btn-info btn-lg float-right mr-2"><i data-feather="plus-circle"></i> Subject</a>
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
                            <div  class="table-responsive">

                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Exam Level</th>
                                        <th scope="col">Exam Group</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    {!! Form::open(array('route' => 'examlevelgroupsubjects.index' ,'method'=>'get')) !!}
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col"> {!! Form::text('name', app('request')->input('name'), array('placeholder' => '','class' => 'form-control')) !!}</th>
                                        <th scope="col">
                                            {!! Form::select('examlevel_id',\App\Models\Examlevel::pluck('name','id'),app('request')->input('examlevel_id'),['class'=>'form-control','placeholder'=>'Select Level']) !!}
                                        </th>
                                        <th scope="col">
                                            {!! Form::select('examlevel_group_id',\App\Models\ExamlevelGroup::pluck('name','id'),app('request')->input('examlevel_group_id'),['class'=>'form-control','placeholder'=>'Select Level']) !!}
                                        </th>
                                        <th scope="col">
                                            <button type="submit" class="btn btn-primary btn-lg"><i data-feather="search"></i> Search</button>
                                            <a href="{{route('examlevelgroupsubjects.index')}}" class="btn btn-dark btn-lg"><i data-feather="refresh-ccw"></i> Reset</a>
                                        </th>
                                    </tr>
                                    {!! Form::close() !!}
                                    </thead>
                                    <tbody>
                                    @foreach($examSubjects as $subject)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration + $examSubjects->firstItem() - 1 }}</th>
                                            <td>{{ $subject->name }}</td>
                                            <td>{{ $subject->examLevel ? $subject->examLevel->name : '' }}</td>
                                            <td>{{ $subject->examLevel ? $subject->examLevel->name : '' }}</td>

                                            <td>
                                                <a class="btn btn-success  btn-sm" title="Edit" href="{{ route('examlevelgroupsubjects.edit',$subject->id) }}"><i data-feather="edit" class="text-white"></i></a>



                                                {!! Form::open(['method' => 'DELETE','route' => ['examlevelgroupsubjects.destroy', $subject->id],'style'=>'display:inline']) !!}
                                                {!! Form::button('<i data-feather="trash-2"></i>', ['type' => 'submit', 'class' => 'btn btn-danger  btn-sm', 'onclick'=>'return confirm("Are you sure you want to delete this item?");']) !!}

                                                {!! Form::close() !!}

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                            {{ $examSubjects->onEachSide(5)->appends(Request::all())->links('pagination::bootstrap-4') }}
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

