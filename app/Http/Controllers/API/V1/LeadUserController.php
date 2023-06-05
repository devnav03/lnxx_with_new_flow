<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\UserDevice;
use ElfSundae\Laravel\Hashid\Facades\Hashid;
use App\Models\ForceUpdate;
use App\Models\PreRegister;
use App\Models\SelfEmpDetail;
use App\Models\OtherCmDetail;
use App\Models\UserEducation;
use App\Models\Refer;
use App\Models\CmSalariedDetail;
use App\Models\CustomerOnboarding;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Service;
use App\Models\ServiceApply;
use App\Models\ApplicationProductRequest;
use App\Models\Address;
use App\Models\Application;
use App\Models\Bank;
use App\Models\ContentManagement;
use App\Models\Company;
use App\Models\Country;
use App\Models\Lead;
use App\Models\LeadCase;
use App\Models\LeadMail;
use App\Models\ProductRequest;
use App\Models\CardType;
use App\Models\ApplicationData;
use App\Models\LeadSource;
use App\Models\LeadNote;
use App\Models\ApplicationPersonalLoanInformation;
use Auth;
use Ixudra\Curl\Facades\Curl;
use PDF;
use Carbon\Carbon;
use App\PasswordHash;
use Illuminate\Support\Facades\Mail;


class LeadUserController extends Controller {


    public function add_lead(Request $request){
        
      if($request->api_key){
        $user = User::where('api_key', $request->api_key)->select('id')->first();
        if($user) {

        $inputs = $request->all();
        $inputs['uploaded_by'] = $user->id;
        $inputs['alloted_to'] = $user->id;
        (new Lead)->store($inputs);
        return response()->json(['success' => true, 'status' => 200, 'message' => 'Lead successfully saved']); 

        } else {
          return response()->json(['success' => false, 'status' => 201, 'message' => 'Invalid login']); 
        }
      }
    }

    public function lead_source(){
      $data = leadSource::where('status', 1)->select('id', 'name')->get();
      return response()->json(['success' => true, 'status' => 200, 'data' => $data ]); 
    }
    
    public function lead_status(){
      $data =  \DB::table('status_master')->select('id', 'name')->get();
      return response()->json(['success' => true, 'status' => 200, 'data' => $data ]); 
    }
    
    public function lead_reasons(){
      $data =  \DB::table('lead_regions')->select('id', 'name')->get();
      return response()->json(['success' => true, 'status' => 200, 'data' => $data ]); 
    }

    public function add_attempt(Request $request){
      if($request->api_key){
        $user = User::where('api_key', $request->api_key)->select('id')->first();
        if($user) {
          $lead = Lead::where('id', $request->lead_id)->where('alloted_to', $user->id)->where('attempt', 0)->select('id')->first();
          if($lead){
            $time=Carbon::now()->toDateTimeString();
              Lead::where('id', $lead->id)
                ->update([
                'attempt' => 1,
                'seen_time' => $time,
              ]); 
            return response()->json(['success' => true, 'status' => 200, 'message' => 'Lead successfully attempt' ]); 
          } else {
            return response()->json(['success' => false, 'status' => 201, 'message' => 'Lead already attempt' ]); 
          }
        }  
      }
    }

    public function add_follow_up(Request $request){
      if($request->api_key){
        $user = User::where('api_key', $request->api_key)->select('id')->first();
        if($user) {
            $lead = new LeadCase;
            $lead->lead_id = $request->id;
            $lead->user_id = $user->id;
            $lead->reason_for_follow_up = $request->reason_for_follow_up;
            $lead->note = $request->note;
            $lead->date = date('Y-m-d', strtotime($request->date));
            $lead->time = $request->time;
            $lead->save();
            return response()->json(['success' => true, 'status' => 200, 'message' => 'Follow up successfully saved' ]); 
        }
      }
    }
    

