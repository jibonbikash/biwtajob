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
    {!! Form::select('job_idq',[],request()->get('job_id'),['class'=>'form-control select2','placeholder'=>'Select Job','required'=>true, 'id'=>'job_id_common_exam']) !!}
</div>

<div class="form-group">
    {!! Form::text('rollstart', request()->get('rollstart'), array('placeholder' => 'Roll Start From','class' => 'form-control rollstart', 'id'=>'rollstart')) !!}
</div>
<div class="form-group">
    {!! Form::text('rollend', request()->get('rollend'), array('placeholder' => 'End Roll','class' => 'form-control rollend', 'id'=>'rollend')) !!}
</div>
<div class="form-group">
    {!! Form::text('date', request()->get('date'), array('placeholder' => 'Date & time','class' => 'form-control date', 'id'=>'date')) !!}
</div>
<div class="form-group">
    {!! Form::text('institute', request()->get('institute'), array('placeholder' => 'Institute','class' => 'form-control')) !!}
</div>
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>

    <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {

        $("#date").datetimepicker({
            format: 'Y-m-d h:i a',
            formatTime: 'h:i a',
            formatDate: 'Y-m-d',
            step:60,
            pick12HourFormat: false
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
