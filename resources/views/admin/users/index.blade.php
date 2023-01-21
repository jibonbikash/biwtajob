<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ৫/৩/২১
 * Time: ১০:৫৮ PM
 * Copyright jibon <jibon.bikash@gmail.com>
 */
?>
@extends('layouts.vertical')


@section('content')

    <div class="sidebar-page-container">
        <div class="auto-container">
            <div class="row clearfix">

                <div class="content-side col-lg-12 col-md-12 col-sm-12">
                    <div class="service-detail">
                        <div class="inner-box">

                                <div class="card">
                                    <h5 class="card-header">Users Management</h5>
                                    <div class="card-body">
                                        <div class="col-lg-12 margin-tb mb-2">
                                            <div class="pull-left">
                                            </div>
                                            <div class="pull-right text-right">
                                                @if(auth::guard('admin')->user()->can('user-create'))
                                                <a class="btn btn-primary" href="{{ route('admin.users.create') }}"> <i data-feather="user-plus" class="text-white"></i> New User</a>
                                                @endif
                                            </div>
                                        </div>
                                        @include('layouts.shared.message')
                                        <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Roles</th>
                                                <th width="280px">Action</th>
                                            </tr>
                                            @foreach ($data as $key => $user)
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>
                                                        @if(!empty($user->getRoleNames()))
                                                            @foreach($user->getRoleNames() as $v)
                                                                <span class="badge bg-success">{{ $v }}</span>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>


                                                        <a class="btn btn-primary  btn-sm"  href="{{ route('admin.users.show',$user->id) }}"><i data-feather="eye" class="text-white"></i></a>
                                                        @if(auth::guard('admin')->user()->can('user-edit'))

                                                            <a class="btn btn-success  btn-sm" href="{{ route('admin.users.edit',$user->id) }}"><i data-feather="edit" class="text-white"></i></a>

                                                        @endif
                                                        @if(auth::guard('admin')->user()->can('user-delete'))

                                                        {!! Form::open(['method' => 'DELETE','route' => ['admin.users.destroy', $user->id],'style'=>'display:inline']) !!}
                                                            {!! Form::button('<i data-feather="trash-2"></i>', ['type' => 'submit', 'class' => 'btn btn-danger  btn-sm', 'onclick'=>'return confirm("Are you sure you want to delete this item?");']) !!}

                                                            {!! Form::close() !!}

                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>


                                        {!! $data->render() !!}
                                    </div>
                                    </div>
                                </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection
