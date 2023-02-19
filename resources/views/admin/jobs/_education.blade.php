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
    {!! Form::select('min_education1[]',$examlevel,null,['class'=>'form-control select','multiple'=>'multiple']) !!}
</div>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select').select2();
    });
</script>
