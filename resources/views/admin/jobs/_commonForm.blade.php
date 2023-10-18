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
    {!! Form::select('job_cercularID',$jobs,request()->get('job_id'),['class'=>'form-control select2','placeholder'=>'Select Job ID','required'=>true, 'id'=>'job_cercularID']) !!}
</div>
<div class="form-group">
    {!! Form::select('job_id',[],request()->get('job_id'),['class'=>'form-control select2','placeholder'=>'Select Job','required'=>true, 'id'=>'job_id_common']) !!}
</div>
<div class="form-group">
    {!! Form::select('type',array('New' => 'New', 'Merge' => 'Merge'),request()->get('job_id'),['class'=>'form-control select2','placeholder'=>'Select','required'=>true]) !!}
</div>
<div class="form-group">
    <div class="custom-file mb-3">
        <input name="fileimport" accept=".csv,.xlsx" type="file" class="custom-file-input" id="validatedCustomFile" required>
        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
        <div class="invalid-feedback">Example invalid custom file feedback</div>
    </div>
</div>
@section('script')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        $(document).on('change', '#job_cercularID',function(){
            var cercularID = $(this).val();
            var token = "{{ csrf_token()}}";
            $.ajax({
                type:'POST',
                url:"{{ route('Applicantjoblist') }}",
                data:{'cercularID':cercularID, _token:token},
                success:function(data){
                    $("#job_id_common").empty();
                    $.each(data,function(index,value){
                        $("<option/>", {
                            value: value.id,
                            text: value.title
                        }).appendTo('#job_id_common');
                    });

                    console.log(data);
                }
            });
        });


    });
</script>
@endsection
