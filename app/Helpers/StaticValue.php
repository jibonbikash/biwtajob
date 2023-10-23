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
         'অন্যান্য' => "অন্যান্য",
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
    const STATUS = [
        '1' => "Active",
        '2' => "Inactive",
    ];

    const STATUS_ELIGIBLE = [
        '1' => "Submited",
        '2' => "Eligible",
    ];

    const STATUS_ADMIN = [
        '1' => "Publish",
        '0' => "Draft",
    ];

    const NIDORBRN = [
        'BRN' => "জন্ম নিবন্ধন",
        'NID' => "জাতীয় পরিচয়",

    ];


    const RELATED_EXPERIENCE = [
        'আছে' => "আছে",
        'নাই' => "নাই",
        'প্রযোজ্য নয়' => "প্রযোজ্য নয়",

    ];

    const RESULTJSC = [
        'জিপিএ(আউট অফ ৪)' => "জিপিএ(আউট অফ ৪)",
        'জিপিএ(আউট অফ ৫)' => "জিপিএ(আউট অফ ৫)",
        'পাস' => "পাস",
    ];

    const RESULTSSC = [
        'প্রথম বিভাগ' => "প্রথম বিভাগ",
        'দ্বিতীয় বিভাগ' => "দ্বিতীয় বিভাগ",
        'তৃতীয় বিভাগ' => "তৃতীয় বিভাগ",
        'জিপিএ/সিজিপিএ(আউট অফ ৪)' => "জিপিএ/সিজিপিএ(আউট অফ ৪)",
        'জিপিএ/সিজিপিএ(আউট অফ ৫)' => "জিপিএ/সিজিপিএ(আউট অফ ৫)",
    ];
    const UNIVERSITIES = [
        1 => "Ad-din Womens Medical College, Dhaka",
        2 => "Ahsania Mission University of Science and Technology",
        3 => "Ahsanullah University of Science and Technology",
        4 => "America Bangladesh University",
        5 => "American International University Bangladesh",
        6 => "Anwer Khan Modern Medical College, Dhaka",
        7 => "Anwer Khan Modern University",
        8 => "ASA University Bangladesh",
        9 => "Asian University for Women",
        10 => "Asian University of Bangladesh",
        11 => "Atish Dipankar University of Science & Technology",
        12 => "Bandarban University",
        13 => "Bangabandhu Sheikh Mujib Medical University",
        14 => "Bangabandhu Sheikh Mujibur Rahman Agricultural University",
        15 => "Bangabandhu Sheikh Mujibur Rahman Aviation And Aerospace University",
        16 => "Bangabandhu Sheikh Mujibur Rahman Digital University",
        17 => "Bangabandhu Sheikh Mujibur Rahman Maritime University",
        18 => "Bangabandhu Sheikh Mujibur Rahman Science and Technology University",
        19 => "Bangabandhu Sheikh Mujibur Rahman Univerisity, Kishoreganj",
        20 => "Bangamata Sheikh Fojilatunnesa Mujib Science and Technology University",
        21 => "Bangladesh Agricultural University,Mymensingh",
        22 => "Bangladesh Airlines Training Centre (BATC)",
        23 => "Bangladesh Army International University of Science & Technology(BAIUST) ,Comilla",
        24 => "Bangladesh Army University of Engineering and Technology (BAUET), Qadirabad",
        25 => "Bangladesh Army University of Science and Technology(BAUST), Saidpur",
        26 => "Bangladesh Islami University",
        27 => "Bangladesh Medical College",
        28 => "Bangladesh Open University",
        29 => "Bangladesh University",
        30 => "Bangladesh University of Business & Technology (BUBT)",
        31 => "Bangladesh University of Engineering & Technology",
        32 => "Bangladesh University of Health Sciences",
        33 => "Bangladesh University of Professionals",
        34 => "Bangladesh University of Textiles",
        35 => "Barisal University",
        36 => "Barishal Engineering College",
        37 => "Begum Rokeya University, Rangpur",
        38 => "BGC Trust Medical College, Chittagong",
        39 => "BGC Trust University Bangladesh, Chittagong",
        40 => "BGMEA University of Fashion & Technology(BUFT)",
        41 => "BRAC University",
        42 => "Britannia University",
        43 => "Canadian University of Bangladesh",
        44 => "CCN University of Science & Technology",
        45 => "Central Medical College, Comilla",
        46 => "Central University of Science and Technology",
        47 => "Central Women's University",
        48 => "Chandpur Science and Technology University",
        49 => "Chittagong Independent University",
        50 => "Chittagong Medical College",
        51 => "Chittagong Medical University",
        52 => "Chittagong University of Engineering & Technology",
        53 => "Chittagong Veterinary and Animal Sciences University",
        54 => "Chottagram Ma-O-Shishu Hospital Medical College",
        55 => "City University",
        56 => "Comilla Medical College",
        57 => "Comilla University",
        58 => "Community Based Medical College (cbmc), Mymensingh",
        59 => "Community Medical College, Dhaka",
        60 => "Cox's Bazar International University",
        61 => "Cox's Bazar Medical College",
        62 => "Daffodil International University",
        63 => "Darul Ihsan University",
        64 => "Delta Medical College, Dhaka",
        65 => "Dhaka International University",
        66 => "Dhaka Medical College",
        67 => "Dhaka National Medical College",
        68 => "Dhaka University",
        69 => "Dhaka University of Engineering & Technology",
        70 => "Dinajpur Medical College",
        71 => "Durra Samad Rahman Red Crescent Women's Medical College, Sylhet",
        72 => "Kushtia Medical College",
        73 => "Labaid Medical College, Dhanmondi, Dhaka",
        74 => "Leading University, Sylhet",
        75 => "MAG Osmani Medical College",
        76 => "Manarat International University",
        77 => "Maulana Bhasani Medical College",
        78 => "Mawlana Bhashani Science & Technology University",
        79 => "Medical College for Women and Hospital, Dhaka",
        80 => "Metropolitan University, Sylhet",
        81 => "Microland University of Science and Technology",
        82 => "Military Institute of Science and Technology (MIST)",
        83 => "Mymensingh Engineering College",
        84 => "Mymensingh Medical College",
        85 => "N.P.I University of Bangladesh",
        86 => "National University",
        87 => "Nightingale Medical College, Dhaka",
        88 => "Noakhali Medical College",
        89 => "Noakhali Science & Technology University",
        90 => "North Bengal International University",
        91 => "North Bengal Medical College, Sirajganj",
        92 => "North East Medical College, Sylhet",
        93 => "North East University Bangladesh",
        94 => "North South University",
        95 => "North Western University",
        96 => "Northern International Medical College, Dhaka",
        97 => "Northern Private Medical College, Rangpur",
        98 => "Northern University Bangladesh",
        99 => "Northern University of Business & Technology, Khulna",
        100 => "Notre Dame University Bangladesh",
        101 => "Pabna Medical College",
        102 => "Pabna University of Science and Technology",
        103 => "Patuakhali Science And Technology University",
        104 => "Popular Medical College & Hospital, Dhaka",
        105 => "Port City International University",
        106 => "Premier University, Chittagong",
        107 => "Presidency University",
        108 => "Prime Medical College, Rangpur",
        109 => "Prime University",
        110 => "Primeasia University",
        111 => "Pundra University of Science & Technology",
        112 => "Queens University",
        113 => "R.T.M Al-Kabir Technical University",
        114 => "Rabindra Maitree University, Kushtia",
        115 => "Rabindra University, Bangladesh",
        116 => "Rajshahi Medical College",
        117 => "Rajshahi Medical University",
        118 => "Rajshahi Science & Technology University (RSTU), Natore",
        119 => "Rajshahi University",
        120 => "Rajshahi University of Engineering & Technology",
        121 => "Ranada Prasad Shaha University",
        122 => "Rangamati Science and Technology University",
        123 => "Rangpur Community Hospital Medical College",
        124 => "Rangpur Medical College",
        125 => "Rangpur University",
        126 => "Royal University of Dhaka",
        127 => "Rupayan A.K.M Shamsuzzoha University",
        128 => "Sahabuddin Medical College and Hospital",
        129 => "Samaj Vittik Medical College, Mirzanagar, Savar",
        130 => "Satkhira Medical College",
        131 => "Shah Makhdum Management University, Rajshahi",
        132 => "Shahabuddin Medical College, Dhaka",
        133 => "Shaheed Nazrul Islam Medical College",
        134 => "Shaheed Suhrawardy Medical College",
        135 => "Shaheed Ziaur Rahman Medical College",
        136 => "Shahjalal University of Science & Technology",
        137 => "Shanto Mariam University of Creative Technology",
        138 => "Sheikh Fazilatunnesa Mujib University",
        139 => "Sheikh Hasina University",
        140 => "Sheikh Sayera Khatun Medical College, Gopalganj",
        141 => "Sher-e-Bangla Agricultural University",
        142 => "Sher-E-Bangla Medical College",
        143 => "Sir Salimullah Medical College",
        144 => "Sonargaon University",
        145 => "South Asian University",
        146 => "Southeast University",
        147 => "Southern Medical College, Chittagong",
        148 => "Southern University Bangladesh",
        149 => "Southern University of Bangladesh, Chittagong",
        150 => "Stamford University, Bangladesh",
        151 => "State University Of Bangladesh",
        152 => "Sylhet Agricultural University",
        153 => "Sylhet Engineering College",
        154 => "Sylhet International University, Sylhet",
        155 => "Sylhet Medical University",
        156 => "Sylhet Women's Medical College, Sylhet",
        157 => "Tagore University of Creative Arts, Uttara, Dhaka, Bangladesh",
        158 => "Tairunnessa Memorial Medical College, Gazipur",
        159 => "The International University of Scholars",
        160 => "The Millennium University",
        161 => "The Peoples University of Bangladesh",
        162 => "The University of Asia Pacific",
        163 => "Times University, Bangladesh",
        164 => "TMSS Medical College,Bogra",
        165 => "Trust University, Barishal",
        166 => "United International University",
        167 => "University of Asia Pacific",
        168 => "University of Barisal",
        169 => "University of Brahmanbaria",
        170 => "University of Chittagong",
        171 => "University of Creative Technology, Chittagong",
        172 => "University of Development Alternative",
        173 => "University of Dhaka",
        174 => "University of Global Village",
        175 => "University of Information Technology & Sciences",
        176 => "University of Liberal Arts Bangladesh",
        177 => "University of Rajshahi",
        178 => "University of Science & Technology, Chittagong",
        179 => "University of Skill Enrichment and Technology",
        180 => "University of South Asia",
        181 => "Uttara Adhunik Medical College,Dhaka",
        182 => "Uttara University",
        183 => "Varendra University",
        184 => "Victoria University of Bangladesh",
        185 => "World University of Bangladesh",
        186 => "Z. H. Sikder Women's Medical College",
        187 => "Z.H Sikder University of Science & Technology",
        188 => "Z.N.R.F. University of Management Sciences",
        189 => "East Delta University , Chittagong",
        190 => "East West University",
        191 => "Eastern Medical College, Comilla",
        192 => "Enam Medical College, Savar, Dhaka",
        193 => "European University of Bangladesh",
        194 => "Exim Bank Agricultural University, Bangladesh",
        195 => "Fareast International University",
        196 => "Faridpur Engineering College",
        197 => "Faridpur Medical College",
        198 => "Feni Medical College,Feni",
        199 => "Feni University",
        200 => "First Capital University of Bangladesh",
        201 => "German University Bangladesh",
        202 => "Global University Bangladesh",
        203 => "Gono Bishwabidyalay, Savar, Dhaka",
        204 => "Green Life Medical College, Dhaka",
        205 => "Green University of Bangladesh",
        206 => "Hajee Mohammad Danesh Science & Technology University",
        207 => "Hamdard University Bangladesh",
        208 => "Hobiganj Agricultural University",
        209 => "Holy Family Red Crescent Medical College, Dhaka",
        210 => "IBAIS University",
        211 => "Ibn Sina Medical College, Dhaka",
        212 => "Ibrahim Medical College, Dhaka",
        213 => "Independent University, Bangladesh",
        214 => "International Islamic University, Chittagong",
        215 => "International Medical College, Gazipur",
        216 => "International Standard University",
        217 => "International University of Business Agriculture & Technology",
        218 => "Ishakha International University, Bangladesh",
        219 => "Islami Bank Medical College, Rajshahi",
        220 => "Islamic Arabic University",
        221 => "Islamic University of Technology",
        222 => "Islamic University of Technology, Gazipur",
        223 => "Islamic University, Bangladesh",
        224 => "Islamic University, Kushtia",
        225 => "Jagannath University",
        226 => "Jahangirnagar University",
        227 => "Jahurul Islam Medical College, Kishoregonj",
        228 => "Jalalabad Ragib-Rabeya Medical College, Sylhet",
        229 => "Jatiya Kabi Kazi Nazrul Islam University",
        230 => "Jessore Medical College",
        231 => "Jessore Science & Technology University",
        232 => "Jessore University of Science & Technology",
        233 => "Khawja Yunus Ali Medical College, Sirajganj",
        234 => "Khulna Agricultural University",
        235 => "Khulna Khan Bahadur Ahsanullah University",
        236 => "Khulna Medical College",
        237 => "Khulna University",
        238 => "Khulna University of Engineering and Technology",
        239 => "Khwaja Yunus Ali University",
        240 => "Kumudini Medical College, Tangail",
        241 => "Other"
    ];


    public static function createDirecrotory($jobid)
    {
        $path = public_path('assets/applicants/'.date("Y-d-m").'/'.$jobid);

        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

    }

    const QTOTA = [
        'মুক্তিযোদ্ধা / শহীদ মুক্তিযোদ্ধার পুত্র -কন্যা' => 'মুক্তিযোদ্ধা / শহীদ মুক্তিযোদ্ধার পুত্র -কন্যা ',
        'মুক্তিযোদ্ধা / শহীদ মুক্তিযোদ্ধার পুত্র -কন্যার পুত্র -কন্যা' => 'মুক্তিযোদ্ধা / শহীদ মুক্তিযোদ্ধার পুত্র -কন্যার পুত্র -কন্যা',
        'ক্ষুদ্র নৃ -গোষ্ঠী' => 'ক্ষুদ্র নৃ -গোষ্ঠী',
        'শারীরিক প্রতিবন্দী' => 'শারীরিক প্রতিবন্দী ',
        'এতিম' => 'এতিম',
        'আনসার ও গ্রাম প্রতিরক্ষা সদস্য' => 'আনসার ও গ্রাম প্রতিরক্ষা সদস্য'
    ];
    const DIVISIONAPPLIANT=['হ্যাঁ'=>'হ্যাঁ',
        'না'=>'না',
        'প্রযোজ্য নয়'=>'প্রযোজ্য নয়',
    ];
    const EXPERIENCE=['১'=>'১','২'=>'২', '৩'=>'৩', '৪'=>'৪', '৫'=>'৫', '৬'=>'৬', '৭'=>'৭', '৮'=>'৮','৯'=>'৯','১০'=>'১০','১১'=>'১১','১২'=>'১২','১২+'=>'১২+',];

  public static function  clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }



    public static function  englishToBengaliNumberConverter($number) {
        $englishNumbers = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $bengaliNumbers = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
        $bengaliNumber = str_replace($englishNumbers, $bengaliNumbers, $number);

        return $bengaliNumber;
    }

}



