<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ১/৪/২৩
 * Time: ২:৫২ PM
 * Copyright jibon <jibon.bikash@gmail.com>
 */
?>
    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<style>

@media print {
  .print {
    display: none;
  }
}
    </style>
</head>
<body onload="window.print()">
<div class="container">
    <table width="100%">
        <tr>
            <td width="33%">
                <div class="col-md-4">
           
                    @if($applicationinfo->apliyedJob ? $applicationinfo->apliyedJob->roll:'')
                    <b style="font-size:30px;"> Roll:  {{ $applicationinfo->apliyedJob ? $applicationinfo->apliyedJob->roll:'' }} </b><br />
                    @endif
                   

                    বরাবর <br />
                    পরিচালক  <br />
                    প্রশাসন ও মানবসম্পদ  <br />
                    বিআইডব্লিউটিএ   <br />
                    ঢাকা <br />
                </div>
            </td>
            <td width="30%">
                <div class="col-md-5">
                    <strong>পদের নাম </strong>{{ $applicationinfo->job?$applicationinfo->job->title:'' }}
                    <br />
                    <strong>আবেদনের তারিখ   </strong><?php echo date("F j, Y, g:i a", strtotime($applicationinfo->created_at)); ?>

                </div>
            </td>
            <td width="30%">
                <div class="col-md-3">
                    <img style="float: right; width: 250px" class="img-responsive img-rounded" src="{{URL::to('/assets/applicants')}}/{{ $applicationinfo->picture }}" width="300">
                </div>
            </td>
        </tr>
    </table>
    <br />
    <br />


    &nbsp; &nbsp; &nbsp; &nbsp;   বিষয়: চাকরীতে নিয়োগের আবেদন। <br />
    &nbsp; &nbsp; &nbsp; &nbsp; সূত্র : বিজ্ঞপ্তি নাম্বার {{ $applicationinfo->job?$applicationinfo->job->job_id:'' }} , {{ $applicationinfo->job ? date("F j, Y", strtotime($applicationinfo->job->jobcurbday)) :'' }}  তারিখে প্রকাশিত বিজ্ঞপ্তি
    <br />
    <table class="table table-bordered">
        <tbody>
        <tr>
            <td>১. পদের নাম  </td>
            <td colspan="3"> {{ $applicationinfo->job?$applicationinfo->job->title:'' }}</td>
        </tr>
        <tr>
            <td>২. বিজ্ঞপ্তি নাম্বার   </td>
            <td>{{ $applicationinfo->job ?$applicationinfo->job->job_id:'' }}</td>
            <td>তারিখ </td>
            <td> {{ $applicationinfo->job ? date("F j, Y", strtotime($applicationinfo->job->jobcurbday)) :'' }}</td>
        </tr>

        <tr>
            <td>৩. প্রার্থীর নাম বাংলায় </td>
            <td>{{ $applicationinfo->name_bn }}</td>
            <td>প্রার্থীর নাম ইংরেজীতে</td>
            <td>{{ $applicationinfo->name_en }}</td>
        </tr>
        <tr>
            <td>৪. জাতীয় পরিচয় নম্বর</td>
            <td>{{ $applicationinfo->nid }}</td>
            <td>জন্ম নিবন্ধন নম্বর</td>
            <td>{{ $applicationinfo->brn }}</td>
        </tr>

        <tr>
            <td>৫. জন্ম তারিখ </td>
            <td>{{ Carbon\Carbon::parse($applicationinfo->bday)->format('F j, Y') }}</td>
            <td>৬. জন্ম স্থান (জেলা)</td>
            <td>
                {{ $applicationinfo->birthplace? $applicationinfo->birthplace->zilla_name:'' }}
            </td>
        </tr>

        <tr>

            <td>৭. বয়স  </td>
            <td colspan="3">

                <?php
              //  $fixedday = $applicationinfo->job ? $applicationinfo->job->age_calculation : '';
                $fixedday = Carbon\Carbon::parse($applicationinfo->job ? $applicationinfo->job->age_calculation : '')->format('F j, Y');
               $fixeddaycal = date('d-m-Y', strtotime($fixedday));
               $datetime1 = new DateTime($fixeddaycal);
                $datetime2 = new DateTime($applicationinfo->bday);
               $interval = $datetime1->diff($datetime2);
               echo $fixedday. ' তারিখে :  ';
               echo $interval->format('%y বছর %m মাস এবং %d দিন');
                ?>
                </td>
        </tr>
        <tr>


            <td>৮. পিতার নাম</td>
            <td>
                {{ $applicationinfo->father_name }}
            </td>
            <td>৯. মাতার নাম  </td>
            <td>
                {{ $applicationinfo->mother_name }}
            </</td>
        </tr>


        </tbody>
    </table>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th style="width: 33%">১০. ঠিকানা</th>
            <th style="width: 33%">বর্তমান </th>
            <th style="width: 33%">স্থায়ী </th>

        </tr>
        </thead>
        <tbody>
        <tr>
            <td>বাসা ও সড়ক (নাম/নম্বর)</td>
            <td>
                {{ $applicationinfo->pa_house }}
            </td>
            <td>
                {{ $applicationinfo->pr_house }}
            </td>

        </tr>
        <tr>
            <td>গ্রাম/পাড়া/মহল্লা</td>
            <td>
                {{ $applicationinfo->pa_village }}
            </td>
            <td>
                {{ $applicationinfo->pr_village }}
            </td>

        </tr>
        <tr>
            <td>ইউনিয়ন/ওয়ার্ড</td>
            <td>
                {{ $applicationinfo->pa_union }}
            </td>
            <td>
                {{ $applicationinfo->pr_union }}
            </td>

        </tr>
        <tr>
            <td>ডাকঘর </td>
            <td>
                {{ $applicationinfo->pa_postoffice }}
            </td>
            <td>
                {{ $applicationinfo->pr_postoffice }}
            </td>

        </tr>
        <tr>
            <td>পোস্টকোড নম্বর</td>
            <td>
                {{ $applicationinfo->pa_postcode }}
            </td>
            <td>
                {{ $applicationinfo->pr_postcode }}
            </td>

        </tr>
        <tr>
            <td>উপজেলা /থানা</td>
            <td>
                {{ $applicationinfo->upozilla ? $applicationinfo->upozilla->upozilla:'' }}


            </td>
            <td>
                {{ $applicationinfo->permanentupozilla ? $applicationinfo->permanentupozilla->upozilla:'' }}
            </td>

        </tr>
        <tr>
            <td>জেলা </td>
            <td>
                {{ $applicationinfo->zila ? $applicationinfo->zila->zilla_name:'' }}
            </td>
            <td>
                {{ $applicationinfo->permanentzila ? $applicationinfo->permanentzila->zilla_name:'' }}
            </td>

        </tr>

        </tbody> </table>
    <table class="table table-bordered">
        <tbody>
        <tr>
        <tr>
            <td>১১. মোবাইল/টেলিফোন নম্বর</td>
            <td>
                {{ $applicationinfo->mobile }}
            </td>
            <td>১২. জাতীয়তা </td>
            <td>
                {{ $applicationinfo->nationality }}
            </td>
        </tr>

        <tr>
            <td>১৩. জেন্ডার </td>
            <td> {{ $applicationinfo->gender }}</td>
            <td>১৪. ধর্ম </td>
            <td>
                {{ $applicationinfo->religious }}
            </td>
        </tr>
        <tr>
            <td>১৫. পেশা</td>
            <td colspan="3">
                {{ $applicationinfo->occupation }}
            </td>

        </tr>
        </tbody> </table>

    <strong>১৬.  শিক্ষাগত যোগ্যতা </strong>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>পরীক্ষার নাম</th>
            <th>বিষয়</th>
            <th>শিক্ষা প্রতিষ্ঠান</th>
            <th>পাসের সন</th>
            <th>বোর্ড/বিশ্ববিদ্যালয়</th>
            <th>গ্রেড/শ্রেণি/বিভাগ</th>
        </tr>
        </thead>
        <tbody>
        @foreach($applicationinfo->educations as $education)
            <tr>
                <td>{{ $education->examLevelGroups ? $education->examLevelGroups->name :'---' }}</td>
                <td>
                
                    @if ($education->other)
                    {{ $education->other }}   
                    @else 
                    {{ $education->ExamlevelSubject ? $education->ExamlevelSubject->name :'' }}
                    @endif
                        {{-- {{ $education->ExamlevelSubject ? $education->ExamlevelSubject->name :'' }} --}}
                </td>
                <td>{{ $education->institute_name }} </td>
                <td>{{ $education->passing_year }} </td>
                <td>
                    @php
                        if(in_array($education->examLevelGroups ? $education->examLevelGroups->examlevel_id:0, range(1, 3))) {
echo \App\Models\Board::find($education->board_university)->name;

}
else{
// echo 'university';
echo \App\Models\Board::find($education->board_university)->name;

}

                    @endphp
                   {{-- {{ $education->board_university }} --}}
                </td>
                <td>
                   
                    @php 
if(in_array($education->result, ['প্রথম বিভাগ','দ্বিতীয় বিভাগ','তৃতীয় বিভাগ'])) {
//echo \App\Helpers\StaticValue::RESULTSSC[$education->result];
echo $education->result;
}
else{
    if($education->edu_level==1){
      if(in_array($education->result, ['প্রথম বিভাগ','দ্বিতীয় বিভাগ','তৃতীয় বিভাগ'])) {
            echo $education->result;
            }
            else{
                echo $education->cgpa.' - '; echo $education->result;
            }

    }
    else{
        echo $education->cgpa.' - '; echo \App\Helpers\StaticValue::RESULTSSC[$education->result];
    }
}
                    @endphp
                    {{-- {{ $education->result }} --}}
                
                </td>
            </tr>
        @endforeach
      
        </tbody>
    </table>
    @if($applicationinfo->job->certificate_text)
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan='4'>  {{ $applicationinfo->job->certificate_text}}</th>
                                                    
                                                        
                                                    </tr>
                                                <tr>
                                                    <th>সার্টিফিকেশন নাম</th>
                                                    <th>প্রতিষ্ঠান নাম </th>
                                                    <th>সার্টিফিকেট/লাইসেন্স নম্বর</th>
                                                    <th>সার্টিফিকেট/লাইসেন্সের মেয়াদ শেষ হওয়ার তারিখ</th>
                                                    
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ App\Models\Crtificate::find($applicationinfo->applicantCertificate ? $applicationinfo->applicantCertificate->edu_level:'')->name}} </td>
                                                        <td>{{ $applicationinfo->applicantCertificate ? $applicationinfo->applicantCertificate->institute_name :'---' }} </td>
                                                        <td>{{ $applicationinfo->applicantCertificate ? $applicationinfo->applicantCertificate->certificate_no :'---' }}</td>
                                                        <td>{{ $applicationinfo->applicantCertificate ? $applicationinfo->applicantCertificate->certificate_expire :'---' }}</td>
                                                        
                                                    </tr>
                                                </tbody>
                                            </table>
                                            @endif

    <table class="table table-bordered">
        <thead>
        <tr>
            <td>১৭. অতিরিক্ত যোগ্যতা</td>
            <td colspan="3">
                {{ $applicationinfo->extra_qualification }}
            </td>

        </tr>
        <tr>
            <td>১৮.সংশ্লিষ্ট ক্ষেত্রে অভিজ্ঞতা</td>
            <td colspan="3">
                {{ $applicationinfo->experience }}
            </td>

        </tr>
        <tr>
            <td> অভিজ্ঞতার বিবরণ</td>
            <td colspan="3">
                {{ $applicationinfo->experiencemonth }}
            </td>
        </tr>
        <tr>
            <td>১৯. অভিজ্ঞতার মেয়াদ  (বছর )</td>
            <td colspan="3">
                {{ $applicationinfo->experienceyear }}
            </td>

        </tr>

        <tr>
            <td valign="top"> ২০. কোটা </td>
            <td colspan="3">
                <?php
                                            if($applicationinfo->quota){
                                                $dbValue = $applicationinfo->quota;
                                             $myArray = json_decode($dbValue, true); 
                                            //  echo "<pre>";
                                            //  print_r($myArray);
                                            //  echo "</pre>";
                                             foreach ($myArray as $key => $value) {
                                                echo $value.'<br />';
                                             }
                                            }

                                            ?>

               

            </td>

        </tr>
        <tr>
            <td>২১.  পেমেন্ট ট্রান্সেকশন আইডি  </td>
            <td>
                {{ $applicationinfo->apliyedJobPayment ? $applicationinfo->apliyedJobPayment->token:'' }}
            </td>
            <td>তারিখ </td>
            <td>
            
                {{ $applicationinfo->apliyedJobPayment ? Carbon\Carbon::parse($applicationinfo->apliyedJobPayment->apply_date)->format('F j, Y'):""}}
               
                </td>
        </tr>
        <tr>
            <td>ব্যাংক ও শাখার নাম</td>
            <td>রকেট মোবাইল ব্যাংকিং </td>
            <td>২২. বিভাগীয় প্রার্থী কিনা </td>
            <td>
                {{ $applicationinfo->division_appli }}
            </td>
        </tr>
        @if($applicationinfo->repetition==1)
        <tr>
            <td>২৩.{{$applicationinfo->job ? $applicationinfo->job->repetition:''}}</td>
            
            <td colspan="3">
                 হ্যাঁ
            </td>
        </tr>
        @endif
        </tbody>
    </table>
    <p align="left">তারিখ : <?=date('F j, Y',strtotime($applicationinfo->created_at))?> </p>
    <p align="left">Applied ID : {{ $applicationinfo->apliyedJob ? $applicationinfo->apliyedJob->token:'' }} </p>

    <img  class="img-responsive img-rounded" src="{{URL::to('/assets/applicants')}}/{{ $applicationinfo->signature }}" height="80" style="float: right; height: 80px;">
    <br />
    <div class="clearfix"></div>
    <p align="left"> <strong>টাকা পাঠানোর নিয়ম  :  </strong> <br />  <strong>"রকেট " ডাচ বাংলা মোবাইল ব্যাঙ্কিং এর মোবাইল এ *322#  ডায়াল করুন এবং পরবর্তী ধাপগুলো  অনুসরণ করুন:  <br />
            Screen 1:Payment ---> Screen 2: Bill Pay ---> Screen 3 : Select Your Option : Self:নিজের রকেট একাউন্ট  হলে  , Other:Agent হলে আবেদনকারীর মোবাইল নম্বর দিন ৷--->Screen 4: Enter Biller ID : 422 --->
            Screen 5: Enter Bill Number: এর ক্ষেত্রে(Applied ID)দিতে হবে  --->Screen 6: Enter Amount: Application Fee --->Screen 7: Enter PIN (Successful)
        </strong></p>
</div>

<button class="btn btn-primary float-end mb-3 mr-2 print" onclick="window.print()">Print</button>
</body>
</html>