    public function update_lead(Request $request){
      if($request->api_key){
        $user = User::where('api_key', $request->api_key)->select('id')->first();
        if($user) {

            $close_time = '';

              $lead = Lead::where('id', $request->id)->first();
              if($request->number){
                $number = $request->number;
              } else {
                $number = $lead->number;
              }
              if($request->email){
                $email = $request->email;
              } else {
                $email = $lead->email;
              }
              if($request->saturation){
                $saturation = $request->saturation;
              } else {
                $saturation = $lead->saturation;
              }
              if($request->name){
                $name = $request->name;
              } else {
                $name = $lead->name;
              }
              if($request->mname){
                $mname = $request->mname;
              } else {
                $mname = $lead->mname;
              }
              if($request->lname){
                $lname = $request->lname;
              } else {
                $lname = $lead->lname;
              }
              if($request->product){
                $product = $request->product;
              } else {
                $product = $lead->product;
              }
              if($request->lead_status){
                $lead_status = $request->lead_status;
                
                if($request->lead_status == 'CLOSE'){
                  $time = Carbon::now()->toDateTimeString();
                  $close_time = $time;
                }

              } else {
                $lead_status = $lead->lead_status;
              }

              Lead::where('id', $request->id)
                ->update([
                  'saturation' => $saturation,
                  'email'      => $email,
                  'number'     => $number,
                  'name'       => $name,
                  'mname'      => $mname,
                  'lname'      => $lname,
                  'product'    => $product,
                  'lead_status'=> $lead_status,
                  'close_time' => $close_time,
              ]);
              
              if($request->note){
                $lead = new LeadNote;
                $lead->lead_id = $request->id;
                $lead->user_id = $user->id;
                $lead->title   = $request->title;
                $lead->note    = $request->note;
                $lead->save();
              }

            return response()->json(['success' => true, 'status' => 200, 'message' => 'Lead successfully updated' ]);       
        }
      }
    }

    public function open_lead(Request $request){

      if($request->api_key){
        $user = User::where('api_key', $request->api_key)->select('id')->first();
        if($user) {
          $data = Lead::where('alloted_to', $user->id)->where('lead_status', '!=', 'CLOSE')->select('id', 'saturation', 'name', 'mname', 'lname', 'email', 'number', 'product', 'lead_status', 'attempt', 'fav', 'note', 'seen_time', 'created_at')->get();

            $data1 = [];
          
          if(count($data) != 0){
            foreach ($data as $dt) {
              $slide['id'] = $dt->id;
              $slide['saturation'] = $dt->saturation;
              $slide['name'] = $dt->name;
              $slide['mname'] = $dt->mname;
              $slide['lname'] = $dt->lname;
              $slide['email'] = $dt->email;
              $slide['number'] = $dt->number;
              $slide['product'] = $dt->product;
              $slide['lead_status'] = $dt->lead_status;
              $slide['attempt'] = $dt->attempt;
              $slide['fav'] = $dt->fav;

              $slide['note'] = $dt->note;

              $slide['seen_time'] = '';
              if($dt->seen_time){
              $created_at = \Carbon\Carbon::parse($dt->seen_time);
              $diff = $created_at->diff(\Carbon\Carbon::now());

              $diff_minutes = $diff->i;
              $diff_hours = $diff->h;
              $diff_days = $diff->d;
              $diff_weeks = floor($diff->days / 7);
              $diff_months = $diff->m;
              
              if($diff_months != 0){
                if($diff_months == 1){
                  $slide['seen_time'] = $diff_months.' month ago'; 
                } else {
                  $slide['seen_time'] = $diff_months.' months ago';
                }
              } else if ($diff_weeks != 0) {
                if($diff_weeks == 1){
                    $slide['seen_time'] = $diff_weeks.' week ago';
                } else {
                    $slide['seen_time'] = $diff_weeks.' weeks ago';
                }
              } else if ($diff_days != 0) {
                if($diff_days == 1){
                  $slide['seen_time'] = $diff_days.' day ago';
                } else {
                  $slide['seen_time'] = $diff_days.' days ago';
                }
              } else if ($diff_hours != 0) {
                $slide['seen_time'] = $diff_hours.' hours ago';

              } else {

                $slide['seen_time'] = $diff_minutes.' minutes ago';

              }
            }
              
              $data1[] = $slide;
            }
          }

          return response()->json(['success' => true, 'status' => 200, 'data' => $data1]); 

        } else {
          return response()->json(['success' => false, 'status' => 201, 'message' => 'Invalid login']); 
        }
      }
    }


     public function product_list(Request $request){
      try {

        $services = Service::where('status', 1)->select('id', 'name', 'coming_soon', 'image')->orderBy('sort_order', 'ASC')->get();

        $data = [];
        $url = route('get-started');
        foreach ($services as $service) {
          $slide['id'] = $service->id;
          $slide['name'] = $service->name;
          $slide['coming_soon'] = $service->coming_soon;
          $slide['image'] = $url.$service->image;
          $data[] = $slide;
        }
        return response()->json(['success' => true, 'status' => 200, 'data' => $data]);
          
      } catch(Exception $e){
          return apiResponse(false, 500, lang('messages.server_error'));
      }
    }

