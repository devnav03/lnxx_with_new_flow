<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\State;
use App\Models\City;
use App\Models\Country;
use App\Models\CustomerOnboarding;
use App\Models\OtherCmDetail;
use App\Models\CmSalariedDetail;
use App\Models\SelfEmpDetail;
use App\Models\Address;
use App\Models\ProductRequest;
use App\Models\UserEducation;
use App\Models\Service;
use App\Models\Company;
use App\Models\ServiceApply;
use App\Models\Application;
use App\Models\ApplicationProductRequest;
use App\Models\Bank;
use App\Models\ApplicationDependent;
use App\Models\ApplicationPersonalLoanPreferenceBank;
use App\Models\ApplicationCreditCardPreferenceBank;
use App\Models\ApplicationData;
use App\Models\ApplicationPersonalLoanInformation;
use App\Models\ApplicationStatus;
use App\Models\AppStatus;
use App\Models\EmailNotifications;
use League\Flysystem\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PDF;

class ApplicationController extends Controller {
   
    public function index() {
        $services = Service::where('status', 1)->select('name', 'id')->get();
        $applications_status = ApplicationStatus::where('status', 1)->select('id', 'name')->get();
        return view('admin.applications.index', compact('services', 'applications_status'));
    }

    public function create() {
        return view('admin.applications.create');
    }

    
    public function update_applications_status(Request $request){
        try{
            $inputs = $request->all(); 
            $validator = (new AppStatus)->validate($inputs);
            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator);
            } 

            AppStatus::create([
                'app_id'    =>  $request->app_id,
                'status_id' =>  $request->status_id,
                'comment'   =>  $request->comment,
                'updated_by'=>  authUserId(),
            ]); 

            Application::where('id', $request->app_id)->update(['status'  =>  $request->status_id,]);

