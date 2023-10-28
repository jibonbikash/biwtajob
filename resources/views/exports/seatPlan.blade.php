<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ২৩/১০/২৩
 * Time: ১১:৫৮ AM
 * Copyright jibon <jibon.bikash@gmail.com>
 */
?>
<table class="table table-striped table-hover table-bordered">
    <tbody>
    <tr>
        <td colspan="4">
            <strong>  মোট: {{count($applicants)}}</strong>
        </td>
    </tr>
    </tbody>

</table>

<table class="table table-striped table-hover table-bordered">
    <thead class="table-info">
    <tr>
        <th>পদের নাম</th>
        <th>রোল </th>
        <th>কোড </th>
        <th>সার্কুলার নং</th>
{{--        @if($photo=='yes')--}}
{{--        <th>ছবি</th>--}}
{{--        @endif--}}
        <th>প্রার্থীর  নাম  ও  পিতার নাম  </th>
        <th>মোবাইল</th>
        <th>নিজ জেলা </th>
        <th>কোটা </th>
        <th>পরীক্ষার স্থান </th>
        <th>পরীক্ষার তারিখ ও সময় </th>
    </tr>
    </thead>
    <tbody>
    @foreach($applicants as $applicant)
        <tr>

            <td>
                <span title="{{ $applicant->job ? $applicant->job->title:'' }}">{!! Str::words($applicant->job ? $applicant->job->title:'', 5, ' ...') !!}</span>
            </td>
            <td>{{ $applicant->apliyedJob ? $applicant->apliyedJob->roll:'' }}</td>

            <td>{{ $applicant->code }}</td>
            <td>{{ $applicant->job ? $applicant->job->job_id:'' }}</td>
{{--            @if($photo=='yes')--}}
{{--                <td>--}}
{{--                    <img src="{{asset('assets/applicants/'.$applicant->picture)}}" alt="Logo" height="80">--}}
{{--                </td>--}}
{{--            @endif--}}
            <td>
                {{ $applicant->name_bn }}<br />
                {{ $applicant->father_name }}
            </td>
            <td>{{ $applicant->mobile }}</td>
            <td>  {{ $applicant->birthplace ? $applicant->birthplace->zilla_name:'' }}</td>
            <td>
                <?php
                if($applicant->quota){
                    $dbValue = $applicant->quota;
                    $myArray = json_decode($dbValue, true);
                    foreach ($myArray as $key => $value) {
                        echo $value.'<br />';
                    }
                }
                ?>
            <td>{{ $applicant->apliyedJob ? $applicant->apliyedJob->exam_hall:'' }}</td>
            <td>{{ $applicant->apliyedJob ? $applicant->apliyedJob->exam_date	:'' }},
                {{ $applicant->apliyedJob ? $applicant->apliyedJob->exam_time:'' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