    public function product_list_selected(Request $request){
      try {
            if($request->api_key){
              $user = User::where('api_key', $request->api_key)->select('id')->first();
              if($user){
              $services = Service::where('status', 1)->select('id', 'name',  'coming_soon')->orderBy('sort_order', 'ASC')->get();
              $base = route('get-started');
              $data = [];
              foreach ($services as $service) {
                $check = ServiceApply::where('service_id', $service->id)->where('app_status', 0)->where('customer_id', $user->id)->count();
             
                $slide['id'] = $service->id;
                $slide['name'] = $service->name;
                $slide['coming_soon'] = $service->coming_soon;  
                if($check == 0){
                  $slide['is_selected'] = false;  
                } else {
                  $slide['is_selected'] = true;  
                }
                $data[] = $slide;
              } 
                return response()->json(['success' => true, 'status' => 200, 'data' => $data]);
              }
            }
      } catch(Exception $e){
          return apiResponse(false, 500, lang('messages.server_error'));
      }
    }

    public function lead_filter(Request $request){

      if($request->api_key){
        $user = User::where('api_key', $request->api_key)->select('id')->first();
        if($user) {

          $data = [];

          if($request->type == 'days'){
            $date = \Carbon\Carbon::today()->subDays($request->filter);
            $data = Lead::where('alloted_to', $user->id)->where('lead_status', '!=', 'CLOSE')->where('created_at','>=', $date)->select('id', 'saturation', 'name', 'mname', 'lname', 'email', 'number', 'product', 'lead_status', 'attempt', 'fav', 'seen_time')->get();
          }
         
          if($request->type == 'product'){
            $service = Service::where('id', $request->filter)->select('name')->first();
            $data = Lead::where('alloted_to', $user->id)->where('lead_status', '!=', 'CLOSE')->where('product', $service->name)->select('id', 'saturation', 'name', 'mname', 'lname', 'email', 'number', 'product', 'lead_status', 'attempt', 'fav', 'seen_time')->get();
          }

          if($request->type == 'order'){
            if($request->filter == 1){
              $data = Lead::where('alloted_to', $user->id)->where('lead_status', '!=', 'CLOSE')->select('id', 'saturation', 'name', 'mname', 'lname', 'email', 'number', 'product', 'lead_status', 'attempt', 'fav', 'seen_time')->orderBy('id', 'desc')->get();
            }
            if($request->filter == 2){
              $data = Lead::where('alloted_to', $user->id)->where('lead_status', '!=', 'CLOSE')->select('id', 'saturation', 'name', 'mname', 'lname', 'email', 'number', 'product', 'lead_status', 'attempt', 'fav', 'seen_time')->orderBy('id', 'asc')->get();
            }
          }
          
          if($request->type == 'attempted'){
            if($request->filter == 0){
              $data = Lead::where('alloted_to', $user->id)->where('lead_status', '!=', 'CLOSE')->where('attempt', 0)->select('id', 'saturation', 'name', 'mname', 'lname', 'email', 'number', 'product', 'lead_status', 'attempt', 'fav', 'seen_time')->get();
            } else {
              $data = Lead::where('alloted_to', $user->id)->where('lead_status', '!=', 'CLOSE')->where('attempt', 1)->select('id', 'saturation', 'name', 'mname', 'lname', 'email', 'number', 'product', 'lead_status', 'attempt', 'fav', 'seen_time')->get();
            }
          }

          $data1 = [];
          
          if(count($data) != 0){
            foreach ($data as $dt) {
              $slide['id'] = $dt->id;
              $slide['saturation'] = $dt->saturation;
              $slide['name'] = $dt->name;
              $slide['mname'] = $dt->mname;
              $slide['lname'] = $dt->lname;
              $slide['email'] = $dt->email;
              $slide['number'] = $dt->number;
              $slide['product'] = $dt->product;
              $slide['lead_status'] = $dt->lead_status;
              $slide['attempt'] = $dt->attempt;
              $slide['fav'] = $dt->fav;
              $slide['seen_time'] = '';
              
              if($dt->seen_time){
              $created_at = \Carbon\Carbon::parse($dt->seen_time);
              $diff = $created_at->diff(\Carbon\Carbon::now());

              $diff_minutes = $diff->i;
              $diff_hours = $diff->h;
              $diff_days = $diff->d;
              $diff_weeks = floor($diff->days / 7);
              $diff_months = $diff->m;
              
              if($diff_months != 0){
                if($diff_months == 1){
                  $slide['seen_time'] = $diff_months.' month ago';
                } else {
                  $slide['seen_time'] = $diff_months.' months ago';
                }
              } else if ($diff_weeks != 0) {
                if($diff_weeks == 1){
                  $slide['seen_time'] = $diff_weeks.' week ago';
                } else {
                  $slide['seen_time'] = $diff_weeks.' weeks ago';
                }
              } else if ($diff_days != 0) {
                $slide['seen_time'] = $diff_days.' days ago';
              } else if ($diff_hours != 0) {
                $slide['seen_time'] = $diff_hours.' hours ago';

              } else {
                $slide['seen_time'] = $diff_minutes.' minutes ago';
              }
              }
              $data1[] = $slide;
            }
          }

          return response()->json(['success' => true, 'status' => 200, 'data' => $data1]); 

        } else {
          return response()->json(['success' => false, 'status' => 201, 'message' => 'Invalid login']); 
        }
      }




    }

