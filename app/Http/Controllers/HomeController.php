<?php

namespace App\Http\Controllers;

use App\Helpers\StaticValue;
use App\Models\Applicant;
use App\Models\ApplicantCertificate;
use App\Models\ApplicantEducation;
use App\Models\Board;
use App\Models\Examlevel;
use App\Models\ExamlevelSubject;
use App\Models\Job;
use App\Models\JobApply;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //  $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       $jobs= Job::active()->activeJobs()->orderBy('id','DESC')->paginate(10);
        return view('home',['jobs'=>$jobs]);
    }
    public function details(Request $request, $uuid){
        try {
            $job= Job::active()->activeJobs()->where('uuid',$uuid)->firstOrFail();
            return view('jobs.details',['job'=>$job]);
        } catch (ModelNotFoundException $e) {

            return redirect()->route('home')
                ->with('error', 'No data found!!!');;
        }
    }

    public function applyform(Request $request, $uuid){
        try {
            $job= Job::with(['certificates'=>function($query){
                $query->with(['certificate'=>function($qq){
                    $qq->select('id','name')->pluck('name','id');
                }]);
            }])->active()->activeJobs()->where('uuid',$uuid)->firstOrFail();
        //    dd($job);
            $district_Upozilla = DB::table('district_upozilla')->orderBy('zilla_name','ASC')->get()->toArray();
            $boards = DB::table('boards')->orderBy('name','ASC')->get();

           $examlist= Examlevel::select('id','name','status')->with(['examGroups'=>function($quert){
               $quert->with(['examSubject'=>function($query){
                   $query->select('id','examlevel_id','examlevel_group_id','name');
               }])->select('id','examlevel_id','name','status');
           }])->get();
         //   dd($district_Upozilla);
          //  dd($examlist);
            return view('jobs.applyform',[
                'job'=>$job,
                'district_Upozilla'=>$district_Upozilla,
                'boards'=>$boards,
                'examlist'=>$examlist,
                'uuid'=>$uuid,
                ]);
        } catch (ModelNotFoundException $e) {

            return redirect()->route('home')
                ->with('error', 'No data found!!!');;
        }
    }

    public function examSubject(Request $request){

      $subject=  ExamlevelSubject::with(['examGroup','examlevel'])
            ->where([
                ['examlevel_id', $request->exam],
                ['examlevel_group_id', $request->examgroup],
            ])->get();
        return response()->json(['success' => true, 'data' => $subject]);

    }

    public function jobApply(Request $request){



       $job= Job::where('uuid',$request->uuid )->first();
       //dd($job);
        if($job){

            $validator = Validator::make($request->all(), [
                'uuid' => 'required',
                'name_en' => 'required|max:255',
                'name_bn' => 'required|max:255',
                'father_name' => 'required|max:255',
                'mother_name' => 'required|max:255',
                'date_of_birth' => 'required|max:255',
                'mobile_no' => 'required|max:255',
                'nationality' => 'required|max:255',
                'religion' => 'required|max:255',
                'gender' => 'required|max:255',
                'date_of_place' => 'required|max:255',
                'present_postoffice' => 'required|max:255',
                'present_postcode' => 'required|max:255',
                'present_zilla' => 'required|max:255',
                'present_upozilla' => 'required|max:255',
                'permanent_postoffice' => 'required|max:255',
                'permanent_postcode' => 'required|max:255',
                'permanent_zilla' => 'required|max:255',
                'permanent_upozilla' => 'required|max:255',
                'image' => 'required|mimes:jpeg,png,jpg,gif|max:1024',
                'signature' => 'required|mimes:jpeg,png,jpg,gif|max:1024|dimensions:max_width=300,max_height=300',
               // ['certificate.in' => 'The certificate field is required.............']

            ]);
            $flag=false;
            $validator->sometimes('jscexamlevel', 'required', function () use ($job){
                return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
            });
            $validator->sometimes('jscinstitute_name', 'required', function () use ($job){
              //  return $job->jsc==1;
                return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
            });
            $validator->sometimes('jscresult', 'required', function () use ($job){
             //   return $job->jsc==1;
                return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
            });
            $validator->sometimes('jscboard', 'required', function () use ($job){
               /// return $job->jsc==1;
                return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
            });
            $validator->sometimes('jscpassyear', 'required', function () use ($job){
               // return $job->jsc==1;
                return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
            });

            $validator->sometimes('sscexamlevel', 'required', function () use ($job){
            //    return $job->ssc==1;
                return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
            });
            $validator->sometimes('sscinstitute_name', 'required', function () use ($job){
              //  return $job->ssc==1;
                return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
            });
            $validator->sometimes('sscresult', 'required', function () use ($job){
              //  return $job->ssc==1;
                return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
            });
            $validator->sometimes('sscSubject', 'required', function () use ($job){
               // return $job->ssc==1;
                return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
            });
            $validator->sometimes('sscboard', 'required', function () use ($job){
             //   return $job->ssc==1;
                return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
            });
            $validator->sometimes('sscpassyear', 'required', function () use ($job){
               // return $job->ssc==1;
                return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
            });

            $validator->sometimes('hscexamlevel', 'required', function () use ($job){
                return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
             //   return $job->hsc==1;
            });
            $validator->sometimes('hscinstitute_name', 'required', function () use ($job){
              //  return $job->hsc==1;
                return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
            });
            $validator->sometimes('hscresult', 'required', function () use ($job){
             //   return $job->hsc==1;
                return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
            });
            $validator->sometimes('hscubject', 'required', function () use ($job){
              //  return $job->hsc==1;
                return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
            });
            $validator->sometimes('hscboard', 'required', function () use ($job){
               // return $job->hsc==1;
                return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
            });
            $validator->sometimes('hscpassyear', 'required', function () use ($job){
             //   return $job->hsc==1;
                return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
            });

            $validator->sometimes('graduationexamlevel', 'required', function () use ($job){
              //  return $job->graduation==1;
                return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
            });
            $validator->sometimes('graduationinstitute_name', 'required', function () use ($job){
              //  return $job->graduation==1;
                return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
            });
            $validator->sometimes('graduationresult', 'required', function () use ($job){
               // return $job->graduation==1;
                return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
            });
            $validator->sometimes('graduationsubject', 'required', function () use ($job){
              //  return $job->graduation==1;
                return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
            });
            $validator->sometimes('graduationuniversity', 'required', function () use ($job){
              //  return $job->graduation==1;
                return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
            });
            $validator->sometimes('graduationpassyear', 'required', function () use ($job){
               // return $job->graduation==1;
                return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
            });


            $validator->sometimes('mastersexamlevel', 'required', function () use ($job){
              //  return $job->masters==1;
                return (( $job->min_education=='Masters') AND  $job->masters==1);
            });
            $validator->sometimes('mastersinstitute_name', 'required', function () use ($job){
               // return $job->masters==1;
                return (( $job->min_education=='Masters') AND  $job->masters==1);
            });
            $validator->sometimes('mastersresult', 'required', function () use ($job){
             //   return $job->masters==1;
                return (( $job->min_education=='Masters') AND  $job->masters==1);
            });
            $validator->sometimes('mastersSubject', 'required', function () use ($job){
              //  return $job->masters==1;
                return (( $job->min_education=='Masters') AND  $job->masters==1);
            });
            $validator->sometimes('mastersuniversity', 'required', function () use ($job){
               // return $job->masters==1;
                return (( $job->min_education=='Masters') AND  $job->masters==1);
            });
            $validator->sometimes('masterspassyear', 'required', function () use ($job){
               // return $job->masters==1;
                return (( $job->min_education=='Masters') AND  $job->masters==1);
            });

            if($job->min_education_con=="AND"){
                $validator->sometimes('jscexamlevel', 'required', function () use ($job){
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                });
                $validator->sometimes('jscinstitute_name', 'required', function () use ($job){
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                });
                $validator->sometimes('jscresult', 'required', function () use ($job){
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                });
                $validator->sometimes('jscboard', 'required', function () use ($job){
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                });
                $validator->sometimes('jscpassyear', 'required', function () use ($job){
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                });

                $validator->sometimes('sscexamlevel', 'required', function () use ($job){
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                });
                $validator->sometimes('sscinstitute_name', 'required', function () use ($job){
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                });
                $validator->sometimes('sscresult', 'required', function () use ($job){
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                });
                $validator->sometimes('sscSubject', 'required', function () use ($job){
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                });
                $validator->sometimes('sscboard', 'required', function () use ($job){
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                });
                $validator->sometimes('sscpassyear', 'required', function () use ($job){
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                });

                $validator->sometimes('hscexamlevel', 'required', function () use ($job){
                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                });
                $validator->sometimes('hscinstitute_name', 'required', function () use ($job){
                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                });
                $validator->sometimes('hscresult', 'required', function () use ($job){
                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                });
                $validator->sometimes('hscubject', 'required', function () use ($job){
                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                });
                $validator->sometimes('hscboard', 'required', function () use ($job){
                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                });
                $validator->sometimes('hscpassyear', 'required', function () use ($job){
                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                });

                $validator->sometimes('graduationexamlevel', 'required', function () use ($job){
                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                });
                $validator->sometimes('graduationinstitute_name', 'required', function () use ($job){
                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                });
                $validator->sometimes('graduationresult', 'required', function () use ($job){
                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                });
                $validator->sometimes('graduationsubject', 'required', function () use ($job){
                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                });
                $validator->sometimes('graduationuniversity', 'required', function () use ($job){
                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                });
                $validator->sometimes('graduationpassyear', 'required', function () use ($job){
                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                });


                $validator->sometimes('mastersexamlevel', 'required', function () use ($job){
                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                });
                $validator->sometimes('mastersinstitute_name', 'required', function () use ($job){
                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                });
                $validator->sometimes('mastersresult', 'required', function () use ($job){
                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                });
                $validator->sometimes('mastersSubject', 'required', function () use ($job){
                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                });
                $validator->sometimes('mastersuniversity', 'required', function () use ($job){
                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                });
                $validator->sometimes('masterspassyear', 'required', function () use ($job){
                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                });
            }

            $validator->sometimes('certificate', 'required', function () use ($job){
                return $job->certificate_isrequired==1;
            });

            $validator->sometimes('certificateinstitute_name', 'required', function () use ($job){
                return $job->certificate_isrequired==1;
            });
           $validator->sometimes('certificateduration', 'required', function () use ($job){
                return $job->certificate_isrequired==1;
            });
//            $validator->sometimes('hscexamlevel', 'required', function () use ($job){
//                return $job->min_education=='HSC';
//            });
//            $validator->sometimes('hscexamlevel', 'required', function () use ($job){
//                return $job->min_education=='JSC';
//            });\

//            if($request->min_education_con=="OR"){
//
//            }
//            if($request->min_education_con=="AND"){
//
//            }

            /*
            if($request->min_education_con){
                //   dd($job->min_education, $job->min_education_con, $job->min_education_with);

                if($job->min_education=="JSC"){
                    $validator->sometimes('jscexamlevel', 'required', function () use ($job){
                        return $job->jsc==1;
                    });
                    $validator->sometimes('jscinstitute_name', 'required', function () use ($job){
                        return $job->jsc==1;
                    });
                    $validator->sometimes('jscresult', 'required', function () use ($job){
                        return $job->jsc==1;
                    });
                    $validator->sometimes('jscboard', 'required', function () use ($job){
                        return $job->jsc==1;
                    });
                    $validator->sometimes('jscpassyear', 'required', function () use ($job){
                        return $job->jsc==1;
                    });
                }

                elseif ($job->min_education=="SSC"){
                    $validator->sometimes('sscexamlevel', 'required', function () use ($job){
                        return $job->ssc==1;
                    });
                    $validator->sometimes('sscinstitute_name', 'required', function () use ($job){
                        return $job->ssc==1;
                    });
                    $validator->sometimes('sscresult', 'required', function () use ($job){
                        return $job->ssc==1;
                    });
                    $validator->sometimes('sscSubject', 'required', function () use ($job){
                        return $job->ssc==1;
                    });
                    $validator->sometimes('sscboard', 'required', function () use ($job){
                        return $job->ssc==1;
                    });
                    $validator->sometimes('sscpassyear', 'required', function () use ($job){
                        return $job->ssc==1;
                    });
                }
                elseif($job->min_education=="HSC"){
                    $validator->sometimes('hscexamlevel', 'required', function () use ($job){
                        return $job->hsc==1;
                    });
                    $validator->sometimes('hscinstitute_name', 'required', function () use ($job){
                        return $job->hsc==1;
                    });
                    $validator->sometimes('hscresult', 'required', function () use ($job){
                        return $job->hsc==1;
                    });
                    $validator->sometimes('hscubject', 'required', function () use ($job){
                        return $job->hsc==1;
                    });
                    $validator->sometimes('hscboard', 'required', function () use ($job){
                        return $job->hsc==1;
                    });
                    $validator->sometimes('hscpassyear', 'required', function () use ($job){
                        return $job->hsc==1;
                    });

                }
                elseif($job->min_education=="Graduation"){
                    $validator->sometimes('graduationexamlevel', 'required', function () use ($job){
                        return $job->graduation==1;
                    });
                    $validator->sometimes('graduationinstitute_name', 'required', function () use ($job){
                        return $job->graduation==1;
                    });
                    $validator->sometimes('graduationresult', 'required', function () use ($job){
                        return $job->graduation==1;
                    });
                    $validator->sometimes('graduationsubject', 'required', function () use ($job){
                        return $job->graduation==1;
                    });
                    $validator->sometimes('graduationuniversity', 'required', function () use ($job){
                        return $job->graduation==1;
                    });
                    $validator->sometimes('graduationpassyear', 'required', function () use ($job){
                        return $job->graduation==1;
                    });

                }
                elseif($job->min_education=="Masters"){
                    $validator->sometimes('mastersexamlevel', 'required', function () use ($job){
                        return $job->masters==1;
                    });
                    $validator->sometimes('mastersinstitute_name', 'required', function () use ($job){
                        return $job->masters==1;
                    });
                    $validator->sometimes('mastersresult', 'required', function () use ($job){
                        return $job->masters==1;
                    });
                    $validator->sometimes('mastersSubject', 'required', function () use ($job){
                        return $job->masters==1;
                    });
                    $validator->sometimes('mastersuniversity', 'required', function () use ($job){
                        return $job->masters==1;
                    });
                    $validator->sometimes('masterspassyear', 'required', function () use ($job){
                        return $job->masters==1;
                    });

                }

            }

            if($request->min_education_with){
                //   dd($job->min_education, $job->min_education_con, $job->min_education_with);

                if($job->min_education=="JSC"){
                    $validator->sometimes('jscexamlevel', 'required', function () use ($job){
                        return $job->jsc==1;
                    });
                    $validator->sometimes('jscinstitute_name', 'required', function () use ($job){
                        return $job->jsc==1;
                    });
                    $validator->sometimes('jscresult', 'required', function () use ($job){
                        return $job->jsc==1;
                    });
                    $validator->sometimes('jscboard', 'required', function () use ($job){
                        return $job->jsc==1;
                    });
                    $validator->sometimes('jscpassyear', 'required', function () use ($job){
                        return $job->jsc==1;
                    });
                }

                elseif ($job->min_education=="SSC"){
                    $validator->sometimes('sscexamlevel', 'required', function () use ($job){
                        return $job->ssc==1;
                    });
                    $validator->sometimes('sscinstitute_name', 'required', function () use ($job){
                        return $job->ssc==1;
                    });
                    $validator->sometimes('sscresult', 'required', function () use ($job){
                        return $job->ssc==1;
                    });
                    $validator->sometimes('sscSubject', 'required', function () use ($job){
                        return $job->ssc==1;
                    });
                    $validator->sometimes('sscboard', 'required', function () use ($job){
                        return $job->ssc==1;
                    });
                    $validator->sometimes('sscpassyear', 'required', function () use ($job){
                        return $job->ssc==1;
                    });
                }
                elseif($job->min_education=="HSC"){
                    $validator->sometimes('hscexamlevel', 'required', function () use ($job){
                        return $job->hsc==1;
                    });
                    $validator->sometimes('hscinstitute_name', 'required', function () use ($job){
                        return $job->hsc==1;
                    });
                    $validator->sometimes('hscresult', 'required', function () use ($job){
                        return $job->hsc==1;
                    });
                    $validator->sometimes('hscubject', 'required', function () use ($job){
                        return $job->hsc==1;
                    });
                    $validator->sometimes('hscboard', 'required', function () use ($job){
                        return $job->hsc==1;
                    });
                    $validator->sometimes('hscpassyear', 'required', function () use ($job){
                        return $job->hsc==1;
                    });

                }
                elseif($job->min_education=="Graduation"){
                    $validator->sometimes('graduationexamlevel', 'required', function () use ($job){
                        return $job->graduation==1;
                    });
                    $validator->sometimes('graduationinstitute_name', 'required', function () use ($job){
                        return $job->graduation==1;
                    });
                    $validator->sometimes('graduationresult', 'required', function () use ($job){
                        return $job->graduation==1;
                    });
                    $validator->sometimes('graduationsubject', 'required', function () use ($job){
                        return $job->graduation==1;
                    });
                    $validator->sometimes('graduationuniversity', 'required', function () use ($job){
                        return $job->graduation==1;
                    });
                    $validator->sometimes('graduationpassyear', 'required', function () use ($job){
                        return $job->graduation==1;
                    });

                }
                elseif($job->min_education=="Masters"){
                    $validator->sometimes('mastersexamlevel', 'required', function () use ($job){
                        return $job->masters==1;
                    });
                    $validator->sometimes('mastersinstitute_name', 'required', function () use ($job){
                        return $job->masters==1;
                    });
                    $validator->sometimes('mastersresult', 'required', function () use ($job){
                        return $job->masters==1;
                    });
                    $validator->sometimes('mastersSubject', 'required', function () use ($job){
                        return $job->masters==1;
                    });
                    $validator->sometimes('mastersuniversity', 'required', function () use ($job){
                        return $job->masters==1;
                    });
                    $validator->sometimes('masterspassyear', 'required', function () use ($job){
                        return $job->masters==1;
                    });

                }

            }
*/
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        //    dd($request->all());
           $jobinfo= Job::where('uuid', $request->input('uuid'))->first();

            $image = $request->file('image');
            $signature = $request->file('signature');
            $extension = $image->getClientOriginalExtension();
            $extensionsignature = $signature->getClientOriginalExtension();
            $nameimage = time() . '-' . mt_rand() . "." . $extension;
            $namesignature = time() . '-' . mt_rand() . "_signature." . $extensionsignature;
            StaticValue::createDirecrotory($jobinfo->job_id);
            $image->move(public_path('assets/applicants/'.date("Y").'/'.$jobinfo->job_id), $nameimage);
            $signature->move(public_path('assets/applicants/'.date("Y").'/'.$jobinfo->job_id), $namesignature);
            $nameimage=date("Y").'/'.$jobinfo->job_id.'/'.$nameimage;
            $namesignature=date("Y").'/'.$jobinfo->job_id.'/'.$namesignature;


            DB::beginTransaction();

            try {

                $applicant= Applicant::create([
                    'job_id' => $jobinfo->id,
                    'uuid' => (string)Str::orderedUuid(),
                    'name_bn' => $request->input('name_bn'),
                    'name_en' => $request->input('name_en'),
                    'nid' => $request->input('nid'),
                    'brn' => $request->input('brn'),
                    'bday' => $request->input('date_of_birth'),
                    'bplace' => $request->input('date_of_place'),
                    'father_name' => $request->input('father_name'),
                    'mother_name' => $request->input('mother_name'),
                    'present_addrress' => null,
                    'parmanent_address' => null,
                    'mobile' => $request->input('mobile_no'),
                    'nationality' => $request->input('nationality'),
                    'gender' => $request->input('gender'),
                    'religious' => $request->input('religion'),
                    'extra_qualification' => $request->input('extQualification'),
                    'experience' => $request->input('Experience'),
                    'bank_draft' => '',
                    'bank_draft_date' => '',
                    'bank_details' => '',
                    'division_appli' =>$request->input('divisioncaplicant'),
                    'quota_freedom' => 0,
                    'quota_tribal' => 0,
                    'quota_Handicapped' => 0,
                    'quota_orphanages' => 0,
                    'village_police' => 0,
                    'others_quota' => 0,
                    'quota' => $request->input('quota'),
                    'pa_house' => $request->input('present_house_no'),
                    'pa_village' => $request->input('present_village'),
                    'pa_union' => $request->input('present_union'),
                    'pa_postoffice' => $request->input('present_postoffice'),
                    'pa_postcode' => $request->input('present_postcode'),
                    'pa_upozilla' => $request->input('present_upozilla'),
                    'pa_zilla' => $request->input('present_zilla'),
                    'pr_house' => $request->input('permanent_house_no'),
                    'pr_village' => $request->input('permanent_village'),
                    'pr_union' => $request->input('permanent_union'),
                    'pr_postoffice' => $request->input('permanent_postoffice'),
                    'pr_postcode' => $request->input('permanent_postcode'),
                    'pr_upozilla' => $request->input('permanent_upozilla'),
                    'pr_zilla' => $request->input('permanent_zilla'),
                    'occupation' => $request->input('occupation'),
                    'picture' => $nameimage,
                    'signature' => $namesignature,
                    'job_circular' => '',
                    'experienceyear' => $request->input('experienceyear'),
                    'experiencemonth' => $request->input('experiencemonth'),
                    'age' => '',
                    'code' => '',
                    'eligible' => 0,
                    'jobcurday' => $request->input('jobcurday'),
                ]);
                $education=[];

                if($request->input('jscexamlevel')){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicant->id,
                        'job_id'=> $jobinfo->id,
                        'edu_level'=> $request->input('jscexamlevel'),
                        'institute_name'=> $request->input('jscinstitute_name'),
                        'group_subject'=> null,
                        'result'=> $request->input('jscresult'),
                        'cgpa'=> $request->input('jscresult_score'),
                        'out_of'=> $request->input('jscresult'),
                        'board_university'=> $request->input('jscboard'),
                        'passing_year'=> $request->input('jscpassyear'),
                    ]);
                }

                if($request->input('sscexamlevel')){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicant->id,
                        'job_id'=> $jobinfo->id,
                        'edu_level'=> $request->input('sscexamlevel'),
                        'institute_name'=> $request->input('sscinstitute_name'),
                        'group_subject'=> $request->input('sscSubject'),
                        'result'=> $request->input('sscresult'),
                        'cgpa'=> $request->input('sscresult_score'),
                        'out_of'=> $request->input('sscresult'),
                        'board_university'=> $request->input('sscboard'),
                        'passing_year'=> $request->input('sscpassyear'),
                    ]);

                }

                if($request->input('hscexamlevel')){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicant->id,
                        'job_id'=> $jobinfo->id,
                        'edu_level'=> $request->input('hscexamlevel'),
                        'institute_name'=> $request->input('hscinstitute_name'),
                        'group_subject'=> $request->input('hscubject'),
                        'result'=> $request->input('hscresult'),
                        'cgpa'=> $request->input('hscresult_score'),
                        'out_of'=> $request->input('hscresult'),
                        'board_university'=> $request->input('hscboard'),
                        'passing_year'=> $request->input('hscpassyear'),
                    ]);

                }
                if($request->input('graduationexamlevel')){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicant->id,
                        'job_id'=> $jobinfo->id,
                        'edu_level'=> $request->input('graduationexamlevel'),
                        'institute_name'=> $request->input('graduationinstitute_name'),
                        'group_subject'=> $request->input('graduationsubject'),
                        'result'=> $request->input('graduationresult'),
                        'cgpa'=> $request->input('graduationresult_score'),
                        'out_of'=> $request->input('graduationresult'),
                        'board_university'=> $request->input('graduationuniversity'),
                        'passing_year'=> $request->input('graduationpassyear'),
                    ]);

                }
                if($request->input('mastersexamlevel')){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicant->id,
                        'job_id'=> $jobinfo->id,
                        'edu_level'=> $request->input('mastersexamlevel'),
                        'institute_name'=> $request->input('mastersinstitute_name'),
                        'group_subject'=> $request->input('mastersSubject'),
                        'result'=> $request->input('mastersresult'),
                        'cgpa'=> $request->input('mastersresult_score'),
                        'out_of'=> $request->input('mastersresult'),
                        'board_university'=> $request->input('mastersuniversity'),
                        'passing_year'=> $request->input('masterspassyear'),
                    ]);

                }
                if($jobinfo->certificate=="YES"){
                    ApplicantCertificate::create([
                        'applicants_id'=> $applicant->id,
                        'job_id'=> $jobinfo->id,
                        'edu_level'=> $request->input('certificate'),
                        'institute_name'=> $request->input('certificateinstitute_name'),
                        'duration'=> $request->input('certificateduration'),
                    ]);

                }

                DB::commit();
                return redirect()->route('applicantPreview', ['uuid' => $applicant->uuid]);
            } catch (\Exception $e) {
                DB::rollback();
dd($e->getMessage());
            }
            dd($request->all());

        }
        else{
            return redirect()->back()
                ->with('error', 'Something went wrong. Try again');
        }


