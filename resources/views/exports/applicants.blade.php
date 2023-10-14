<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ১৩/১০/২৩
 * Time: ১০:৪৩ PM
 * Copyright jibon <jibon.bikash@gmail.com>
 */
?>
<table class="table">
    <thead class="table-info">
    <tr>
        <th scope="col">পদের নাম</th>
        <th scope="col">প্রার্থীর  নাম  ও পিতার নাম</th>
        <th scope="col">কোড</th>
        <th scope="col">জেন্ডার</th>
        <th scope="col">স্থায়ী  ঠিকানা</th>
        <th scope="col">মোবাইল</th>
        <th scope="col">জন্ম তারিখ  ও বয়স</th>
        <th scope="col">পেমেন্ট আইডি</th>
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
            <td>
                <span title="{{ $applicant->job ? $applicant->job->title:'' }}">{!! Str::words($applicant->job ? $applicant->job->title:'', 5, ' ...') !!}</span>

            </td>

            <td>{{ $applicant->name_bn }}<br />
                {{ $applicant->father_name }}
            </td>
            <td>{{ $applicant->token }}</td>
            <td>{{ $applicant->gender }}</td>
            <td>
                বাসা ও সড়ক (নাম/নম্বর): {{ $applicant->pr_house }},
                গ্রাম/পাড়া/মহল্লা: {{ $applicant->pr_village }},
                ইউনিয়ন/ওয়ার্ড: {{ $applicant->pr_union }},
                ডাকঘর: {{ $applicant->pr_postoffice }},
                পোস্টকোড: {{ $applicant->pr_postcode }},
                উপজেলা /থানা:{{ $applicant->permanentupozilla ? $applicant->permanentupozilla->upozilla:'' }},
                জেলা: {{ $applicant->permanentzila ? $applicant->permanentzila->zilla_name:'' }}

                {{--                                উপজেলা: {{ $applicant->permanentupozilla ? $applicant->permanentupozilla->upozilla:'' }},--}}
                {{--                                জেলা: {{ $applicant->permanentzila ? $applicant->permanentzila->zilla_name:'' }},--}}
            </td>
            <td>{{ $applicant->mobile }} </td>
            <td>
                {{ Carbon\Carbon::parse($applicant->bday)->format('F j, Y') }} <br />
                    <?php
                    $fixedday = Carbon\Carbon::parse($applicant->age_calculation)->format('F j, Y');
                    $fixeddaycal = date('d-m-Y', strtotime($fixedday));
                    $datetime1 = new DateTime($fixeddaycal);
                    $datetime2 = new DateTime($applicant->bday);
                    $interval = $datetime1->diff($datetime2);
                    //  echo $fixedday. ' তারিখে : ';
                    echo $interval->format('%y বছর %m মাস এবং %d দিন');
                    ?>
            </td>
            <td>{{ $applicant->apliyedJob ? $applicant->apliyedJob->token:'' }}</td>
            <td>
                {{ $applicant->birthplace ? $applicant->birthplace->zilla_name:'' }}
                {{--                                 {{ $applicant->permanentzilla_name }}--}}
            </td>
            <td>
                @foreach($applicant->educations as $education)
                    পরীক্ষার নাম: {{ $education->examLevelGroups ? $education->examLevelGroups->name :'---' }} <br />
                    বিষয়:  @if ($education->other)
                        {{ $education->other }}
                    @else
                        {{ $education->ExamlevelSubject ? $education->ExamlevelSubject->name :'' }}<br />
                    @endif
                @endforeach

            </td>
            <td>{{ $applicant->experience }}</td>
            <td>{{ $applicant->experiencemonth }}</td>
            <td>{{ $applicant->experienceyear }}</td>
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

            </td>
            <td>{{ $applicant->division_appli }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