    public function close_lead(Request $request){
      if($request->api_key){
        $user = User::where('api_key', $request->api_key)->select('id')->first();
        if($user) {
          $data = Lead::where('alloted_to', $user->id)->where('lead_status', 'CLOSE')->select('id', 'saturation', 'name', 'mname', 'lname', 'email', 'number', 'product', 'lead_status', 'attempt', 'fav')->get();
          return response()->json(['success' => true, 'status' => 200, 'data' => $data]); 

        } else {
          return response()->json(['success' => false, 'status' => 201, 'message' => 'Invalid login']); 
        }
      }
    }

    
    public function new_leads(Request $request){
      if($request->api_key){
        $user = User::where('api_key', $request->api_key)->select('id')->first();
        if($user) {
          $data = Lead::where('alloted_to', $user->id)->where('attempt', 0)->where('lead_status', '!=', 'CLOSE')->select('id', 'saturation', 'name', 'mname', 'lname', 'email', 'number', 'product', 'lead_status', 'attempt', 'fav', 'seen_time')->get();

           $data1 = [];
          
          if(count($data) != 0){
            foreach ($data as $dt) {
              $slide['id'] = $dt->id;
              $slide['saturation'] = $dt->saturation;
              $slide['name'] = $dt->name;
              $slide['mname'] = $dt->mname;
              $slide['lname'] = $dt->lname;
              $slide['email'] = $dt->email;
              $slide['number'] = $dt->number;
              $slide['product'] = $dt->product;
              $slide['lead_status'] = $dt->lead_status;
              $slide['attempt'] = $dt->attempt;
              $slide['fav'] = $dt->fav;
              $slide['seen_time'] = '';
              
              if($dt->seen_time){
              $created_at = \Carbon\Carbon::parse($dt->seen_time);
              $diff = $created_at->diff(\Carbon\Carbon::now());

              $diff_minutes = $diff->i;
              $diff_hours = $diff->h;
              $diff_days = $diff->d;
              $diff_weeks = floor($diff->days / 7);
              $diff_months = $diff->m;
              
              if($diff_months != 0){
                if($diff_months == 1){
                  $slide['seen_time'] = $diff_months.' month ago';
                } else {
                  $slide['seen_time'] = $diff_months.' months ago';
                }
              } else if ($diff_weeks != 0) {
                if($diff_weeks == 1){
                  $slide['seen_time'] = $diff_weeks.' week ago';
                } else {
                  $slide['seen_time'] = $diff_weeks.' weeks ago';
                }
              } else if ($diff_days != 0) {
                if($diff_days == 1){
                  $slide['seen_time'] = $diff_days.' day ago';
                } else {
                  $slide['seen_time'] = $diff_days.' days ago';
                }
              } else if ($diff_hours != 0) {
                $slide['seen_time'] = $diff_hours.' hours ago';

              } else {
                $slide['seen_time'] = $diff_minutes.' minutes ago';
              }
              }
              $data1[] = $slide;
            }
          }
          return response()->json(['success' => true, 'status' => 200, 'data' => $data1]); 

        } else {
          return response()->json(['success' => false, 'status' => 201, 'message' => 'Invalid login']); 
        }
      }
    }



