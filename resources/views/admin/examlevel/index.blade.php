<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ৮/৩/২৩
 * Time: ৮:৫৩ PM
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
            <h4 class="mb-1 mt-0">Exam Levels</h4>
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
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($examLevels as $examLevel)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration + $examLevels->firstItem() - 1 }}</th>
                                            <td>{{ $examLevel->name }}</td>

                                            <td>
                                                <a class="btn btn-success  btn-sm" title="Edit" href="{{ route('examlevels.edit',$examLevel->id) }}"><i data-feather="edit" class="text-white"></i></a>

                                                <a class="btn btn-info  btn-sm" title="Group" href="{{ route('examlevels.groupadd',$examLevel->id) }}"><i data-feather="grid" class="text-white"></i></a>


                                                {!! Form::open(['method' => 'DELETE','route' => ['examlevels.destroy', $examLevel->id],'style'=>'display:inline']) !!}
                                                {!! Form::button('<i data-feather="trash-2"></i>', ['type' => 'submit', 'class' => 'btn btn-danger  btn-sm', 'onclick'=>'return confirm("Are you sure you want to delete this item?");']) !!}

                                                {!! Form::close() !!}

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                            {{ $examLevels->onEachSide(5)->appends(Request::all())->links() }}
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
