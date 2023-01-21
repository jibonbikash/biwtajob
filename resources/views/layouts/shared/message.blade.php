<?php
/**
 * (c) MCC Ltd. <info@mcc.com.bd>
 * Created by Jibon Bikash Roy.
 * Developed by: Jibon Bikash Roy. <jibon.bikash@gmail.com, jibon@mcc.com.bd>
 * User: Mcc Ltd
 * Date: 4/29/2019
 * Time: 5:20 PM
 */
?>


@if ($message = Session::get('success'))
    <div class="card-block pl-3 pr-3">
        <div class="alert alert-success border-success">
            <strong>Success!</strong> {{ $message }}
        </div>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="card-block pl-3 pr-3">
        <div class="alert alert-danger border-danger">

            <strong>Danger!</strong> {{ $message }}
        </div>
    </div>

@endif


@if ($message = Session::get('warning'))
    <div class="card-block pl-3 pr-3">
        <div class="alert alert-warning border-warning">
            <strong>Warning!</strong> {{ $message }}
        </div>
    </div>

@endif


@if ($message = Session::get('info'))
    <div class="card-block pl-3 pr-3">
        <div class="alert alert-info border-info">
            <strong>Info!</strong> {{ $message }}
        </div>
    </div>

@endif


@if ($errors->any())
    <div class="card-block pl-3 pr-3">
        <div class="alert alert-danger border-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif


