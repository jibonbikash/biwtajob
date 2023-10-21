<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="developed" content="job application developed by Jibon Bikash Roy <jibon.bikash@gmail.com>" />
    <title>{{ config('app.name', 'BIWTA:: Viva Card') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- Scripts -->
</head>
<body onload="window.print()">
<style>
body{
	padding:0;
	font-size: 16px;
}
.headeing {

  font-size: 25px;
}
.printbody {
	margin-left: 10px;
}
</style>
<div class="headeing" align="center" >বাংলাদেশ অভ্যন্তরীণ নৌ-পরিবহন কৰ্তৃপক্ষ  </div>
<div style="font-size: 18px;" align="center" >১৪১-১৪৩, মতিঝিল বাণিজ্যিক এলাকা, ঢাকা -১০০০।  </div>
<div class="printbody">

<br /><br />


<table width="90%" style="margin-left: 10px">
  <tr>
    <td width="60%" valign="top"><span> রোল নং : {{ $appliedddata->apliyedJob ? $appliedddata->apliyedJob->roll:''}}</span><br />
	<span>জনাব / জনাবা: {{ $appliedddata->name_bn}} </span><br />
	<span>পিতা :  {{ $appliedddata->father_name}} </span><br />

	<span> {{ $appliedddata->pa_house }}</span>,
 <span> {{ $appliedddata->pa_village}} </span>,
	 <span> {{ $appliedddata->pa_union}}</span>,
	<span> {{ $appliedddata->pa_postoffice}} </span>-
	<span> {{ $appliedddata->pa_postcode}} </span>,
	<span> {{ $appliedddata->upozilla ? $appliedddata->upozilla->upozilla:'' }}
						 </span>,
	<span> {{ $appliedddata->zila ? $appliedddata->zila->zilla_name:'' }}
						 </span>
	</td>
    <td width="30%" valign="top"><img src="{{URL::to('/assets/applicants')}}/{{ $appliedddata->picture }}" width="150"><br/>
	<img src="{{URL::to('/assets/applicants')}}/{{ $appliedddata->signature }}" height="30" width="120"></td>
  </tr>
</table>
<strong>
    বিষয় : {{ $appliedddata->job? $appliedddata->job->title:''}} (বিজ্ঞপ্তি নং
    {{ $appliedddata->job? $appliedddata->job->circular_no:''}}) পদের মৌখিক পরীক্ষার প্রবেশ পত্র।।<br /><br />
     </strong><br /><br />
&nbsp;&nbsp;&nbsp;&nbsp;বাংলাদেশ অভ্যন্তরীণ নৌ-পরিবহন কর্তৃপর্তৃ ক্ষের ' {{ $appliedddata->job? $appliedddata->job->title:''}} (বিজ্ঞপ্তি নং {{ $appliedddata->job? $appliedddata->job->circular_no:''}}) ' পদে নিয়োগের নিমিত্তে মৌখিক পরীক্ষায় অংশগ্রহণের জন্য নিম্নোক্ত
    স্থান, তারিখ ও সময় মোতাবেক উপস্থিত থাকার জন্য আপনাকে অনুরোধ করা যাচ্ছে।।<br /><br />
    &nbsp;&nbsp;&nbsp;
    পরীক্ষার  স্থান &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  : {{ $appliedddata->viva ? $appliedddata->viva->place:''}}<br />
&nbsp;&nbsp;&nbsp;&nbsp;পরীক্ষার  তারিখ &nbsp;&nbsp;&nbsp;&nbsp;:  {{ $appliedddata->viva ? $appliedddata->viva->date:''}}<br />
&nbsp;&nbsp;&nbsp;&nbsp;পরীক্ষার  সময়  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :  {{ $appliedddata->viva ? $appliedddata->viva->time:''}}<br />
 &nbsp;         ১।      পরীক্ষা শুরু হওয়ার  ন্যূনতম ৩০ (ত্রিশ) মিনিটমিনিট পূর্বে প্রার্থীকে নির্ধারিত স্থানে উপস্থিত হতে হবে। <br />
 &nbsp;       ২।      প্রার্থীদেরকে লিখিত,মৌখিক ও ব্যাবহারিক  পরীক্ষার সময় ০৩(তিন) কপি পাসপোর্ট সাইজের  সত্যায়িত রঙ্গিন ছবি , জাতীয় পরিচয় পত্রের ফটোকপি , নাগরিকত্ব সনদপত্র  ও চারিত্রিক সনদপত্র   সহ সকল শিক্ষাগত যোগ্যতার সনদপত্রের  মূল কপি ও সত্যায়িত ০১ সেট ফটোকপি সঙ্গে আনতে হবে।  <br />
  &nbsp;     ৩।   মুক্তিযোদ্ধার সন্তান/নাতি-নাতনির কোটায় আবেদন কারীগণকে মুক্তিযোদ্ধা বিষয়ক মন্ত্রণালয় কর্তৃক মুক্তিযোদ্ধার নামে ইস্যুকৃত সাময়িক সনদপত্র, গেজেট, লাল মুক্তি বার্তার তালিকা , ওয়ারিশ  সনদপত্র , পিতা -মাতার  জাতীয় পরিচয় পত্রসহ মুক্তিযোদ্ধার সাথে সম্পর্ক উল্লেখ পূর্বক ইউনিয়ন পরিষদ চেয়ারম্যান কর্তৃক প্রদত্ত প্রত্যয়নপত্রের মূল কপি  ও সত্যায়িত ০১ সেট  ফটোকপি সঙ্গে আনতে হবে।   <br />
   &nbsp;     ৪।    উল্লেখ্য যে, লিখিত পরীক্ষায় অংশ গ্রহণের জন্য কোন প্রকার টি.এ./ডি.এ. প্রদান করা হবে না।  <br />
    <br />
    <br />
    <p style="text-align: center; font-weight: bold">"কোভিড-১৯ পরিস্থিতির প্রেক্ষিতে প্রার্থীকে আবশ্যিকভাবে মাস্ক পরিধান পূর্বকর্ব স্বাস্থ্যবিধি মেনে পরীক্ষা
        স্থলে আসতে হবে।"</p>
<p align="right"><img src="{{URL::to('/assets/images')}}/sign1.png"  height="40"></p>
<p align="right">(মোঃ মোস্তাফিজুর রহমান ) &nbsp;&nbsp;&nbsp;&nbsp;</p>
<p align="right">যুগ্ম-পরিচালক (সংস্থাপন ) </p>



</div>


</body>
</html>