    public function fav_lead(Request $request){
      if($request->api_key){
        $user = User::where('api_key', $request->api_key)->select('id')->first();
        if($user) {
          $data = Lead::where('alloted_to', $user->id)->where('lead_status', '!=', 'CLOSE')->where('fav', 1)->select('id', 'saturation', 'name', 'mname', 'lname', 'email', 'number', 'product', 'lead_status', 'attempt', 'fav', 'seen_time')->get();

           $data1 = [];
          
          if(count($data) != 0){
            foreach ($data as $dt) {
              $slide['id'] = $dt->id;
              $slide['saturation'] = $dt->saturation;
              $slide['name'] = $dt->name;
              $slide['mname'] = $dt->mname;
              $slide['lname'] = $dt->lname;
              $slide['email'] = $dt->email;
              $slide['number'] = $dt->number;
              $slide['product'] = $dt->product;
              $slide['lead_status'] = $dt->lead_status;
              $slide['attempt'] = $dt->attempt;
              $slide['fav'] = $dt->fav;
              $slide['seen_time'] = '';
              
              if($dt->seen_time){
              $created_at = \Carbon\Carbon::parse($dt->seen_time);
              $diff = $created_at->diff(\Carbon\Carbon::now());

              $diff_minutes = $diff->i;
              $diff_hours = $diff->h;
              $diff_days = $diff->d;
              $diff_weeks = floor($diff->days / 7);
              $diff_months = $diff->m;
              
              if($diff_months != 0){
                if($diff_months == 1){
                  $slide['seen_time'] = $diff_months.' month ago';
                } else {
                  $slide['seen_time'] = $diff_months.' months ago';
                }
              } else if ($diff_weeks != 0) {
                if($diff_weeks == 1){
                  $slide['seen_time'] = $diff_weeks.' week ago';
                } else {
                  $slide['seen_time'] = $diff_weeks.' weeks ago';
                }
              } else if ($diff_days != 0) {
                if($diff_days == 1){
                  $slide['seen_time'] = $diff_days.' day ago';
                } else {
                  $slide['seen_time'] = $diff_days.' days ago';
                }
              } else if ($diff_hours != 0) {
                $slide['seen_time'] = $diff_hours.' hours ago';

              } else {
                $slide['seen_time'] = $diff_minutes.' minutes ago';
              }
              }
              $data1[] = $slide;
            }
          }


          return response()->json(['success' => true, 'status' => 200, 'data' => $data1]); 

        } else {
          return response()->json(['success' => false, 'status' => 201, 'message' => 'Invalid login']); 
        }
      }
    }

    public function select_fav(Request $request){
      if($request->api_key){
        $user = User::where('api_key', $request->api_key)->select('id')->first();
        if($user) {
       
              $data = Lead::where('alloted_to', $user->id)->where('id', $request->lead_id)->select('id', 'fav')->first();
              if($data->fav == 1){
                $message = "Lead successfully remove from favourite";
                Lead::where('id', $data->id)
                ->update([
                'fav' => 0,
                ]);

              } else {
                $message = "Lead successfully added in favourite";
                Lead::where('id', $data->id)
                ->update([
                'fav' => 1,
                 ]);
              }

          return response()->json(['success' => true, 'status' => 200, 'message' => $message]); 

        } else {
          return response()->json(['success' => false, 'status' => 201, 'message' => 'Invalid login']); 
        }
      }
    }

    public function lead_counts(Request $request){
      if($request->api_key){
        $user = User::where('api_key', $request->api_key)->select('id')->first();
        if($user) {
            $open_lead = Lead::where('alloted_to', $user->id)->where('lead_status', '!=', 'CLOSE')->count();
            $close_lead = Lead::where('alloted_to', $user->id)->where('lead_status', 'CLOSE')->count();

            $date = date('Y-m-d');
            $today_follow_count = \DB::table('lead_cases')
                ->join('leads', 'leads.id', '=', 'lead_cases.lead_id')
                ->select('lead_cases.reason_for_follow_up', 'lead_cases.date', 'lead_cases.time', 'leads.saturation', 'leads.name', 'leads.mname', 'leads.lname', 'leads.email', 'leads.number', 'leads.product', 'lead_cases.note')
                ->where('lead_cases.user_id', $user->id)->where('lead_cases.date', $date)->where('leads.lead_status', '!=', 'CLOSE')->count();
            $new_lead = Lead::where('alloted_to', $user->id)->where('attempt', 0)->where('lead_status', '!=', 'CLOSE')->count();

          return response()->json(['success' => true, 'status' => 200, 'open_lead' => $open_lead, 'close_lead' => $close_lead, 'today_follow_count' => $today_follow_count, 'new_lead' => $new_lead ]); 

        }
      }
    }

