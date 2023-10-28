<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ২৪/১০/২৩
 * Time: ১১:০৬ AM
 * Copyright jibon <jibon.bikash@gmail.com>
 */
?>
@extends('layouts.vertical')
@section('title', 'Import List')

@section('content')
    <div class="row mt-3">
        <div class="col-xs-12 col-sm-12 col-md-12">
        @include('layouts.shared.message')
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
    {!! Form::open(['route' => array('importdata'), 'files' => true, 'method'=>'POST']) !!}
    <div class="form-group">
        <div class="custom-file mb-3">
            <input name="fileimport" accept=".csv,.xlsx" type="file" class="custom-file-input" id="validatedCustomFile" required>
            <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
            <div class="invalid-feedback">Example invalid custom file feedback</div>
        </div>
    </div>
            <div class="form-group">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="inlineRadio1" value="Board">
                <label class="form-check-label" for="inlineRadio1">Board</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="inlineRadio2" value="University">
                <label class="form-check-label" for="inlineRadio2">University</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="inlineRadio3" value="ExamLevel">
                <label class="form-check-label" for="inlineRadio3">ExamLevel</label>
            </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="type" id="inlineRadio3" value="ExamLevelGroup">
                    <label class="form-check-label" for="inlineRadio3">ExamLevel Group</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="type" id="inlineRadio3" value="ExamLevelGroupSubject">
                    <label class="form-check-label" for="inlineRadio3">ExamLevel Group Subject</label>
                </div>
            </div>
    <button type="submit" class="btn btn-primary">Import</button>
    {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('script-bottom')
@endsection
