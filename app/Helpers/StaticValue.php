<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ২১/১/২৩
 * Time: ১২:৫৯ PM
 * Copyright jibon <jibon.bikash@gmail.com>
 */

namespace App\Helpers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StaticValue
{
    const MINEDUCATION = [
        'JSC' => "JSC/Equivalent Level",
        'SSC' => "SSC/Equivalent Level",
        'HSC' => "HSC/Equivalent Level",
        'Graduation' => "Graduation/Equivalent Level",
        'Masters' => "Masters/Equivalent Level",
    ];

    const GENDER = [
        'পুরুষ' => "পুরুষ",
        'মহিলা' => "মহিলা",
    ];

    const RELIGIONS = [
        'ইসলাম' => "ইসলাম",
        'হিন্দু' => "হিন্দু",
        'বৌদ্ধ' => "বৌদ্ধ",
        'খ্রীষ্টান' => "খ্রীষ্টান",
    ];
    const NATIONALITY = [
        'বাংলাদেশী' => "বাংলাদেশী",
    ];
    const BOARDLIST = [
        'বাংলাদেশী' => "Dhaka",
    ];

    const RESULTJSC = [
        '4' => "GPA(out of 4)",
        '5' => "GPA(out of 5)",
        '6' => "Passed",
    ];

    const RESULTSSC = [
        '1' => "1st Division",
        '2' => "2nd Division",
        '3' => "3rd Division",
        '4' => "GPA(out of 4)",
        '5' => "GPA(out of 5)",
    ];
    const UNIVERSITIES = [
        "Ad-din Womens Medical College, Dhaka",
        "Ahsania Mission University of Science and Technology",
        "Ahsanullah University of Science and Technology",
        "America Bangladesh University",
        "American International University Bangladesh",
        "Anwer Khan Modern Medical College, Dhaka",
        "Anwer Khan Modern University",
        "ASA University Bangladesh",
        "Asian University for Women",
        "Asian University of Bangladesh",
        "Atish Dipankar University of Science & Technology",
        "Bandarban University",
        "Bangabandhu Sheikh Mujib Medical University",
        "Bangabandhu Sheikh Mujibur Rahman Agricultural University",
        "Bangabandhu Sheikh Mujibur Rahman Aviation And Aerospace University",
        "Bangabandhu Sheikh Mujibur Rahman Digital University",
        "Bangabandhu Sheikh Mujibur Rahman Maritime University",
        "Bangabandhu Sheikh Mujibur Rahman Science and Technology University",
        "Bangabandhu Sheikh Mujibur Rahman Univerisity, Kishoreganj",
        "Bangamata Sheikh Fojilatunnesa Mujib Science and Technology University",
        "Bangladesh Agricultural University,Mymensingh",
        "Bangladesh Airlines Training Centre (BATC)",
        "Bangladesh Army International University of Science & Technology(BAIUST) ,Comilla",
        "Bangladesh Army University of Engineering and Technology (BAUET), Qadirabad",
        "Bangladesh Army University of Science and Technology(BAUST), Saidpur",
        "Bangladesh Islami University",
        "Bangladesh Medical College",
        "Bangladesh Open University",
        "Bangladesh University",
        "Bangladesh University of Business & Technology (BUBT)",
        "Bangladesh University of Engineering & Technology",
        "Bangladesh University of Health Sciences",
        "Bangladesh University of Professionals",
        "Bangladesh University of Textiles",
        "Barisal University",
        "Barishal Engineering College",
        "Begum Rokeya University, Rangpur",
        "BGC Trust Medical College, Chittagong",
        "BGC Trust University Bangladesh, Chittagong",
        "BGMEA University of Fashion & Technology(BUFT)",
        "BRAC University",
        "Britannia University",
        "Canadian University of Bangladesh",
        "CCN University of Science & Technology",
        "Central Medical College, Comilla",
        "Central University of Science and Technology",
        "Central Women's University",
        "Chandpur Science and Technology University",
        "Chittagong Independent University",
        "Chittagong Medical College",
        "Chittagong Medical University",
        "Chittagong University of Engineering & Technology",
        "Chittagong Veterinary and Animal Sciences University",
        "Chottagram Ma-O-Shishu Hospital Medical College",
        "City University",
        "Comilla Medical College",
        "Comilla University",
        "Community Based Medical College (cbmc), Mymensingh",
        "Community Medical College, Dhaka",
        "Cox's Bazar International University",
        "Cox's Bazar Medical College",
        "Daffodil International University",
        "Darul Ihsan University",
        "Delta Medical College, Dhaka",
        "Dhaka International University",
        "Dhaka Medical College",
        "Dhaka National Medical College",
        "Dhaka University",
        "Dhaka University of Engineering & Technology",
        "Dinajpur Medical College",
        "Durra Samad Rahman Red Crescent Women's Medical College, Sylhet",
        "Kushtia Medical College",
        "Labaid Medical College, Dhanmondi, Dhaka",
        "Leading University, Sylhet",
        "MAG Osmani Medical College",
        "Manarat International University",
        "Maulana Bhasani Medical College",
        "Mawlana Bhashani Science & Technology University",
        "Medical College for Women and Hospital, Dhaka",
        "Metropolitan University, Sylhet",
        "Microland University of Science and Technology",
        "Military Institute of Science and Technology (MIST)",
        "Mymensingh Engineering College",
        "Mymensingh Medical College",
        "N.P.I University of Bangladesh",
        "National University",
        "Nightingale Medical College, Dhaka",
        "Noakhali Medical College",
        "Noakhali Science & Technology University",
        "North Bengal International University",
        "North Bengal Medical College, Sirajganj",
        "North East Medical College, Sylhet",
        "North East University Bangladesh",
        "North South University",
        "North Western University",
        "Northern International Medical College, Dhaka",
        "Northern Private Medical College, Rangpur",
        "Northern University Bangladesh",
        "Northern University of Business & Technology, Khulna",
        "Notre Dame University Bangladesh",
        "Pabna Medical College",
        "Pabna University of Science and Technology",
        "Patuakhali Science And Technology University",
        "Popular Medical College & Hospital, Dhaka",
        "Port City International University",
        "Premier University, Chittagong",
        "Presidency University",
        "Prime Medical College, Rangpur",
        "Prime University",
        "Primeasia University",
        "Pundra University of Science & Technology",
        "Queens University",
        "R.T.M Al-Kabir Technical University",
        "Rabindra Maitree University, Kushtia",
        "Rabindra University, Bangladesh",
        "Rajshahi Medical College",
        "Rajshahi Medical University",
        "Rajshahi Science & Technology University (RSTU), Natore",
        "Rajshahi University",
        "Rajshahi University of Engineering & Technology",
        "Ranada Prasad Shaha University",
        "Rangamati Science and Technology University",
        "Rangpur Community Hospital Medical College",
        "Rangpur Medical College",
        "Rangpur University",
        "Royal University of Dhaka",
        "Rupayan A.K.M Shamsuzzoha University",
        "Sahabuddin Medical College and Hospital",
        "Samaj Vittik Medical College, Mirzanagar, Savar",
        "Satkhira Medical College",
        "Shah Makhdum Management University, Rajshahi",
        "Shahabuddin Medical College, Dhaka",
        "Shaheed Nazrul Islam Medical College",
        "Shaheed Suhrawardy Medical College",
        "Shaheed Ziaur Rahman Medical College",
        "Shahjalal University of Science & Technology",
        "Shanto Mariam University of Creative Technology",
        "Sheikh Fazilatunnesa Mujib University",
        "Sheikh Hasina University",
        "Sheikh Sayera Khatun Medical College, Gopalganj",
        "Sher-e-Bangla Agricultural University",
        "Sher-E-Bangla Medical College",
        "Sir Salimullah Medical College",
        "Sonargaon University",
        "South Asian University",
        "Southeast University",
        "Southern Medical College, Chittagong",
        "Southern University Bangladesh",
        "Southern University of Bangladesh, Chittagong",
        "Stamford University, Bangladesh",
        "State University Of Bangladesh",
        "Sylhet Agricultural University",
        "Sylhet Engineering College",
        "Sylhet International University, Sylhet",
        "Sylhet Medical University",
        "Sylhet Women's Medical College, Sylhet",
        "Tagore University of Creative Arts, Uttara, Dhaka, Bangladesh",
        "Tairunnessa Memorial Medical College, Gazipur",
        "The International University of Scholars",
        "The Millennium University",
        "The Peoples University of Bangladesh",
        "The University of Asia Pacific",
        "Times University, Bangladesh",
        "TMSS Medical College,Bogra",
        "Trust University, Barishal",
        "United International University",
        "University of Asia Pacific",
        "University of Barisal",
        "University of Brahmanbaria",
        "University of Chittagong",
        "University of Creative Technology, Chittagong",
        "University of Development Alternative",
        "University of Dhaka",
        "University of Global Village",
        "University of Information Technology & Sciences",
        "University of Liberal Arts Bangladesh",
        "University of Rajshahi",
        "University of Science & Technology, Chittagong",
        "University of Skill Enrichment and Technology",
        "University of South Asia",
        "Uttara Adhunik Medical College,Dhaka",
        "Uttara University",
        "Varendra University",
        "Victoria University of Bangladesh",
        "World University of Bangladesh",
        "Z. H. Sikder Women's Medical College",
        "Z.H Sikder University of Science & Technology",
        "Z.N.R.F. University of Management Sciences",
        "East Delta University , Chittagong",
        "East West University",
        "Eastern Medical College, Comilla",
        "Enam Medical College, Savar, Dhaka",
        "European University of Bangladesh",
        "Exim Bank Agricultural University, Bangladesh",
        "Fareast International University",
        "Faridpur Engineering College",
        "Faridpur Medical College",
        "Feni Medical College,Feni",
        "Feni University",
        "First Capital University of Bangladesh",
        "German University Bangladesh",
        "Global University Bangladesh",
        "Gono Bishwabidyalay, Savar, Dhaka",
        "Green Life Medical College, Dhaka",
        "Green University of Bangladesh",
        "Hajee Mohammad Danesh Science & Technology University",
        "Hamdard University Bangladesh",
        "Hobiganj Agricultural University",
        "Holy Family Red Crescent Medical College, Dhaka",
        "IBAIS University",
        "Ibn Sina Medical College, Dhaka",
        "Ibrahim Medical College, Dhaka",
        "Independent University, Bangladesh",
        "International Islamic University, Chittagong",
        "International Medical College, Gazipur",
        "International Standard University",
        "International University of Business Agriculture & Technology",
        "Ishakha International University, Bangladesh",
        "Islami Bank Medical College, Rajshahi",
        "Islamic Arabic University",
        "Islamic University of Technology",
        "Islamic University of Technology, Gazipur",
        "Islamic University, Bangladesh",
        "Islamic University, Kushtia",
        "Jagannath University",
        "Jahangirnagar University",
        "Jahurul Islam Medical College, Kishoregonj",
        "Jalalabad Ragib-Rabeya Medical College, Sylhet",
        "Jatiya Kabi Kazi Nazrul Islam University",
        "Jessore Medical College",
        "Jessore Science & Technology University",
        "Jessore University of Science & Technology",
        "Khawja Yunus Ali Medical College, Sirajganj",
        "Khulna Agricultural University",
        "Khulna Khan Bahadur Ahsanullah University",
        "Khulna Medical College",
        "Khulna University",
        "Khulna University of Engineering and Technology",
        "Khwaja Yunus Ali University",
        "Kumudini Medical College, Tangail",
        "Other"
    ];


