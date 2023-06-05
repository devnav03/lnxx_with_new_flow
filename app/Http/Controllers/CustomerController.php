<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;
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
use App\Models\Company;
use App\Models\ServiceApply;
use App\Models\Bank;
use League\Flysystem\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller {
   
    public function index() {
        return view('admin.customer.index');
    }

    public function admin_users() {
        return view('admin.customer.admin');
    }

    public function store( Request $request ){

        $request['unique_id'] = mt_rand(100000,999999);
        $inputs = $request->all(); 

        $validator = (new User)->validate($inputs);
        if ($validator->fails()) {
            return redirect()->route('customer.create')
            ->withInput()->withErrors($validator);
        }            
        
        try{

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


    public function export_cus_excel(Request $request){

        // $inputs = $request->all(); 
        $start = 0;
        $perPage = 200000;

        $inputs['form-search'] = 1;
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
        if($request->user_id != null){
            $inputs['user_id'] = $request->user_id;
        }
        

        $data = (new User)->getCustomer($inputs, $start, $perPage);

        $fileName = 'Customers.csv';
        $headers = array(
              "Content-type"        => "text/csv",
              "Content-Disposition" => "attachment; filename=$fileName",
              "Pragma"              => "no-cache",
              "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
              "Expires"             => "0"
          );
          
          $columns = array('ID', 'Name', 'Mobile', 'Email', 'Application', 'Register at', 'Gender', 'Date of Birth', 'Profile Image', 'Emirates ID Number', 'Referral By');

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
                $no = 1300+$value->id;
                $total_app = get_total_customer_app($value->id);
                $no_r = 1300+$value->referral_id;
                if($value->referral_name){
                    $ref = $value->referral_name.' (Lnxx'.$no_r.')';
                } else {
                    $ref = '';
                }
                $row['id'] = 'Lnxx'.$no;
                $row['name'] = $value->salutation.' '.$value->name.' '.$value->middle_name.' '.$value->last_name;
                $row['mobile'] = $value->mobile;
                $row['email'] = $value->email;
                $row['application'] = $total_app;
                $row['register_at'] =  date('d M, Y', strtotime($value->created_at));
                $row['gender'] =  $value->gender;
                $row['date_of_birth'] = $value->date_of_birth;
                $row['profile_image'] =  $url.$value->profile_image;
                $row['emirates_id_number'] = $value->eid_number;
                $row['referral_by'] = $ref;
                fputcsv($file, array($row['id'],$row['name'], $row['mobile'],
                   $row['email'], $row['application'], $row['register_at'],
                   $row['gender'], $row['date_of_birth'], $row['profile_image'], $row['emirates_id_number'], $row['referral_by']));
               }    
             }
            fclose($file);
          };
        
        if(isset($request->url)){
            $url = route('get-started');
            $url = $url.'/admin/export_cus_excel?name='.$request->name.'&email='.$request->email.'&mobile='.$request->mobile.'&from='.$request->from.'&user_id='.$request->user_id.'&to='.$request->to.'';

            $datas= ['status'=>200,'url'=>$url];
            return response()->json($datas);

        } else {

            return response()->stream($callback, 200, $headers);
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

        try {
             
            $inputs = $inputs + [
                'updated_by'=> authUserId()
            ];
          
            (new User)->store($inputs, $id); 

        if($request->user_type == 2) {
          return redirect()->route('users.index')
                ->with('success', lang('messages.updated', lang('User')));
        }

        if($request->user_type == 3) {
          return redirect()->route('admin_users')
                ->with('success', lang('messages.updated', lang('customer.customer')));
        }
      
        } catch (\Exception $exception) {

        //  dd($exception);
            return redirect()->route('users.edit',[$id])
                ->with('error', lang('messages.server_error'));
 
        }
    }
    

    private function generateTokenKey() {
        return md5(uniqid(rand(), true));
    }

    public function edit($id = null) {
        $result = User::find($id);
        if (!$result) {
            abort(404);
        }
       if(((\Auth::user()->user_type)) == 1){
        
        $country = Country::all();
        $countries = Country::all();

        // $other_cm_details = OtherCmDetail::where('customer_id', $id)->first();
        // $cm_salaried_details = CmSalariedDetail::where('customer_id', $id)->first();
        // $self_emp_details = SelfEmpDetail::where('customer_id', $id)->first();
        // $customer_onboarding = CustomerOnboarding::where('user_id', $id)->first();
        // $product_requested = ProductRequest::where('user_id', $id)->first();

        $company = Company::where('status', 1)->select('id', 'name')->get();
        $banks = Bank::where('status', 1)->select('id', 'name')->get();

        $address_details = Address::where('customer_id', $id)->first();
        $UserEducation = UserEducation::where('user_id', $id)->first();
        $services = \DB::table('service_applies')
                    ->join('services', 'services.id', '=', 'service_applies.service_id')
                    ->select('service_applies.status', 'services.name', 'services.image')
                    ->where('service_applies.customer_id', $id)->get();
        $sel_services = ServiceApply::where('customer_id', $id)->pluck('service_id')->toArray();
                    
        return view('admin.customer.create', compact('result', 'country', 'UserEducation', 'address_details', 'countries', 'services', 'sel_services', 'company', 'banks'));
      } else {
        echo "404";
      }
    }


    public function drop($id) {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }

        $result = (new User)->find($id);
        if (!$result) {
            // use ajax return response not abort because ajaz request abort not works
            abort(401);
        }

        try {
            // get the unit w.r.t id
             $result = (new User)->find($id);
             if($result->status == 1) {
                 $response = ['status' => 0, 'message' => lang('user.user_in_use')];
             }
             else {
                 (new User)->tempDelete($id);
                 $response = ['status' => 1, 'message' => lang('messages.deleted', lang('user.user'))];
             }
        }
        catch (Exception $exception) {
            $response = ['status' => 0, 'message' => lang('messages.server_error')];
        }        
        // return json response
        return json_encode($response);
    }

    
    public function getUserDetail() {
        try {
            if(\Auth::check()) {

                $user =User::where('id',\Auth::user()->id)->first();
                if( $user){
                    
                    return apiResponse(true, 200 , null, [], $user);
                }
                return apiResponse(false, 404, lang('messages.not_found', lang('user.user')));
            }
            else {
                return apiResponse(false, 404, lang('auth.customer_not_accessible'));
            }
        }
        catch (Exception $exception) {
            \DB::rollBack();
            return apiResponse(false, 500, lang('messages.server_error'));
        }
    }

 
    public function changePwd(Request $request)
    {
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

 
    public function customerPaginate(Request $request, $id, $pageNumber = null)
    {

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

            $data = (new User)->getCustomer($inputs, $start, $perPage);
            $totalGameMaster = (new User)->totalCustomer($inputs);
            $total = $totalGameMaster->total;
        } else {

            $data = (new User)->getCustomer($inputs, $start, $perPage, $id);
            $totalGameMaster = (new User)->totalCustomer();
            $total = $totalGameMaster->total;
        }

        return view('admin.customer.load_data', compact('inputs', 'data', 'total', 'page', 'perPage'));
    }

    // Dealer Pagination Start

     public function customerPaginate_dealer(Request $request, $id, $pageNumber = null)
    {

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

            $data = (new Dealer)->getCustomer($inputs, $start, $perPage);
            $totalGameMaster = (new Dealer)->totalCustomer($inputs);
            $total = $totalGameMaster->total;
        } else {

            $data = (new Dealer)->getCustomer($inputs, $start, $perPage, $id);
            $totalGameMaster = (new Dealer)->totalCustomer();
            $total = $totalGameMaster->total;
        }

        return view('admin.customer.load_data1', compact('inputs', 'data', 'total', 'page', 'perPage'));
    }

    // Dealer Pagination End


    // Data Entry Pagination Start

     public function customerPaginate_data_entry(Request $request, $id, $pageNumber = null)
    {

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

            $data = (new User)->getAdmin($inputs, $start, $perPage);
            $totalGameMaster = (new User)->totalAdmin($inputs);
            $total = $totalGameMaster->total;
        } else {

            $data = (new User)->getAdmin($inputs, $start, $perPage, $id);
            $totalGameMaster = (new User)->totalAdmin();
            $total = $totalGameMaster->total;
        }

        return view('admin.customer.load_data1', compact('inputs', 'data', 'total', 'page', 'perPage'));
    }

    // Data Entry Pagination End


    /**
     * code for toggle - financial year status
     * @param null $id
     * @return string
     */

    public function customerToggle($id = null)
    {
         if (!\Request::isMethod('post') && !\Request::ajax()) {
            return lang('messages.server_error');
        }

        try {
            $game = User::find($id);
            //dd($game);

        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('Order')));
        }

        $game->update(['status' => !$game->status]);
        $response = ['status' => 1, 'data' => (int)$game->status . '.gif'];
 

        // return json response
        return json_encode($response);
    }

    /**
     * Method is used to update status of group enable/disable
     *
     * @return \Illuminate\Http\Response
     */
    public function customerAction(Request $request)
    {
        $inputs = $request->all();
        if (!isset($inputs['tick']) || count($inputs['tick']) < 1) {
            // return redirect()->route('customer.index')
             return view('admin.customer.index')->with('error', lang('messages.atleast_one', string_manip(lang('customer.customer'))));
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

        User::whereRaw('id IN (' . $ids . ')')->update(['status' => $status]);
        return redirect()->route('customer.index')
            ->with('success', lang('messages.updated', lang('game_master.game')));
    }


    public function customerAction_data_entry(Request $request)
    {
        $inputs = $request->all();
        if (!isset($inputs['tick']) || count($inputs['tick']) < 1) {
            // return redirect()->route('customer.index')
             return view('admin.customer.admin')->with('error', lang('messages.atleast_one', string_manip(lang('customer.customer'))));
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

        User::whereRaw('id IN (' . $ids . ')')->update(['status' => $status]);
        return redirect()->route('admin_users')
            ->with('success', lang('messages.updated', lang('game_master.game')));
    }
    

     public function customerRecord(request $request){

    try {
     
      $inputs = $request->all();
      $validator = (new User)->recordvalidate($inputs);
          if( $validator->fails() ) {
              return back()->withErrors($validator)->withInput();
          }
          $to = date('Y-m-d', strtotime($request['to']));
          $from = date('Y-m-d', strtotime($request['from']));

         // $data['orders'] =  User::whereRaw('date_format(users.created_at,"%Y-%m-%d")'.">='".$from . "'")
         //    ->whereRaw('date_format(users.created_at,"%Y-%m-%d")'."<='".$to . "'")->select('name', 'email', 'mobile')->get();
         // $pdf = \PDF::loadView('pdf.user', $data);
         //  return $pdf->download('user.pdf'); 

          $users =  User::whereRaw('date_format(users.created_at,"%Y-%m-%d")'.">='".$from . "'")
            ->whereRaw('date_format(users.created_at,"%Y-%m-%d")'."<='".$to . "'")->select('name', 'email', 'mobile', 'status', 'created_at')->get();

          \Excel::create('users', function($excel) use($users) {
            $excel->sheet('customer', function($sheet) use($users) {
                $excelData = [];
                $excelData[] = [
                'Name',
                'Email',
                'Mobile',
                'Status',
                'Created At',
                ];
                foreach ($users as $key => $value) {
                $excelData[] = [
                $value->name,
                $value->email,
                $value->mobile,
                $value->status  == 1 ? 'Active' : 'Inactive',
                date("M d Y", strtotime($value->created_at)),
                ]; 
                }
                $sheet->fromArray($excelData, null, 'A1', true, false);
            });
            })->download('xlsx');

        }
        catch (Exception $exception) {
           // dd($exception);
            $response = ['status' => 0, 'message' => lang('messages.server_error')];
        }

  }


  public function export_users(){
     
     try{
          $users = User::Orderby('created_at', 'desc')->where('id', '!=', 1)->get();
        

            \Excel::create('users', function($excel) use($users) {
            $excel->sheet('customer', function($sheet) use($users) {
                $excelData = [];
                $excelData[] = [
                'Name',
                'Email',
                'Mobile',
                'Status',
                'Created At',
                ];
                foreach ($users as $key => $value) {
                $excelData[] = [
                $value->name,
                $value->email,
                $value->mobile,
                $value->status  == 1 ? 'Active' : 'Inactive',
                date("M d Y", strtotime($value->created_at)),
                ]; 
                }
                $sheet->fromArray($excelData, null, 'A1', true, false);
            });
            })->download('xlsx');

     } catch(Exception $exc){
     // dd($exc);

       $response = ['status' => 0, 'message' => lang('messages.server_error')];

     }

 }


 public function export_tax(){
     
     try{
          $users = Tax::Orderby('created_at', 'desc')->get();
        

            \Excel::create('tax', function($excel) use($users) {
            $excel->sheet('contact', function($sheet) use($users) {
                $excelData = [];
                $excelData[] = [
                'Name',
                'Value',
                'Created At',
                ];
                foreach ($users as $key => $value) {
                $excelData[] = [
                $value->name,
                $value->value,
                date("M d Y", strtotime($value->created_at)),
                ]; 
                }
                $sheet->fromArray($excelData, null, 'A1', true, false);
            });
            })->download('xlsx');

     } catch(Exception $exc){
     // dd($exc);

       $response = ['status' => 0, 'message' => lang('messages.server_error')];

     }

 }

 public function export_brand(){
 
     try{
          $users = Brand::Orderby('created_at', 'desc')->get();
        

            \Excel::create('brand', function($excel) use($users) {
            $excel->sheet('contact', function($sheet) use($users) {
                $excelData = [];
                $excelData[] = [
                'Name',
                'Created At',
                ];
                foreach ($users as $key => $value) {
                $excelData[] = [
                $value->name,
                date("M d Y", strtotime($value->created_at)),
                ]; 
                }
                $sheet->fromArray($excelData, null, 'A1', true, false);
            });
            })->download('xlsx');

     } catch(Exception $exc){
     // dd($exc);

       $response = ['status' => 0, 'message' => lang('messages.server_error')];

     }


 }

public function export_size(){
 
     try{
          $users = Size::Orderby('created_at', 'desc')->get();
        

            \Excel::create('size', function($excel) use($users) {
            $excel->sheet('contact', function($sheet) use($users) {
                $excelData = [];
                $excelData[] = [
                'Size',
                'Created At',
                ];
                foreach ($users as $key => $value) {
                $excelData[] = [
                $value->size,
                date("M d Y", strtotime($value->created_at)),
                ]; 
                }
                $sheet->fromArray($excelData, null, 'A1', true, false);
            });
            })->download('xlsx');

     } catch(Exception $exc){
     // dd($exc);

       $response = ['status' => 0, 'message' => lang('messages.server_error')];

     }

 }


public function export_category(){
 
     try{
          $users = Category::Orderby('created_at', 'desc')->get();
        

            \Excel::create('category', function($excel) use($users) {
            $excel->sheet('contact', function($sheet) use($users) {
                $excelData = [];
                $excelData[] = [
                'Name',
                'Created At',
                ];
                foreach ($users as $key => $value) {
                $excelData[] = [
                $value->name,
                date("M d Y", strtotime($value->created_at)),
                ]; 
                }
                $sheet->fromArray($excelData, null, 'A1', true, false);
            });
            })->download('xlsx');

     } catch(Exception $exc){
     // dd($exc);

       $response = ['status' => 0, 'message' => lang('messages.server_error')];

     }

 }
 


public function export_style(){
 
     try{
          $users = Style::Orderby('created_at', 'desc')->get();
        

            \Excel::create('style', function($excel) use($users) {
            $excel->sheet('contact', function($sheet) use($users) {
                $excelData = [];
                $excelData[] = [
                'Name',
                'Created At',
                ];
                foreach ($users as $key => $value) {
                $excelData[] = [
                $value->style,
                date("M d Y", strtotime($value->created_at)),
                ]; 
                }
                $sheet->fromArray($excelData, null, 'A1', true, false);
            });
            })->download('xlsx');

     } catch(Exception $exc){
     // dd($exc);

       $response = ['status' => 0, 'message' => lang('messages.server_error')];

     }

 }

 

public function export_order(){
 
     try{
          $users = \DB::table('orders')
            ->join('order_statuses', 'order_statuses.id' ,'=', 'orders.current_status')
            ->join('users', 'users.id' ,'=', 'orders.user_id')
            ->select('orders.id','orders.user_id', 'orders.order_nr', 'orders.total_price', 'orders.wallet_paid',
             'orders.payment_method','orders.current_status', 'orders.status',
            'order_statuses.type as current_status','users.name as user_name', 'orders.created_at')
            ->Orderby('orders.created_at', 'desc')
            ->get();
        

            \Excel::create('orders', function($excel) use($users) {
            $excel->sheet('contact', function($sheet) use($users) {
                $excelData = [];
                $excelData[] = [
                'Name',
                'Order No.',
                'Price',
                'Status',
                'Payment Method',
                'Created At',
                ];
                foreach ($users as $key => $value) {
                $excelData[] = [
                $value->user_name,
                $value->order_nr,
                $value->total_price,
                $value->current_status,
                $value->payment_method,
                date("M d Y", strtotime($value->created_at)),
                ]; 
                }
                $sheet->fromArray($excelData, null, 'A1', true, false);
            });
            })->download('xlsx');

     } catch(Exception $exc){
     // dd($exc);

       $response = ['status' => 0, 'message' => lang('messages.server_error')];

     }

 }



public function export_manufacture(){
 
     try{
          $users = Manufacture::Orderby('created_at', 'desc')->get();
        

            \Excel::create('manufacture', function($excel) use($users) {
            $excel->sheet('contact', function($sheet) use($users) {
                $excelData = [];
                $excelData[] = [
                'Name',
                'Created At',
                ];
                foreach ($users as $key => $value) {
                $excelData[] = [
                $value->name,
                date("M d Y", strtotime($value->created_at)),
                ]; 
                }
                $sheet->fromArray($excelData, null, 'A1', true, false);
            });
            })->download('xlsx');

     } catch(Exception $exc){
     // dd($exc);

       $response = ['status' => 0, 'message' => lang('messages.server_error')];

     }

 }



public function export_reserve(){
 
     try{

          $users= \DB::table('reserves')
          ->join('products', 'reserves.product_id', '=','products.id')
          ->select('products.name as product','reserves.*')
          ->get();
        

            \Excel::create('reserve', function($excel) use($users) {
            $excel->sheet('contact', function($sheet) use($users) {
                $excelData = [];
                $excelData[] = [
                'Name',
                'Product',
                'Email',
                'Phone',
                'Reserve Id',
                'Created At',
                ];
                foreach ($users as $key => $value) {
                $excelData[] = [
                $value->name,
                $value->product,
                $value->email,
                $value->mobile,
                $value->reserve_id,
                date("M d Y", strtotime($value->created_at)),
                ]; 
                }
                $sheet->fromArray($excelData, null, 'A1', true, false);
            });
            })->download('xlsx');

     } catch(Exception $exc){
     // dd($exc);

       $response = ['status' => 0, 'message' => lang('messages.server_error')];

     }

 }



public function export_color(){
 
     try{
          $users = Color::Orderby('created_at', 'desc')->get();
        

            \Excel::create('color', function($excel) use($users) {
            $excel->sheet('contact', function($sheet) use($users) {
                $excelData = [];
                $excelData[] = [
                'Name',
                'Created At',
                ];
                foreach ($users as $key => $value) {
                $excelData[] = [
                $value->name,
                date("M d Y", strtotime($value->created_at)),
                ]; 
                }
                $sheet->fromArray($excelData, null, 'A1', true, false);
            });
            })->download('xlsx');

     } catch(Exception $exc){
     // dd($exc);

       $response = ['status' => 0, 'message' => lang('messages.server_error')];

     }

 }



 public function export_enquiry(){
     
     try{
          $users = Contact::Orderby('created_at', 'desc')->get();
        

            \Excel::create('enquiry', function($excel) use($users) {
            $excel->sheet('contact', function($sheet) use($users) {
                $excelData = [];
                $excelData[] = [
                'Name',
                'Email',
                'Mobile',
                'Subject',
                'Message',
                'Created At',
                ];
                foreach ($users as $key => $value) {
                $excelData[] = [
                $value->first_name,
                $value->email,
                $value->phone,
                $value->subject,
                $value->message,
                date("M d Y", strtotime($value->created_at)),
                ]; 
                }
                $sheet->fromArray($excelData, null, 'A1', true, false);
            });
            })->download('xlsx');

     } catch(Exception $exc){
     // dd($exc);

       $response = ['status' => 0, 'message' => lang('messages.server_error')];

     }

 }

public function exportSubscribe(){

   try{
          $users = Subscriber::Orderby('created_at', 'desc')->get();
        

            \Excel::create('subscribe', function($excel) use($users) {
            $excel->sheet('contact', function($sheet) use($users) {
                $excelData = [];
                $excelData[] = [
                'Email',
                'Created At',
                ];
                foreach ($users as $key => $value) {
                $excelData[] = [
                $value->email,
                date("M d Y", strtotime($value->created_at)),
                ]; 
                }
                $sheet->fromArray($excelData, null, 'A1', true, false);
            });
            })->download('xlsx');

     } catch(Exception $exc){
     // dd($exc);

       $response = ['status' => 0, 'message' => lang('messages.server_error')];

     }

}



   
}