    public function today_lead(Request $request){

      if($request->api_key){
        $user = User::where('api_key', $request->api_key)->select('id')->first();
        if($user) {
          $data = Lead::where('alloted_to', $user->id)->where('lead_status', '!=', 'CLOSE')->select('id', 'saturation', 'name', 'mname', 'lname', 'email', 'number', 'product', 'lead_status', 'attempt', 'fav', 'note', 'seen_time', 'created_at')->get();
          $date = date('Y-m-d');
          $data = \DB::table('lead_cases')
                ->join('leads', 'leads.id', '=', 'lead_cases.lead_id')
                ->select('leads.*')
                ->where('lead_cases.user_id', $user->id)->where('leads.lead_status', '!=', 'CLOSE')->where('lead_cases.date', $date)->get();

          $data1 = [];
          
          if(count($data) != 0){
            foreach ($data as $dt) {
              $slide['id'] = $dt->id;
              $slide['saturation'] = $dt->saturation;
              $slide['name'] = $dt->name;
              $slide['mname'] = $dt->mname;
              $slide['lname'] = $dt->lname;
              $slide['email'] = $dt->email;
              $slide['number'] = $dt->number;
              $slide['product'] = $dt->product;
              $slide['lead_status'] = $dt->lead_status;
              $slide['attempt'] = $dt->attempt;
              $slide['fav'] = $dt->fav;

              $slide['note'] = $dt->note;

              $slide['seen_time'] = '';
              if($dt->seen_time){
              $created_at = \Carbon\Carbon::parse($dt->seen_time);
              $diff = $created_at->diff(\Carbon\Carbon::now());

              $diff_minutes = $diff->i;
              $diff_hours = $diff->h;
              $diff_days = $diff->d;
              $diff_weeks = floor($diff->days / 7);
              $diff_months = $diff->m;
              
              if($diff_months != 0){
                if($diff_months == 1){
                  $slide['seen_time'] = $diff_months.' month ago';
                } else {
                  $slide['seen_time'] = $diff_months.' months ago';
                }
              } else if ($diff_weeks != 0) {
                if($diff_weeks == 1){
                  $slide['seen_time'] = $diff_weeks.' week ago';
                } else {
                  $slide['seen_time'] = $diff_weeks.' weeks ago';
                }
              } else if ($diff_days != 0) {
                if($diff_days == 1){
                   $slide['seen_time'] = $diff_days.' day ago';
                } else {
                  $slide['seen_time'] = $diff_days.' days ago';
                }
              } else if ($diff_hours != 0) {
                $slide['seen_time'] = $diff_hours.' hours ago';
              } else {
                $slide['seen_time'] = $diff_minutes.' minutes ago';
              }
            }
              
              $data1[] = $slide;
            }
          }

          return response()->json(['success' => true, 'status' => 200, 'data' => $data1]); 

        } else {
          return response()->json(['success' => false, 'status' => 201, 'message' => 'Invalid login']); 
        }
      }
    }