    public static function createDirecrotory($jobid)
    {
        $path = public_path('assets/applicants/'.date("Y-d-m").'/'.$jobid);

        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

    }

    const QTOTA = [
        'মুক্তিযোদ্ধা / শহীদ মুক্তিযোদ্ধার পুত্র -কন্যা ' => 'মুক্তিযোদ্ধা / শহীদ মুক্তিযোদ্ধার পুত্র -কন্যা ',
        'মুক্তিযোদ্ধা / শহীদ মুক্তিযোদ্ধার পুত্র -কন্যার পুত্র -কন্যা' => 'মুক্তিযোদ্ধা / শহীদ মুক্তিযোদ্ধার পুত্র -কন্যার পুত্র -কন্যা',
        'ক্ষুদ্র নৃ -গোষ্ঠী' => 'ক্ষুদ্র নৃ -গোষ্ঠী',
        'শারীরিক প্রতিবন্দী ' => 'শারীরিক প্রতিবন্দী ',
        'এতিম' => 'এতিম', 'আনসার ও গ্রাম প্রতিরক্ষা সদস্য' => 'আনসার ও গ্রাম প্রতিরক্ষা সদস্য'
    ];
    const DIVISIONAPPLIANT=['হ্যাঁ'=>'হ্যাঁ',
        'না'=>'না',
        'প্রযোজ্য নয়'=>'প্রযোজ্য নয়',
    ];
    const EXPERIENCE=['১'=>'১','২'=>'২', '৩'=>'৩', '৪'=>'৪', '৫'=>'৫', '৬'=>'৬', '৭'=>'৭', '৮'=>'৮','৯'=>'৯','১০'=>'১০','১১'=>'১১','১২'=>'১২','১২+'=>'১২+',];
}