//        $request->validate([
//            'name_en' => 'required|max:255',
//            'name_bn' => 'required|max:255',
//            'father_name' => 'required|max:255',
//            'mother_name' => 'required|max:255',
//            'date_of_birth' => 'required|max:255',
//            'mobile_no' => 'required|max:255',
//            'nationality' => 'required|max:255',
//            'religion' => 'required|max:255',
//            'gender' => 'required|max:255',
//            'date_of_place' => 'required|max:255',
//
//        ]);
    }

    public function applicantPreview(Request $request, $uuid)
    {

        try {

            $applicationinfo = Applicant::with(['educations', 'job', 'birthplace', 'zila', 'upozilla', 'permanentzila', 'permanentupozilla'])->where('uuid', $uuid)->first();
            //dd($applicationinfo);
            if ($applicationinfo->eligible == 0) {
                return view('jobs.applyformPreview', ['applicationinfo' => $applicationinfo]);
            } else {
                return redirect()->route('home')
                    ->with('error', 'No data found!!!');;
            }

        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect()->route('home')
                ->with('error', 'Something wrong!!');;
        }


    }

    public function applicantPreviewEdit(Request $request, $uuid){
        $applicationinfo= Applicant::with(['educations','job', 'birthplace','zila','upozilla','permanentzila','permanentupozilla','applicantCertificate'])->where('uuid', $uuid)->first();

        $job= Job::find($applicationinfo->job_id);
        $district_Upozilla = DB::table('district_upozilla')->orderBy('zilla_name','ASC')->get()->toArray();
        $district = DB::table('district_upozilla')->where('zilla_id',0)->orderBy('zilla_name','ASC')->pluck('zilla_name','id');

        $boards = DB::table('boards')->orderBy('name','ASC')->get();
        // pluck('name','id')
        //dd(collect($boards)->where('type',1)->pluck('name','id'));
        $examlist= Examlevel::select('id','name','status')->with(['examGroups'=>function($quert){
            $quert->with(['examSubject'=>function($query){
                $query->select('id','examlevel_id','examlevel_group_id','name');
            }])->select('id','examlevel_id','name','status');
        }])->get();
        return view('jobs.applyformPreviewEdit',[
            'applicationinfo'=>$applicationinfo,
            'job'=>$job,
            'district_Upozilla'=>$district_Upozilla,
            'boards'=>$boards,
            'district'=>$district,
            'examlist'=>$examlist,]);
    }

    public function applicantPreviewConfirm(Request $request, $uuid){
        $applicationinfo= Applicant::with(['educations','job', 'birthplace','zila','upozilla','permanentzila','permanentupozilla'])->where('uuid', $uuid)->first();
        $job= Job::find($applicationinfo->job_id);
        if($applicationinfo && $job){
            $validator = Validator::make($request->all(), [
                'name_en' => 'required|max:255',
                'name_bn' => 'required|max:255',
                'father_name' => 'required|max:255',
                'mother_name' => 'required|max:255',
                'date_of_birth' => 'required|max:255',
                'mobile_no' => 'required|max:255',
                'nationality' => 'required|max:255',
                'religion' => 'required|max:255',
                'gender' => 'required|max:255',
                'date_of_place' => 'required|max:255',
                'present_postoffice' => 'required|max:255',
                'present_postcode' => 'required|max:255',
                'present_zilla' => 'required|max:255',
                'present_upozilla' => 'required|max:255',
                'permanent_postoffice' => 'required|max:255',
                'permanent_postcode' => 'required|max:255',
                'permanent_zilla' => 'required|max:255',
                'permanent_upozilla' => 'required|max:255',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:1024',
                'signature' => 'nullable|mimes:jpeg,png,jpg,gif|max:1024|dimensions:max_width=300,max_height=300',

            ]);

            $validator->sometimes('jscexamlevel', 'required', function () use ($job){
                return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
            });
            $validator->sometimes('jscinstitute_name', 'required', function () use ($job){
                return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
            });
            $validator->sometimes('jscresult', 'required', function () use ($job){
                return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
            });
            $validator->sometimes('jscboard', 'required', function () use ($job){
                return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
            });
            $validator->sometimes('jscpassyear', 'required', function () use ($job){
                return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
            });

            $validator->sometimes('sscexamlevel', 'required', function () use ($job){
                return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
            });
            $validator->sometimes('sscinstitute_name', 'required', function () use ($job){
                return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
            });
            $validator->sometimes('sscresult', 'required', function () use ($job){
                return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
            });
            $validator->sometimes('sscSubject', 'required', function () use ($job){
                return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
            });
            $validator->sometimes('sscboard', 'required', function () use ($job){
                return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
            });
            $validator->sometimes('sscpassyear', 'required', function () use ($job){
                return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
            });

            $validator->sometimes('hscexamlevel', 'required', function () use ($job){
                return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
            });
            $validator->sometimes('hscinstitute_name', 'required', function () use ($job){
                return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
            });
            $validator->sometimes('hscresult', 'required', function () use ($job){
                return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
            });
            $validator->sometimes('hscubject', 'required', function () use ($job){
                return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
            });
            $validator->sometimes('hscboard', 'required', function () use ($job){
                return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
            });
            $validator->sometimes('hscpassyear', 'required', function () use ($job){
                return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
            });

            $validator->sometimes('graduationexamlevel', 'required', function () use ($job){
                return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
            });
            $validator->sometimes('graduationinstitute_name', 'required', function () use ($job){
                return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
            });
            $validator->sometimes('graduationresult', 'required', function () use ($job){
                return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
            });
            $validator->sometimes('graduationsubject', 'required', function () use ($job){
                return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
            });
            $validator->sometimes('graduationuniversity', 'required', function () use ($job){
                return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
            });
            $validator->sometimes('graduationpassyear', 'required', function () use ($job){
                return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
            });


            $validator->sometimes('mastersexamlevel', 'required', function () use ($job){
                return (( $job->min_education=='Masters') AND  $job->masters==1);
            });
            $validator->sometimes('mastersinstitute_name', 'required', function () use ($job){
                return (( $job->min_education=='Masters') AND  $job->masters==1);
            });
            $validator->sometimes('mastersresult', 'required', function () use ($job){
                return (( $job->min_education=='Masters') AND  $job->masters==1);
            });
            $validator->sometimes('mastersSubject', 'required', function () use ($job){
                return (( $job->min_education=='Masters') AND  $job->masters==1);
            });
            $validator->sometimes('mastersuniversity', 'required', function () use ($job){
                return (( $job->min_education=='Masters') AND  $job->masters==1);
            });
            $validator->sometimes('masterspassyear', 'required', function () use ($job){
                return (( $job->min_education=='Masters') AND  $job->masters==1);
            });

            if($job->min_education_con=="AND"){
                $validator->sometimes('jscexamlevel', 'required', function () use ($job){
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                });
                $validator->sometimes('jscinstitute_name', 'required', function () use ($job){
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                });
                $validator->sometimes('jscresult', 'required', function () use ($job){
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC' OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                });
                $validator->sometimes('jscboard', 'required', function () use ($job){
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                });
                $validator->sometimes('jscpassyear', 'required', function () use ($job){
                    return (($job->min_education=='JSC' OR $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->jsc==1);
                });

                $validator->sometimes('sscexamlevel', 'required', function () use ($job){
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                });
                $validator->sometimes('sscinstitute_name', 'required', function () use ($job){
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                });
                $validator->sometimes('sscresult', 'required', function () use ($job){
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                });
                $validator->sometimes('sscSubject', 'required', function () use ($job){
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                });
                $validator->sometimes('sscboard', 'required', function () use ($job){
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                });
                $validator->sometimes('sscpassyear', 'required', function () use ($job){
                    return (( $job->min_education=='SSC' OR  $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->ssc==1);
                });

                $validator->sometimes('hscexamlevel', 'required', function () use ($job){
                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                });
                $validator->sometimes('hscinstitute_name', 'required', function () use ($job){
                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                });
                $validator->sometimes('hscresult', 'required', function () use ($job){
                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                });
                $validator->sometimes('hscubject', 'required', function () use ($job){
                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                });
                $validator->sometimes('hscboard', 'required', function () use ($job){
                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                });
                $validator->sometimes('hscpassyear', 'required', function () use ($job){
                    return (( $job->min_education=='HSC'  OR  $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->hsc==1);
                });

                $validator->sometimes('graduationexamlevel', 'required', function () use ($job){
                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                });
                $validator->sometimes('graduationinstitute_name', 'required', function () use ($job){
                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                });
                $validator->sometimes('graduationresult', 'required', function () use ($job){
                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                });
                $validator->sometimes('graduationsubject', 'required', function () use ($job){
                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                });
                $validator->sometimes('graduationuniversity', 'required', function () use ($job){
                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                });
                $validator->sometimes('graduationpassyear', 'required', function () use ($job){
                    return (( $job->min_education=='Graduation' OR  $job->min_education=='Masters') AND  $job->graduation==1);
                });


                $validator->sometimes('mastersexamlevel', 'required', function () use ($job){
                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                });
                $validator->sometimes('mastersinstitute_name', 'required', function () use ($job){
                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                });
                $validator->sometimes('mastersresult', 'required', function () use ($job){
                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                });
                $validator->sometimes('mastersSubject', 'required', function () use ($job){
                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                });
                $validator->sometimes('mastersuniversity', 'required', function () use ($job){
                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                });
                $validator->sometimes('masterspassyear', 'required', function () use ($job){
                    return (( $job->min_education=='Masters') AND  $job->masters==1);
                });
            }

            $validator->sometimes('certificate', 'required', function () use ($job){
                return $job->certificate_isrequired==1;
            });

            $validator->sometimes('certificateinstitute_name', 'required', function () use ($job){
                return $job->certificate_isrequired==1;
            });
            $validator->sometimes('certificateduration', 'required', function () use ($job){
                return $job->certificate_isrequired==1;
            });
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            StaticValue::createDirecrotory($job->job_id);
            if($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $nameimage = time() . '-' . mt_rand() . "." . $extension;
                $image->move(public_path('assets/applicants/' . date("Y") . '/' . $job->job_id), $nameimage);
                $nameimage = date("Y") . '/' . $job->job_id . '/' . $nameimage;
            }
            if($request->hasFile('signature')) {
                $signature = $request->file('signature');
                $extensionsignature = $signature->getClientOriginalExtension();
                $namesignature = time() . '-' . mt_rand() . "_signature." . $extensionsignature;
                $signature->move(public_path('assets/applicants/' . date("Y") . '/' . $job->job_id), $namesignature);
                $namesignature = date("Y") . '/' . $job->job_id . '/' . $namesignature;
            }

            DB::beginTransaction();

            try {
                $code=round(microtime(true) * 1000)+$applicationinfo->id;
                $applicant = Applicant::where('id', $applicationinfo->id)
                    ->update([
                        'name_bn' => $request->input('name_bn'),
                        'name_en' => $request->input('name_en'),
                        'nid' => $request->input('nid'),
                        'brn' => $request->input('brn'),
                        'bday' => $request->input('date_of_birth'),
                        'bplace' => $request->input('date_of_place'),
                        'father_name' => $request->input('father_name'),
                        'mother_name' => $request->input('mother_name'),
                        'present_addrress' => null,
                        'parmanent_address' => null,
                        'mobile' => $request->input('mobile_no'),
                        'nationality' => $request->input('nationality'),
                        'gender' => $request->input('gender'),
                        'religious' => $request->input('religion'),
                        'extra_qualification' => $request->input('extQualification'),
                        'experience' => $request->input('Experience'),
                        'division_appli' => $request->input('divisioncaplicant'),
                        'quota' => $request->input('quota'),
                        'pa_house' => $request->input('present_house_no'),
                        'pa_village' => $request->input('present_village'),
                        'pa_union' => $request->input('present_union'),
                        'pa_postoffice' => $request->input('present_postoffice'),
                        'pa_postcode' => $request->input('present_postcode'),
                        'pa_upozilla' => $request->input('present_upozilla'),
                        'pa_zilla' => $request->input('present_zilla'),
                        'pr_house' => $request->input('permanent_house_no'),
                        'pr_village' => $request->input('permanent_village'),
                        'pr_union' => $request->input('permanent_union'),
                        'pr_postoffice' => $request->input('permanent_postoffice'),
                        'pr_postcode' => $request->input('permanent_postcode'),
                        'pr_upozilla' => $request->input('permanent_upozilla'),
                        'pr_zilla' => $request->input('permanent_zilla'),
                        'occupation' => $request->input('occupation'),
                        'picture' => $request->hasFile('image') ? $nameimage : $applicationinfo->picture,
                        'signature' => $request->hasFile('signature') ? $namesignature : $applicationinfo->signature,
                        'job_circular' => '',
                        'experienceyear' => $request->input('experienceyear'),
                        'experiencemonth' => $request->input('experiencemonth'),
                        'age' => '',
                        'code' => $code,
                        'eligible' => 0,
                        'jobcurday' => $request->input('jobcurday'),
                    ]);

                @ApplicantEducation::where(['applicants_id'=> $applicationinfo->id,'job_id'=> $job->id])->delete();

                if($request->input('jscexamlevel')){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicationinfo->id,
                        'job_id'=> $job->id,
                        'edu_level'=> $request->input('jscexamlevel'),
                        'institute_name'=> $request->input('jscinstitute_name'),
                        'group_subject'=> null,
                        'result'=> $request->input('jscresult'),
                        'cgpa'=> $request->input('jscresult_score'),
                        'out_of'=> $request->input('jscresult'),
                        'board_university'=> $request->input('jscboard'),
                        'passing_year'=> $request->input('jscpassyear'),
                    ]);
                }

                if($request->input('sscexamlevel')){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicationinfo->id,
                        'job_id'=> $job->id,
                        'edu_level'=> $request->input('sscexamlevel'),
                        'institute_name'=> $request->input('sscinstitute_name'),
                        'group_subject'=> $request->input('sscSubject'),
                        'result'=> $request->input('sscresult'),
                        'cgpa'=> $request->input('sscresult_score'),
                        'out_of'=> $request->input('sscresult'),
                        'board_university'=> $request->input('sscboard'),
                        'passing_year'=> $request->input('sscpassyear'),
                    ]);

                }

                if($request->input('hscexamlevel')){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicationinfo->id,
                        'job_id'=> $job->id,
                        'edu_level'=> $request->input('hscexamlevel'),
                        'institute_name'=> $request->input('hscinstitute_name'),
                        'group_subject'=> $request->input('hscubject'),
                        'result'=> $request->input('hscresult'),
                        'cgpa'=> $request->input('hscresult_score'),
                        'out_of'=> $request->input('hscresult'),
                        'board_university'=> $request->input('hscboard'),
                        'passing_year'=> $request->input('hscpassyear'),
                    ]);

                }
                if($request->input('graduationexamlevel')){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicationinfo->id,
                        'job_id'=> $job->id,
                        'edu_level'=> $request->input('graduationexamlevel'),
                        'institute_name'=> $request->input('graduationinstitute_name'),
                        'group_subject'=> $request->input('graduationsubject'),
                        'result'=> $request->input('graduationresult'),
                        'cgpa'=> $request->input('graduationresult_score'),
                        'out_of'=> $request->input('graduationresult'),
                        'board_university'=> $request->input('graduationuniversity'),
                        'passing_year'=> $request->input('graduationpassyear'),
                    ]);

                }
                if($request->input('mastersexamlevel')){
                    ApplicantEducation::create([
                        'applicants_id'=> $applicationinfo->id,
                        'job_id'=> $job->id,
                        'edu_level'=> $request->input('mastersexamlevel'),
                        'institute_name'=> $request->input('mastersinstitute_name'),
                        'group_subject'=> $request->input('mastersSubject'),
                        'result'=> $request->input('mastersresult'),
                        'cgpa'=> $request->input('mastersresult_score'),
                        'out_of'=> $request->input('mastersresult'),
                        'board_university'=> $request->input('mastersuniversity'),
                        'passing_year'=> $request->input('masterspassyear'),
                    ]);

                }
                if($job->certificate=="YES"){
                   @ApplicantCertificate::where(['applicants_id'=> $applicationinfo->id,'job_id'=> $job->id])->delete();

                    ApplicantCertificate::create([
                        'applicants_id'=> $applicationinfo->id,
                        'job_id'=> $job->id,
                        'edu_level'=> $request->input('certificate'),
                        'institute_name'=> $request->input('certificateinstitute_name'),
                        'duration'=> $request->input('certificateduration'),
                    ]);

                }

              /*
                JobApply::create([
                    'applicants_id'=> $applicationinfo->id,
                    'job_id'=> $job->id,
                    'received'=> 2,
                    'token'=> $code,
                    'bd_tk'=> $job->apply_fee,
                    'apply_date'=> date('Y-m-d H:i:s'),
                ]);
*/
                DB::commit();
             //   dd($applicationinfo->uuid);
                return redirect()->route('applicantPreview', ['uuid' => $applicationinfo->uuid]);
             //   return redirect()->route('applicantPreview', ['uuid' => $applicationinfo->uuid]);
               // return redirect()->route('applicationPrint', ['uuid' => $applicationinfo->uuid]);
            }
            catch (\Exception $e) {
                DB::rollback();
                dd($e->getMessage());
                Log::info($e->getMessage());
                return redirect()->route('home')
                    ->with('error', 'something wrong!!!');;
            }


        }


    }

    public function applicantConfirm(Request $request, $uuid){

        try {
            DB::beginTransaction();
            $applicationinfo= Applicant::where('uuid', $uuid)->first();
            $job= Job::find($applicationinfo->job_id);
            $code=round(microtime(true) * 1000)+$applicationinfo->id;
            $applicationinfo->eligible=1;
            $applicationinfo->save();
            JobApply::create([
                'applicants_id'=> $applicationinfo->id,
                'job_id'=> $job->id,
                'received'=> 2,
                'token'=> $code,
                'bd_tk'=> $job->apply_fee,
                'apply_date'=> date('Y-m-d H:i:s'),
            ]);
            DB::commit();
            return redirect()->route('applicationPrint', ['uuid' => $applicationinfo->uuid]);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
           // return $e->getMessage();
            return redirect()->route('home')
                ->with('error', 'No data found!!!');;
        }
    }

    public function applicationPrint(Request $request, $uuid){

        $applicationinfo= Applicant::with(['educations','job', 'birthplace','zila','upozilla','permanentzila','permanentupozilla','apliyedJob'])->where('uuid', $uuid)->first();
      // dd($applicationinfo);
       if($applicationinfo->eligible==1){
        return view('jobs.applicantionPrint',[
            'applicationinfo'=>$applicationinfo,
          ]);
       }
       else{
        return redirect()->route('home')
        ->with('error', 'No data found!!!');;
       }
    }

    public function university(){

        foreach (\App\Helpers\StaticValue::UNIVERSITIES as $UNIVERSITY){
            Board::updateOrCreate(['name'=>$UNIVERSITY, 'type'=>2]);

        }
    }

    public function PrintCopy(Request $request){
        return view('jobs.printCopy',[
            'applicationinfo'=>[],
        ]);
    }
    public function writtenCopy(Request $request){
        return view('jobs.writtenCard',[
            'applicationinfo'=>[],
        ]);
    }
    public function vivaCopy(Request $request){
        return view('jobs.vivaCard',[
            'applicationinfo'=>[],
        ]);
    }
    public function practicalCopy(Request $request){
        return view('jobs.practicalCopy',[
            'applicationinfo'=>[],
        ]);
    }
    public function medicalCopy(Request $request){
        return view('jobs.medicalCopy',[
            'applicationinfo'=>[],
        ]);
    }
}