    public function lead_details(Request $request){
      if($request->api_key){
        $user = User::where('api_key', $request->api_key)->select('id')->first();
        if($user) {

          $lead = Lead::where('alloted_to', $user->id)->where('id', $request->lead_id)->first();

          $data['id'] = $lead->id;
          $data['saturation'] = $lead->saturation;
          $data['name'] = $lead->name;
          $data['mname'] = $lead->mname;
          $data['lname'] = $lead->lname;
          $data['email'] = $lead->email;
          $data['number'] = $lead->number;
          $data['product'] = $lead->product;
          $data['dob'] = $lead->dob;
          $data['source'] = $lead->source;
          $data['note'] = $lead->note;
          $data['lead_status'] = $lead->lead_status;
          $data['fav'] = $lead->fav;
          $data['created_at'] = date('d M, Y', strtotime($lead->created_at));

          $follow_up1 = [];
          $follow_up = LeadCase::where('user_id', $user->id)->where('lead_id', $request->lead_id)->select('reason_for_follow_up', 'note', 'date', 'time', 'created_at')->get();

          if(count($follow_up) != 0){
            foreach ($follow_up  as $follow_u) {
              $slide['reason_for_follow_up'] = $follow_u->reason_for_follow_up;
              $slide['note'] = $follow_u->note;
              $slide['time'] = $follow_u->time;
              $slide['date'] = date('d-m-Y', strtotime($follow_u->date));
              $slide['created_at'] = date('d-m-Y', strtotime($follow_u->created_at));
              $follow_up1[] = $slide;
            }
          }
          
          $lead_mail1 = [];
          $lead_mails = LeadMail::where('to_mail_id', $request->lead_id)->where('send_by', $user->id)->select('mail_to', 'subject', 'mail', 'created_at')->get();

          if(count($lead_mails) != 0){
            foreach ($lead_mails  as $lead_mail) {
              $slide12['mail_to'] = $lead_mail->mail_to;
              $slide12['subject'] = $lead_mail->subject;
              $slide12['mail'] = $lead_mail->mail;
              $slide12['created_at'] = date('d-m-Y', strtotime($lead_mail->created_at));
              $lead_mail1[] = $slide12;
            }
          }

          $notes1 = [];
          $notes = LeadNote::where('lead_id', $request->lead_id)->where('user_id', $user->id)->select('note', 'title', 'created_at')->get();

          if(count($notes) != 0){
            foreach ($notes  as $note) {
              $slide['note'] = $note->note;
              $slide['title'] = $note->title;
              $slide['created_at'] = date('d-m-Y', strtotime($note->created_at));
              $notes1[] = $slide;
            }
          }

          return response()->json(['success' => true, 'status' => 200, 'data' => $data, 'follow_up' => $follow_up1, 'lead_mail' => $lead_mail1, 'notes' => $notes1 ]); 

        } else {
           return response()->json(['success' => false, 'status' => 201, 'message' => 'No login' ]);
        }
      }
    }
    

    public function send_email(Request $request){
      if($request->api_key){
        $user = User::where('api_key', $request->api_key)->select('id')->first();
        if($user) {
          $email = $request->email;
          $subject = $request->subject;
          $data['text'] = $request->message;

          LeadMail::create([
            'to_mail_id' => $request->lead_id,
            'mail_to'    => $request->email,
            'subject'    => $subject,
            'mail'       => $request->message,
            'send_by'    => $user->id,
          ]);

          \Mail::send('email.send_email', $data, function($message) use ($email, $subject){
            $message->from('lnxxapp@gmail.com');
            $message->to($email); 
            $message->subject($subject);
          });
 
          return response()->json(['success' => true, 'status' => 200, 'message' => 'Email successfully sent' ]);
        }
      }
    }



    public function agent_login(Request $request){
        try{
        $credentials = [
            'email' => $request->get('username'),
            'password' => $request->get('password'),
            'status' => 1
        ];

        $credentials1 = [
            'mobile' => $request->get('username'),
            'password' => $request->get('password'),
            'status' => 1
        ];
         
          $url = route('get-started');
          $inputs = $request->all();

            if (Auth::attempt($credentials))  {
                $user_data = User::where('email', $request->username)->first();
                $api_key = $this->generateApiKey();
                if($user_data->api_key){
                    $api_key = $user_data->api_key; 
                } else {
                User::where('email', $request->username)
                ->update([
                'api_key' =>  $api_key,
                 ]);
                }

                $data['name'] = $user_data->name;
                $data['user_type'] = $user_data->user_type;
                $data['email'] = $user_data->email;
                if($user_data->profile_image){
                  $data['image'] = $url.$user_data->profile_image;
                } else {
                  $data['image'] =$user_data->profile_image;
                }
                $data['mobile'] = $user_data->mobile;  
                $data['api_key'] = $api_key;  
                return apiResponseApp(true, 200, null, null, $data);
              
            } else if(Auth::attempt($credentials1)) {
                $user_data = User::where('mobile', $request->username)->first();
                $api_key = $this->generateApiKey();
                if($user_data->api_key){
                    $api_key = $user_data->api_key;
                } else {
                User::where('email', $request->username)
                ->update([
                'api_key' =>  $api_key,
                 ]);
                }

                $data['name'] = $user_data->name;
                $data['email'] = $user_data->email;
                if($user_data->profile_image){
                  $data['image'] = $url.$user_data->profile_image;
                } else {
                  $data['image'] =$user_data->profile_image;
                }
                $data['mobile'] = $user_data->mobile;
                $data['api_key'] = $api_key; 

                return apiResponseApp(true, 200, null, null, $data);

        } else {
          $message = 'Invalid login credentials';
          return apiResponseApp(false, 201, $message, null, null);
        }
    } catch(Exception $e){
            return apiResponse(false, 500, lang('messages.server_error'));
        }
    }
        

