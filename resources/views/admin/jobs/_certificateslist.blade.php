<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ১/২/২৩
 * Time: ১০:১৪ PM
 * Copyright jibon <jibon.bikash@gmail.com>
 */


?>


    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />



<div class="">
    @foreach( $certificates as $certificate)

        {!! Form::checkbox('certificateslist[]', $certificate->id, false); !!}
        {{ Form::label($certificate->name, null, ['class' => 'control-label']) }}
    @endforeach



</div>

