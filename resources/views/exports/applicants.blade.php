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
        @if(!empty($reqdata['job_position']))
            <th scope="col">পদের নাম</th>
        @endif
        @if(!empty($reqdata['name_bn_father_name']))
            <th scope="col">প্রার্থীর নাম ও পিতার নাম</th>
        @endif
        @if(!empty($reqdata['code_name']))
            <th scope="col">কোড</th>
        @endif
        @if(!empty($reqdata['gender_name']))
            <th scope="col">জেন্ডার</th>
        @endif
        @if(!empty($reqdata['pr_house_pr_village_pr_union_pr_postoffice_pr_postcode']))
            <th scope="col">স্থায়ী ঠিকানা</th>
        @endif
        @if(!empty($reqdata['mobile']))
            <th scope="col">মোবাইল</th>
        @endif
        @if(!empty($reqdata['bday']))
            <th scope="col">জন্ম তারিখ ও বয়স</th>
        @endif
        @if(!empty($reqdata['token_name']))
            <th scope="col">পেমেন্ট আইডি</th>
        @endif
        @if(!empty($reqdata['bplace_name']))
            <th scope="col">নিজ জেলা</th>
        @endif
        @if(!empty($reqdata['educations_name']))
            <th scope="col">শিক্ষাগত যোগ্যতা</th>
        @endif
        @if(!empty($reqdata['experience_name']))
            <th scope="col">সংশ্লিষ্ট ক্ষেত্রে অভিজ্ঞতা</th>
        @endif
        @if(!empty($reqdata['experiencemonth_name']))
            <th scope="col">অভিজ্ঞতার বিবরণ</th>
        @endif
        @if(!empty($reqdata['experienceyear_name']))
            <th scope="col">অভিজ্ঞতার মেয়াদ</th>
        @endif
        @if(!empty($reqdata['quota_name']))
            <th scope="col">কোটা</th>
        @endif
        @if(!empty($reqdata['division_appli_name']))
            <th scope="col">বিভাগীয়  </th>
         @endif

                    @php
                        //        print_r($reqdata)
                    @endphp


    </tr>
    </thead>
    <tbody>
   @foreach($applicants as $applicant)
        <tr>
            @if(!empty($reqdata['job_position']))
                <td>
                    <span
                        title="{{ $applicant->job ? $applicant->job->title:'' }}">{!! Str::words($applicant->job ? $applicant->job->title:'', 5, ' ...') !!}</span>

                </td>
            @endif
            @if(!empty($reqdata['name_bn_father_name']))
                <td>{{ $applicant->name_bn }}<br/>
                    {{ $applicant->father_name }}
                </td>
            @endif
            @if(!empty($reqdata['code_name']))
                <td>{{ $applicant->code }}</td>
            @endif
            @if(!empty($reqdata['gender_name']))
                <td>{{ $applicant->gender }}</td>
            @endif
            @if(!empty($reqdata['pr_house_pr_village_pr_union_pr_postoffice_pr_postcode']))
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
            @endif
            @if(!empty($reqdata['mobile']))
                <td>{{ $applicant->mobile }} </td>
            @endif
            @if(!empty($reqdata['bday']))
                <td>
                    {{ Carbon\Carbon::parse($applicant->bday)->format('F j, Y') }} <br/>
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
            @endif
            @if(!empty($reqdata['token_name']))
                <td>
                    @if($applicant->apliyedJob)
                        @if($applicant->apliyedJob->received==1)
                            {{ $applicant->apliyedJob ? $applicant->apliyedJob->token:'' }},
                            {{ $applicant->apliyedJob ? $applicant->apliyedJob->txnid:'' }},
                            {{ $applicant->apliyedJob ? $applicant->apliyedJob->txndate:'' }}
                        @endif
                    @endif
                </td>
            @endif
            @if(!empty($reqdata['bplace_name']))
                <td>
                    {{ $applicant->birthplace ? $applicant->birthplace->zilla_name:'' }}
                    {{--                                 {{ $applicant->permanentzilla_name }}--}}
                </td>
            @endif
            @if(!empty($reqdata['educations_name']))
                <td>
                    @foreach($applicant->educations as $education)
                        পরীক্ষার নাম: {{ $education->examLevelGroups ? $education->examLevelGroups->name :'---' }} <br/>
                        বিষয়:  @if ($education->other)
                            {{ $education->other }}
                        @else
                            {{ $education->ExamlevelSubject ? $education->ExamlevelSubject->name :'' }}<br/>
                        @endif
                    @endforeach

                </td>
            @endif
            @if(!empty($reqdata['experience_name']))
                <td>{{ $applicant->experience }}</td>
            @endif
            @if(!empty($reqdata['experiencemonth_name']))
                <td>{{ $applicant->experiencemonth }}</td>
            @endif
            @if(!empty($reqdata['experienceyear_name']))
                <td>{{ $applicant->experienceyear }}</td>
            @endif
            @if(!empty($reqdata['quota_name']))
                <td>
                        <?php
                        if ($applicant->quota) {
                            $dbValue = $applicant->quota;
                            $myArray = json_decode($dbValue, true);
                            foreach ($myArray as $key => $value) {
                                echo $value . '<br />';
                            }
                        }
                        ?>

                </td>
            @endif
            @if(!empty($reqdata['division_appli_name']))
                <td>{{ $applicant->division_appli }}</td>
            @endif

        </tr>
    @endforeach
    </tbody>
</table>
