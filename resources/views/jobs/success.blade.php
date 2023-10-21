<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ২১/১০/২৩
 * Time: ১০:২৪ PM
 * Copyright jibon <jibon.bikash@gmail.com>
 */
?>
@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    Success Message
                </div>
                <div class="card-body">
                    <p style="color: red;font-size: 17px;"> Applied ID <strong style="font-size: 18px">({{$applicationinfo->code}})</strong> টি সংরক্ষণ করে রাখুন। রকেট এর মাধ্যমে টাকা পাঠানোর ক্ষেত্রে রকেট এর bill number এর ক্ষেত্রে এই আইডি নম্বর ব্যবহার করুন । পরিবর্তিতে সকল ক্ষেত্রে এই ID টি দরকার হবে।.</p>
                    <p class="font-bold"><strong class="spayment">টাকা পাঠানোর নিয়ম  : </strong> <strong>"রকেট " ডাচ বাংলা মোবাইল ব্যাঙ্কিং এর মোবাইল এ *322#  ডায়াল করুন এবং পরবর্তী ধাপগুলো  অনুসরণ করুন: <br>
                            Screen 1: Bill Pay ---&gt; Screen 2 : Select Your Option : Self:নিজের রকেট একাউন্ট  হলে  , Other:Agent হলে আবেদনকারীর মোবাইল নম্বর দিন ৷---&gt;Screen 3: Other ---&gt;Screen 4: Enter Biller ID : 422 ---&gt; Screen 5: Enter Bill Number: এর ক্ষেত্রে(Applied ID)দিতে হবে  ---&gt;Screen 6: Enter Amount:  ---&gt;Screen 7: Enter PIN (Successful)
                        </strong></p>
                    <a class="btn btn-success btn-lg" role="button" href="{{route('applicationPrint', ['uuid' => $applicationinfo->uuid])}}" target="_blank">
                        <strong><i data-feather="printer"></i>  Print </strong>
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
