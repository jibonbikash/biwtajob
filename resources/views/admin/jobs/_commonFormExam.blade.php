<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ১৮/১০/২৩
 * Time: ১০:৪৯ PM
 * Copyright jibon <jibon.bikash@gmail.com>
 */
?>
<div class="form-group">
    {!! Form::select('job_cercularID',$jobs,request()->get('job_id'),['class'=>'form-control select2','placeholder'=>'Select Job ID','required'=>true, 'id'=>'job_cercularID_exam']) !!}
</div>
<div class="form-group">
    {!! Form::select('job_id',[],request()->get('job_id'),['class'=>'form-control select2','placeholder'=>'Select Job','required'=>true, 'id'=>'job_id_common_exam']) !!}
</div>

<div class="form-group">
    {!! Form::text('rollstart', request()->get('rollstart'), array('placeholder' => 'Roll Start From','class' => 'form-control rollstart', 'id'=>'rollstart')) !!}
</div>
<div class="form-group">
    {!! Form::text('rollend', request()->get('rollend'), array('placeholder' => 'End Roll','class' => 'form-control rollend', 'required'=>true, 'id'=>'rollend')) !!}
</div>
<div class="form-group">
    {!! Form::text('date', request()->get('date'), array('placeholder' => 'Date','class' => 'form-control date','required'=>true, 'id'=>'date')) !!}
</div>
<div class="form-group">
    {!! Form::text('time', request()->get('date'), array('placeholder' => 'Time','class' => 'form-control date','required'=>true, 'id'=>'time')) !!}
</div>
<div class="form-group">
    {!! Form::text('place', request()->get('institute'), array('placeholder' => 'Place','class' => 'form-control','required'=>true,)) !!}
</div>
@section('script')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        $( "#date" ).datepicker({
            "dateFormat":"yy-mm-dd"
        });

        $(document).on('change', '#job_cercularID_exam',function(){
            var cercularID = $(this).val();
            var token = "{{ csrf_token()}}";
            $.ajax({
                type:'POST',
                url:"{{ route('Applicantjoblist') }}",
                data:{'cercularID':cercularID, _token:token},
                success:function(data){
                    $("#job_id_common_exam").empty();
                    console.log(data);
                    $.each(data,function(index,value){
                        $("<option/>", {
                            value: value.id,
                            text: value.title
                        }).appendTo('#job_id_common_exam');
                    });

                    console.log(data);
                }
            });
        });


    });
</script>
@endsection