    public function login_user(Request $request){
      try{
        $credentials = [
            'email' => $request->get('username'),
            'password' => $request->get('password'),
            'status' => 1
        ];
        $credentials1 = [
            'mobile' => $request->get('username'),
            'password' => $request->get('password'),
            'status' => 1
        ];
         
        $url = route('get-started');
        $inputs = $request->all();

        $user = User::where('email', $request->username)->where('status', 1)->select('password')->first(); 
        if($user){
          $wp_hasher = new PasswordHash(8, TRUE);
          $plain_password = $request->password; 
          $password_hashed  =  $user->password;

          if($wp_hasher->CheckPassword($plain_password, $password_hashed)) {
            $user = User::where('email', $request->username)->where('status', 1)->first(); 
          } else {
            $user = ''; 
          }
        }
            if (!empty($user))  {
                $user_data = User::where('email', $request->username)->first();
                $api_key = $this->generateApiKey();
                if($user_data->api_key){
                $api_key = $user_data->api_key;
                } else {
                User::where('email', $request->username)
                ->update([
                'api_key' =>  $api_key,
                 ]);
                }
                
                $data['name'] = $user_data->name;
                $data['email'] = $user_data->email;
                if($user_data->profile_image){
                  $data['image'] = $url.$user_data->profile_image;
                } else {
                  $data['image'] =$user_data->profile_image;
                }
                $data['mobile'] = $user_data->mobile;  
                $data['gender'] = $user_data->gender;  
                $data['api_key'] = $api_key;  

                return apiResponseApp(true, 200, null, null, $data);

          } else if (Auth::attempt($credentials))  {

                $user_data = User::where('email', $request->username)->first();

                $api_key = $this->generateApiKey();
                if($user_data->api_key){
                  $api_key = $user_data->api_key;
                } else {
                User::where('email', $request->username)
                ->update([
                'api_key' =>  $api_key,
                 ]);
                }

              if($user_data->user_type == 4){
                return apiResponse(false, 200, 'You are not allow on APP');
               } else {
                $data['name'] = $user_data->name;
                $data['email'] = $user_data->email;
                if($user_data->profile_image){
                  $data['image'] = $url.$user_data->profile_image;
                } else {
                  $data['image'] = $user_data->profile_image;
                }
                $data['mobile'] = $user_data->mobile;  
                $data['gender'] = $user_data->gender;  
                $data['api_key'] = $api_key;  
                return apiResponseApp(true, 200, null, null, $data);
              }
          } else if(Auth::attempt($credentials1)) {
                $user_data = User::where('mobile', $request->username)->first();
                $api_key = $this->generateApiKey();
                if($user_data->api_key){
                $api_key = $user_data->api_key;
                } else {
                User::where('email', $request->username)
                ->update([
                'api_key' =>  $api_key,
                 ]);
                }
                if($user_data->user_type == 4){
                  return apiResponse(false, 200, 'You are not allow on APP');
                } else {
                $data['name'] = $user_data->name;
                $data['email'] = $user_data->email;
                if($user_data->profile_image){
                  $data['image'] = $url.$user_data->profile_image;
                } else {
                  $data['image'] =$user_data->profile_image;
                }
                $data['mobile'] = $user_data->mobile; 
                $data['gender'] = $user_data->gender;  
                $data['api_key'] = $api_key; 
                return apiResponseApp(true, 200, null, null, $data);
                }
        } else {
         //  dd($request);
          return apiResponse(false, 200, 'Invalid login credentials');
        }
    } catch(Exception $e){
            return apiResponse(false, 500, lang('messages.server_error'));
        }
    }


     /*create app key*/
    private function generateApiKey() {
        return md5(uniqid(rand(), true));
    }


    public function logout(Request $request){
       try{
        if($request->api_key){
           $user = User::where('api_key', $request->api_key)->select('id')->first();
          if($user) {
           User::where('id', $user->id)
            ->update([
              'api_key'  => null
            ]);
        
          $message = "Logout successfully";
          return apiResponseAppmsg(true, 200, $message, null, null);
          }
        }

       } catch(Exception $e){
           return apiResponse(false, 500, lang('messages.server_error'));
        }
    }

}