            return back()->with('app_status_update', 'app_status_update');

        } catch (Exception $exception) {
            return back();
        }
    }

    public function export_app_excel(Request $request){

       // $inputs = $request->all(); 
        $start = 0;
        $perPage = 200000;

        $inputs['form-search'] = 1;
        if($request->ref_id != null){
            $inputs['ref_id'] = $request->ref_id;
        }
        if($request->name != null){
            $inputs['name'] = $request->name;
        }
        if($request->email != null){
            $inputs['email'] = $request->email;
        }
        if($request->mobile != null){
            $inputs['mobile'] = $request->mobile;
        }
        if($request->from != null){
            $inputs['from'] = $request->from;
        }
        if($request->to != null){
            $inputs['to'] = $request->to;
        }
        if($request->service_id != null){
            $inputs['service_id'] = $request->service_id;
        }
        if($request->status != null){
            $inputs['status'] = $request->status;
        }
        if($request->reference_number != null){
            $inputs['reference_number'] = $request->reference_number;
        }
        if($request->cm_type != null){
            $inputs['cm_type'] = $request->cm_type;
        }
        if($request->user_id != null){
            $inputs['user_id'] = $request->user_id;
        }

        

        $data = (new Application)->getApplication($inputs, $start, $perPage);


        $fileName = 'Applications.csv';
        $headers = array(
              "Content-type"        => "text/csv",
              "Content-Disposition" => "attachment; filename=$fileName",
              "Pragma"              => "no-cache",
              "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
              "Expires"             => "0"
          );
          
          $columns = array('App No', 'Name', 'Mobile', 'Email', 'Product', 'Status', 'Date', 'Employment Type', 'Gender', 'Profile Image', 'Date of Birth', 'Emirates ID Number', 'Passport Number', 'Passport Expiry Date', 'Nationality', 'Marital Status');

            $callback = function() use($columns, $data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
                  $row=[];

            //dd($products);
            $url = route('get-started');
            $p_count = [];
            
            foreach ($data as $key => $value) {
                
                if (in_array($value->id, $p_count))  {  
                } else {
                $p_count[] = $value->id;

                if($value->cm_type == 1){
                    $cm_type = 'Salaried';
                } else if($value->cm_type == 2){
                    $cm_type = 'Self Employed';
                } else {
                    $cm_type = 'Pension';
                }

                $country = Country::where('id', $value->nationality)->select('country_name')->first();

                $row['ref_id'] = $value->ref_id;
                $row['name'] = $value->salutation.' '.$value->name.' '.$value->middle_name.' '.$value->last_name;
                $row['mobile'] = $value->mobile;
                $row['email'] = $value->email;
                $row['product'] = $value->service;
                $row['status'] =  $value->status;
                $row['date'] =  date('d M, Y', strtotime($value->created_at));
                $row['cm_type'] =  $cm_type;
                $row['gender'] =  $value->gender;
                $row['profile_image'] =  $url.$value->profile_image;
                $row['date_of_birth'] = $value->date_of_birth;
                $row['emirates_id_number'] = $value->eid_number;
                $row['passport_number'] = $value->passport_number;
                $row['passport_expiry_date'] = $value->passport_expiry_date;
                $row['nationality'] = $country->country_name;
                $row['marital_status'] = $value->marital_status;


                fputcsv($file, array($row['ref_id'],$row['name'], $row['mobile'],
                   $row['email'], $row['product'], $row['status'],
                   $row['date'], $row['cm_type'], $row['gender'], $row['profile_image'],
                   $row['date_of_birth'], $row['emirates_id_number'], $row['passport_number'], $row['passport_expiry_date'], $row['nationality'], $row['marital_status']));
               }    
             }
             fclose($file);
          };
        
        
        if(isset($request->url)){
            $url = route('get-started');
            $url = $url.'/admin/export_app_excel?name='.$request->name.'&ref_id='.$request->ref_id.'&email='.$request->email.'&mobile='.$request->mobile.'&from='.$request->from.'&to='.$request->to.'&service_id='.$request->service_id.'&status='.$request->status.'&reference_number='.$request->reference_number.'&cm_type='.$request->cm_type.'&user_id='.$request->user_id.'';

            $datas= ['status'=>200,'url'=>$url];
            return response()->json($datas);

        } else {

            return response()->stream($callback, 200, $headers);
        }
        
    }

    public function customer_applications(Request $request){

        $applications = Application::where('user_id', $request->id)->select('id', 'ref_id', 'status', 'created_at', 'service_id', 'user_id')->get();

        $user = User::where('id', $request->id)->select('name', 'middle_name', 'last_name')->first();

        $user_name = $user->name.' '.$user->middle_name.' '.$user->last_name;

        $applications_html = [];
        $applications_html[] .='<tr>
                <th style="border: 1px solid #f3f3f3;padding:9px;text-align: center;">#</th>
                <th style="border: 1px solid #f3f3f3;padding:9px;text-align: center;">Applications No.</th>   
                <th style="border: 1px solid #f3f3f3;padding:9px;">Product Type</th> 
                <th style="border: 1px solid #f3f3f3;padding:9px;text-align: center;">Current Status</th>
                <th style="border: 1px solid #f3f3f3;padding:9px;text-align: center;">Date</th>
                <th style="border: 1px solid #f3f3f3;padding:9px;text-align: center;">View</th>
                </tr>';
        $ik = 0;
        foreach ($applications as $application) {
            $ik++;
            $service = Service::where('id', $application->service_id)->select('name')->first();
            $status = ApplicationStatus::where('id', $application->status)->select('name')->first();
            $applications_html[] .='<tr> 
                <td style="border: 1px solid #f3f3f3;padding:9px;text-align: center;">'.$ik.'</td>
                <td style="border: 1px solid #f3f3f3;padding:9px;text-align: center;">'.$application->ref_id.'</td>
                <td style="border: 1px solid #f3f3f3;padding:9px;">'.$service->name.'</td>
                <td style="border: 1px solid #f3f3f3;padding:9px;text-align: center;">'.$status->name.'</td>
                <td style="border: 1px solid #f3f3f3;padding:9px;text-align: center;">'.date('d M, Y', strtotime($application->created_at)).'</td>
                <td style="border: 1px solid #f3f3f3;padding:9px;text-align: center;"><a target="_blank" style="background: #5EB495; color: #fff; padding: 7px 10px;font-size: 12px;" href="'.route('applications.edit', $application->id).'"><i class="fa fa-eye"></i></a></td>
            </tr>';
        }

        // $applications_html[] .='</table>';

        $datas= ['status'=>200,'responce'=>$applications_html, 'user_name' => $user_name];
            //dd($datas);
        return response()->json($datas);
    }

    public function email_notification(Request $request){
        try {

            $inputs = $request->all(); 
            $validator = (new EmailNotifications)->validate($inputs);
            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator);
            } 
            if(isset($request->attachment)){
                $attachment = 1;
            } else {
                $attachment = 0;
            }

            EmailNotifications::create([
                'app_id'    =>  $request->app_id,
                'subject' =>  $request->subject,
                'email'   =>  $request->email,
                'message' =>  $request->message,
                'attachment'   =>  $attachment,
                'created_by'=>  authUserId(),
            ]); 

            $data['text']  = $inputs['message'];
            $email = $inputs['email']; 
            $subject = $inputs['subject'];


        if($attachment == 1){

            $home = route('get-started');
            $id = $request->app_id;
            $result = Application::find($id);
            if (!$result) {
                abort(404);
            }

            $PersonalLoanlimit = "";
            $PersonalLoanPreference = [];
            $CardTypePreference = [];
            $Personalloanform = [];

            $orderdetails['profile_image'] = $home.$result->profile_image;
       
            $country = Country::all();
            $countries = Country::all();
            $Application_Request = ApplicationProductRequest::where('application_id', $id)->first();

            $company = Company::where('status', 1)->select('id', 'name')->get();
            $banks = Bank::where('status', 1)->select('id', 'name')->get();

            $bank = Bank::where('id', $result->preference_bank_id)->select('id', 'name')->first();
            $service = Service::where('id', $result->service_id)->select('id', 'name')->first();

            $address_details = Address::where('customer_id', $id)->first();
            $UserEducation = UserEducation::where('user_id', $id)->first();
            $services = \DB::table('service_applies')
                        ->join('services', 'services.id', '=', 'service_applies.service_id')
                        ->select('service_applies.status', 'services.name', 'services.image')
                        ->where('service_applies.customer_id', $id)->get();
            $sel_services = ServiceApply::where('customer_id', $id)->pluck('service_id')->toArray();
            $dependents = ApplicationDependent::where('app_id', $id)->select('name', 'relation')->get();

            if($result->service_id == 1){
                $PersonalLoanlimit =  ApplicationPersonalLoanPreferenceBank::where('app_id', $result->id)->select('loan_limit', 'loan_emi')->first();
                $PersonalLoanPreference = \DB::table('application_personal_loan_preference_bank')
                        ->join('banks', 'banks.id', '=', 'application_personal_loan_preference_bank.bank_id')
                        ->select('banks.name', 'banks.id')
                        ->where('application_personal_loan_preference_bank.app_id', $id)->get();
                $Personalloanform = ApplicationPersonalLoanInformation::where('app_id', $id)->first();
            }
            if($result->service_id == 3){
                $PersonalLoanlimit =  ApplicationCreditCardPreferenceBank::where('app_id', $result->id)->select('loan_limit')->first();

                $PersonalLoanPreference = \DB::table('application_credit_card_preference_bank')
                    ->join('banks', 'banks.id', '=', 'application_credit_card_preference_bank.bank_id')
                    ->select('banks.name', 'banks.id')
                    ->where('application_credit_card_preference_bank.app_id', $id)->get();


                $CardTypePreference = \DB::table('application_card_type_preference')
                ->join('card_type', 'card_type.id', '=', 'application_card_type_preference.type_id')
                ->select('card_type.name', 'card_type.id')
                ->where('application_card_type_preference.app_id', $id)->get();
            }

            $app_data = ApplicationData::where('app_id', $id)->first();

            //$orderdetails['result'] = $result;
            $orderdetails['country'] = $country;
            $orderdetails['UserEducation'] = $UserEducation;
            $orderdetails['address_details'] = $address_details; 
            $orderdetails['countries'] = $countries;
            $orderdetails['services'] = $services;
            $orderdetails['sel_services'] = $sel_services;
            $orderdetails['company'] = $company;
            $orderdetails['banks'] = $banks;
            $orderdetails['Application_Request'] = $Application_Request;
            $orderdetails['bank'] = $bank;
            $orderdetails['service'] = $service;
            $orderdetails['dependents'] = $dependents;
            $orderdetails['PersonalLoanlimit'] = $PersonalLoanlimit;
            $orderdetails['PersonalLoanPreference'] = $PersonalLoanPreference;
            $orderdetails['CardTypePreference'] = $CardTypePreference;
           // $app_data['app_data'] = $app_data;
           // $orderdetails['Personalloanform'] = $Personalloanform;


            $pdf1 = \PDF::loadView('pdf/application', ['orderdetails' => $orderdetails, 'result' => $result, 'app_data' => $app_data, 'Personalloanform' => $Personalloanform])->setPaper('a4', 'portrait');

            // Mail::send('email.quote',['email' => $email, 'orderdetails' => $orderdetails ], function($message) use ($email, $pdf1){


            \Mail::send('email.email_notifications', $data, function($message) use ($email, $subject, $pdf1){
                $message->from('lnxxapp@gmail.com');
                $message->to($email);
                $message->subject($subject);
                $message->attachData($pdf1->output(),'application.pdf');
            }); 

        } else {
            \Mail::send('email.email_notifications', $data, function($message) use ($email, $subject){
                $message->from('lnxxapp@gmail.com');
                $message->to($email);
                $message->subject($subject);
            }); 
        }

            return back()->with('email_notifications_update', 'email_notifications_update');

        } catch (Exception $exception) {
            return back();
        }
    }


    public function store( Request $request ){

        $request['unique_id'] = mt_rand(100000,999999);
        $inputs = $request->all(); 

        $validator = (new User)->validate($inputs);
        if ($validator->fails()) {
            return redirect()->route('customer.create')
            ->withInput()->withErrors($validator);
        }            
        
        try {

            $pwd = $inputs['password'];
            $password = \Hash::make($inputs['password']);
            unset($inputs['password']);
            $inputs = $inputs + ['password' => $password];
            // Generating API key

            $name = $request->first_name .' '. $request->last_name;
            $remember_token = $this->generateTokenKey();
            $inputs = $inputs + [
                                'remember_token'  => $remember_token,
                                'name'  => $name,
                                'created_by'  => authUserId()
                            ];

            $user_id = (new User)->store($inputs);  

          if($request->user_type == 2) {
            return view('admin.customer.index')
                ->with('success', lang('messages.created', lang('customer.customer')));
          } 
          if($request->user_type == 3) {
            return view('admin.customer.admin')
                ->with('success', lang('messages.created', lang('customer.customer')));
          }  
          
        }
        catch (Exception $exception) {
         //   dd($exception);
            return redirect()->route('customer.create')
                ->withInput()
                ->with('error', lang('messages.server_error'));
        }
    }

    public function update_applications($id = null){
        try {

            $result = Application::where('id', $id)->select('id', 'salutation', 'name', 'middle_name', 'last_name', 'ref_id', 'status', 'service_id', 'email')->first();
            if (!$result) {
                abort(404);
            }    

            $service = Service::where('id', $result->service_id)->select('name', 'id')->first();
            $applications_status = ApplicationStatus::where('status', 1)->select('id', 'name')->get();
            $app_status = \DB::table('app_status')
                ->join('users', 'users.id', '=', 'app_status.updated_by')
                ->join('application_status', 'application_status.id', '=', 'app_status.status_id')
                ->select('app_status.comment', 'users.name', 'users.middle_name', 'users.last_name', 'app_status.created_at', 'application_status.name as application_status')->where('app_status.app_id', $id)->orderBy('app_status.id', 'desc')->get();

            $EmailNotifications = \DB::table('email_notifications')
                ->join('users', 'users.id', '=', 'email_notifications.created_by')
                ->select('email_notifications.message', 'users.name', 'users.middle_name', 'users.last_name', 'email_notifications.created_at', 'email_notifications.subject', 'email_notifications.email', 'email_notifications.attachment')->where('email_notifications.app_id', $id)->orderBy('email_notifications.id', 'desc')->get();

            return view('admin.applications.update_applications', compact('result', 'service', 'applications_status', 'app_status', 'EmailNotifications'));

        } catch (Exception $e) {
            return back();
        }
    }


    public function update(Request $request, $id = null) {
        $result = User::find($id);
        $user_type = $result->user_type;

        if (!$result) {
            return redirect()->route('customer.index')
                ->with('error', lang('messages.invalid_id', string_manip(lang('customer.customer'))));
        }

        $inputs = $request->all();
        $validator = (new User)->validate_update($inputs, $id);
        if ($validator->fails()) {
            return redirect()->route('customer.edit',[$id])
            ->withInput()->withErrors($validator);
        } 

        try {
             
             $name = $request->first_name .' '. $request->last_name;
             $inputs = $inputs + [
                'name'  => $name,
                'updated_by'=> authUserId()
              ];
          
            (new User)->store($inputs, $id); 

        if($request->user_type == 2) {
          return redirect()->route('customer')
                ->with('success', lang('messages.updated', lang('customer.customer')));
        }

        if($request->user_type == 3) {
          return redirect()->route('admin_users')
                ->with('success', lang('messages.updated', lang('customer.customer')));
        }
      
        } catch (\Exception $exception) {

        //  dd($exception);

            return redirect()->route('customer.edit',[$id])
                ->with('error', lang('messages.server_error'));
 
        }
    }
    

    private function generateTokenKey() {
        return md5(uniqid(rand(), true));
    }

    public function edit($id = null)  {
        $result = Application::find($id);
        if (!$result) {
            abort(404);
        }

        $PersonalLoanlimit = "";
        $PersonalLoanPreference = [];
        $CardTypePreference = [];
        $Personalloanform = [];
   
        $country = Country::all();
        $countries = Country::all();
        $Application_Request = ApplicationProductRequest::where('application_id', $id)->first();

        $company = Company::where('status', 1)->select('id', 'name')->get();
        $banks = Bank::where('status', 1)->select('id', 'name')->get();

        $bank = Bank::where('id', $result->preference_bank_id)->select('id', 'name')->first();
        $service = Service::where('id', $result->service_id)->select('id', 'name')->first();

        $address_details = Address::where('customer_id', $id)->first();
        $UserEducation = UserEducation::where('user_id', $id)->first();
        $services = \DB::table('service_applies')
                    ->join('services', 'services.id', '=', 'service_applies.service_id')
                    ->select('service_applies.status', 'services.name', 'services.image')
                    ->where('service_applies.customer_id', $id)->get();
        $sel_services = ServiceApply::where('customer_id', $id)->pluck('service_id')->toArray();
        $dependents = ApplicationDependent::where('app_id', $id)->select('name', 'relation')->get();

        if($result->service_id == 1){
            $PersonalLoanlimit =  ApplicationPersonalLoanPreferenceBank::where('app_id', $result->id)->select('loan_limit', 'loan_emi')->first();
            $PersonalLoanPreference = \DB::table('application_personal_loan_preference_bank')
                    ->join('banks', 'banks.id', '=', 'application_personal_loan_preference_bank.bank_id')
                    ->select('banks.name', 'banks.id')
                    ->where('application_personal_loan_preference_bank.app_id', $id)->get();
            $Personalloanform = ApplicationPersonalLoanInformation::where('app_id', $id)->first();

        }
        if($result->service_id == 3){
            $PersonalLoanlimit =  ApplicationCreditCardPreferenceBank::where('app_id', $result->id)->select('loan_limit')->first();
            $PersonalLoanPreference = \DB::table('application_credit_card_preference_bank')
                    ->join('banks', 'banks.id', '=', 'application_credit_card_preference_bank.bank_id')
                    ->select('banks.name', 'banks.id')
                    ->where('application_credit_card_preference_bank.app_id', $id)->get();

            $CardTypePreference = \DB::table('application_card_type_preference')
                    ->join('card_type', 'card_type.id', '=', 'application_card_type_preference.type_id')
                    ->select('card_type.name', 'card_type.id')
                    ->where('application_card_type_preference.app_id', $id)->get();

        }

        $app_data = ApplicationData::where('app_id', $id)->first();

        return view('admin.applications.create', compact('result', 'country', 'UserEducation', 'address_details', 'countries', 'services', 'sel_services', 'company', 'banks', 'Application_Request', 'bank', 'service', 'dependents', 'PersonalLoanlimit', 'PersonalLoanPreference', 'CardTypePreference', 'app_data', 'Personalloanform'));
    }
    
    public function profile_pdf(Request $request){
       try {
          //  $data = [];

            $bank = Bank::where('id', $request->bank_id)->select('image')->first();
            $home = route('get-started');
            $data['bank_logo'] = $home.$bank->image;
            $id = $request->id;
            $result = Application::find($id);
            if (!$result) {
                abort(404);
            }

            $PersonalLoanlimit = "";
            $PersonalLoanPreference = [];
            $CardTypePreference = [];
            $Personalloanform = [];

            $data['profile_image'] = $home.$result->profile_image;
            $data['home'] = $home;
       
            $country = Country::all();
            $countries = Country::all();
            $Application_Request = ApplicationProductRequest::where('application_id', $id)->first();

            $company = Company::where('status', 1)->select('id', 'name')->get();
            $banks = Bank::where('status', 1)->select('id', 'name')->get();

            $bank = Bank::where('id', $result->preference_bank_id)->select('id', 'name')->first();
            $service = Service::where('id', $result->service_id)->select('id', 'name')->first();

            $address_details = Address::where('customer_id', $id)->first();
            $UserEducation = UserEducation::where('user_id', $id)->first();
            $services = \DB::table('service_applies')
                        ->join('services', 'services.id', '=', 'service_applies.service_id')
                        ->select('service_applies.status', 'services.name', 'services.image')
                        ->where('service_applies.customer_id', $id)->get();
            $sel_services = ServiceApply::where('customer_id', $id)->pluck('service_id')->toArray();
            $dependents = ApplicationDependent::where('app_id', $id)->select('name', 'relation')->get();

            if($result->service_id == 1){
                $PersonalLoanlimit =  ApplicationPersonalLoanPreferenceBank::where('app_id', $result->id)->select('loan_limit', 'loan_emi')->first();
                $PersonalLoanPreference = \DB::table('application_personal_loan_preference_bank')
                        ->join('banks', 'banks.id', '=', 'application_personal_loan_preference_bank.bank_id')
                        ->select('banks.name', 'banks.id')
                        ->where('application_personal_loan_preference_bank.app_id', $id)->get();
                $Personalloanform = ApplicationPersonalLoanInformation::where('app_id', $id)->first();
            }
            if($result->service_id == 3){
                $PersonalLoanlimit =  ApplicationCreditCardPreferenceBank::where('app_id', $result->id)->select('loan_limit')->first();

                $PersonalLoanPreference = \DB::table('application_credit_card_preference_bank')
                    ->join('banks', 'banks.id', '=', 'application_credit_card_preference_bank.bank_id')
                    ->select('banks.name', 'banks.id')
                    ->where('application_credit_card_preference_bank.app_id', $id)->get();


                $CardTypePreference = \DB::table('application_card_type_preference')
                ->join('card_type', 'card_type.id', '=', 'application_card_type_preference.type_id')
                ->select('card_type.name', 'card_type.id')
                ->where('application_card_type_preference.app_id', $id)->get();
            }

            $app_data = ApplicationData::where('app_id', $id)->first();

            $data['result'] = $result;
            $data['country'] = $country;
            $data['UserEducation'] = $UserEducation;
            $data['address_details'] = $address_details; 
            $data['countries'] = $countries;
            $data['services'] = $services;
            $data['sel_services'] = $sel_services;
            $data['company'] = $company;
            $data['banks'] = $banks;
            $data['Application_Request'] = $Application_Request;
            $data['bank'] = $bank;
            $data['service'] = $service;
            $data['dependents'] = $dependents;
            $data['PersonalLoanlimit'] = $PersonalLoanlimit;
            $data['PersonalLoanPreference'] = $PersonalLoanPreference;
            $data['CardTypePreference'] = $CardTypePreference;
            $data['app_data'] = $app_data;
            $data['Personalloanform'] = $Personalloanform;

            if($request->bank_id == 10 && $result->service_id == 5){
                $pdf = \PDF::loadView('pdf.profile_fab_mor', $data);
            } else {
                $pdf = \PDF::loadView('pdf.profile', $data);
            }

                // if($id == 500 && $request->bank_id == 10){

                //     $pdf = \PDF::loadView('pdf.profile_fab_mor', $data);

                // } else {

                //     $pdf = \PDF::loadView('pdf.profile', $data);

                // }
                
       

            return $pdf->download('profile.pdf'); 

        } catch(\Exception $exception){
           // dd($exception);
            return back();
      }
    }


    public function applications_print($id = null){
        try{
        $result = Application::find($id);
        if (!$result) {
            abort(404);
        }
        $PersonalLoanlimit = "";
        $PersonalLoanPreference = [];
        $CardTypePreference = [];
        $Personalloanform = [];
        $country = Country::all();
        $countries = Country::all();
        $Application_Request = ApplicationProductRequest::where('application_id', $id)->first();
        $company = Company::where('status', 1)->select('id', 'name')->get();
        $banks = Bank::where('status', 1)->select('id', 'name')->get();
        $bank = Bank::where('id', $result->preference_bank_id)->select('id', 'name')->first();
        $service = Service::where('id', $result->service_id)->select('id', 'name')->first();
        $address_details = Address::where('customer_id', $id)->first();
        $UserEducation = UserEducation::where('user_id', $id)->first();
        $services = \DB::table('service_applies')
                    ->join('services', 'services.id', '=', 'service_applies.service_id')
                    ->select('service_applies.status', 'services.name', 'services.image')
                    ->where('service_applies.customer_id', $id)->get();
        $sel_services = ServiceApply::where('customer_id', $id)->pluck('service_id')->toArray();
        $dependents = ApplicationDependent::where('app_id', $id)->select('name', 'relation')->get();

        if($result->service_id == 1){
            $PersonalLoanlimit =  ApplicationPersonalLoanPreferenceBank::where('app_id', $result->id)->select('loan_limit', 'loan_emi')->first();
            $PersonalLoanPreference = \DB::table('application_personal_loan_preference_bank')
                    ->join('banks', 'banks.id', '=', 'application_personal_loan_preference_bank.bank_id')->select('banks.name', 'banks.id')->where('application_personal_loan_preference_bank.app_id', $id)->get();
            $Personalloanform = ApplicationPersonalLoanInformation::where('app_id', $id)->first();

        }
        if($result->service_id == 3){
            $PersonalLoanlimit =  ApplicationCreditCardPreferenceBank::where('app_id', $result->id)->select('loan_limit')->first();
            $PersonalLoanPreference = \DB::table('application_credit_card_preference_bank')
                ->join('banks', 'banks.id', '=', 'application_credit_card_preference_bank.bank_id')
                ->select('banks.name', 'banks.id')
                ->where('application_credit_card_preference_bank.app_id', $id)->get();
            $CardTypePreference = \DB::table('application_card_type_preference')
                ->join('card_type', 'card_type.id', '=', 'application_card_type_preference.type_id')
                ->select('card_type.name', 'card_type.id')
                ->where('application_card_type_preference.app_id', $id)->get();
        }

        $app_data = ApplicationData::where('app_id', $id)->first();
        $bank_lists = get_prefer_bank_personal_loan($result->service_id);

        return view('admin.applications.print', compact('result', 'country', 'UserEducation', 'address_details', 'countries', 'services', 'sel_services', 'company', 'banks', 'Application_Request', 'bank', 'service', 'dependents', 'PersonalLoanlimit', 'PersonalLoanPreference', 'CardTypePreference', 'app_data', 'Personalloanform', 'bank_lists'));

        } catch (Exception $e) {
            return back();
        }
    }


    public function drop($id) {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }

        $result = (new Application)->find($id);
        if (!$result) {
            // use ajax return response not abort because ajaz request abort not works
            abort(401);
        }

        try {
            // get the unit w.r.t id
             $result = (new Application)->find($id);
             if($result->status == 1) {
                 $response = ['status' => 0, 'message' => lang('user.user_in_use')];
             }
             else {
                 (new Application)->tempDelete($id);
                 $response = ['status' => 1, 'message' => lang('messages.deleted', lang('user.user'))];
             }
        }
        catch (Exception $exception) {
            $response = ['status' => 0, 'message' => lang('messages.server_error')];
        }        
        // return json response
        return json_encode($response);
    }


 
    public function changePwd(Request $request) {
        try {
            $id=\Auth::user()->id;
            \DB::beginTransaction();
            /* FIND WHETHER THE USER EXISTS OR NOT */
            $user = User::find($id);
            if(!$user) {
                return apiResponse(false, 404, lang('messages.not_found', lang('user.user')));
            }
            $inputs = $request->all();
            $rules = [
                    'password' => 'required',
                    'new_password'=>'required|min:6'
                    ];
            $validator=\Validator::make($inputs, $rules);
            if ($validator->fails()) {
                return apiResponse(false, 406, "", errorMessages($validator->messages()));
            }
      
                if (!\Hash::check($inputs['password'], \Auth::user()->password) ){
                    return apiResponse(false, 406,lang('user.password_not_match'));
                }

                $password = \Hash::make($inputs['new_password']);
                unset($inputs['password']);
                $inputs = $inputs + ['password' => $password];
                
                (new User)->store($inputs, $id);
                \DB::commit();
                return apiResponse(true, 200, lang('messages.updated', lang('user.user')));
           
        }
        catch (Exception $exception) {
            \DB::rollBack();
            return apiResponse(false, 500, lang('messages.server_error'));
        }
    }

 
    public function Paginate(Request $request, $id, $pageNumber = null) {

        if (!\Request::isMethod('post') && !\Request::ajax()) { //
            return lang('messages.server_error');
        }

        $inputs = $request->all();
        
        $page = 1;
        if (isset($inputs['page']) && (int)$inputs['page'] > 0) {
            $page = $inputs['page'];
        }

        $perPage = 20;
        if (isset($inputs['perpage']) && (int)$inputs['perpage'] > 0) {
            $perPage = $inputs['perpage'];
        }

        $start = ($page - 1) * $perPage;
        if (isset($inputs['form-search']) && $inputs['form-search'] != '') {
            $inputs = array_filter($inputs);
            unset($inputs['_token']);
          //  dd($inputs);
            $data = (new Application)->getApplication($inputs, $start, $perPage);
      
            $totalGameMaster = (new Application)->totalApplication($inputs);
            $total = $totalGameMaster->total;
        } else {
            $data = (new Application)->getApplication($inputs, $start, $perPage, $id);
            $totalGameMaster = (new Application)->totalApplication();
            $total = $totalGameMaster->total;
        }

        return view('admin.applications.load_data', compact('inputs', 'data', 'total', 'page', 'perPage'));
    }


    public function Toggle($id = null) {
        if (!\Request::isMethod('post') && !\Request::ajax()) {
            return lang('messages.server_error');
        }
        try {
            $game = Application::find($id);
            //dd($game);

        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('Applications')));
        }
        $game->update(['status' => !$game->status]);
        $response = ['status' => 1, 'data' => (int)$game->status . '.gif'];
        return json_encode($response);
    }

    public function Action(Request $request) {
        $inputs = $request->all();
        if (!isset($inputs['tick']) || count($inputs['tick']) < 1) {
             return view('admin.applications.index')->with('error', lang('messages.atleast_one', string_manip(lang('customer.customer'))));
        }

        $ids = '';
        foreach ($inputs['tick'] as $key => $value) {
            $ids .= $value . ',';
        }

        $ids = rtrim($ids, ',');
        $status = 0;
        if (isset($inputs['active'])) {
            $status = 1;
        }

        Application::whereRaw('id IN (' . $ids . ')')->update(['status' => $status]);
        return redirect()->route('applications.index')
            ->with('success', 'Applications');
    }


    
    
}