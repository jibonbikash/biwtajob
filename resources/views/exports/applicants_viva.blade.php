<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ১৪/১০/২৩
 * Time: ৭:৪২ PM
 * Copyright jibon <jibon.bikash@gmail.com>
 */
?>
<table class="table">
    <thead class="table-info">
    <tr>
        <th scope="col">#</th>
        <th scope="col">পদের নাম</th>
        <th scope="col">প্রার্থীর  নাম  ও পিতার নাম</th>
        <th scope="col">জেন্ডার</th>
        <th scope="col">স্থায়ী  ঠিকানা</th>
        <th scope="col">মোবাইল</th>
        <th scope="col">নিজ জেলা</th>
        <th scope="col">শিক্ষাগত যোগ্যতা</th>
        <th scope="col">সংশ্লিষ্ট ক্ষেত্রে অভিজ্ঞতা</th>
        <th scope="col">অভিজ্ঞতার  বিবরণ</th>
        <th scope="col">অভিজ্ঞতার মেয়াদ</th>
        <th scope="col">কোটা</th>
        <th scope="col">বিভাগীয়</th>
    </tr>
    </thead>
    <tbody>
    @foreach($applicants as $applicant)
        <tr>
            <td>{{$applicant->id}}</td>
            <td>
                <span title="{{ $applicant->job ? $applicant->job->title:'' }}">{!! Str::words($applicant->job ? $applicant->job->title:'', 5, ' ...') !!}</span>
            </td>
            <td>
                {{ $applicant->applicant ? $applicant->applicant->name_bn:'' }}<br />
                {{ $applicant->applicant ? $applicant->applicant->father_name:'' }}
            </td>
            <td>
                {{ $applicant->applicant ? $applicant->applicant->gender:'' }}
            </td>
            <td>স্থায়ী  ঠিকানা</td>
            <td>
                {{ $applicant->applicant ? $applicant->applicant->mobile:'' }}
            </td>
            <td>
                {{ $applicant->applicant->birthplace ? $applicant->applicant->birthplace->zilla_name :'' }}

            </td>
            <td>
                @foreach($applicant->applicant->educations as $education)
                    পরীক্ষার নাম: {{ $education->examLevelGroups ? $education->examLevelGroups->name :'---' }} <br />
                    বিষয়:  @if ($education->other)
                        {{ $education->other }}
                    @else
                        {{ $education->ExamlevelSubject ? $education->ExamlevelSubject->name :'' }}<br />
                    @endif
                @endforeach
            </td>

            <td>{{ $applicant->applicant->experience }}</td>
            <td>{{ $applicant->applicant->experiencemonth }}</td>
            <td>{{ $applicant->applicant->experienceyear }}</td>
            <td>
                    <?php
                    if($applicant->applicant->quota){
                        $dbValue = $applicant->applicant->quota;
                        $myArray = json_decode($dbValue, true);
                        foreach ($myArray as $key => $value) {
                            echo $value.'<br />';
                        }
                    }
                    ?>
            </td>
            <td>{{ $applicant->applicant->division_appli }}</td>
        </tr>

    @endforeach
    </tbody>
</table>
