<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Application extends Model {
	
    protected $fillable = [ 
    	'user_id', 
    	'agent_id', 
    	'salutation', 
    	'name', 
    	'middle_name', 
    	'last_name', 
    	'email', 
        'gender', 
        'date_of_birth', 
        'profile_image', 
        'emirates_id', 
        'emirates_id_back', 
        'eid_number', 
        'eid_status', 
	    'mobile', 
	    'status', 
	    'ref_id', 
	    'nationality', 
	    'service_id', 
        'wife_name',
        'wedding_anniversary_date',
	    'passport_number', 
	    'passport_expiry_date', 
	    'officer_email', 
	    'visa_number', 
	    'marital_status', 
	    'years_in_uae', 
        'agent_reference',
	    'reference_number', 
	    'passport_photo', 
	    'video', 
	    'no_of_dependents', 
	    'consent_form', 
	    'cm_type', 
	    'preference_bank_id', 
        'decide_by',
	    'credit_score', 
        'aecb_date',
        'aecb_image',
	    'company_name',
	    'date_of_joining',
	    'monthly_salary',
        'last_three_salary_credits',
        'last_two_salary_credits',
        'last_one_salary_credits',
        'last_one_salary_file',
        'last_two_salary_file',
        'last_three_salary_file',
        'other_company',
        'self_company_name',
        'percentage_ownership',
        'profession_business',
        'annual_business_income',
        'monthly_pension',
        'spouse_date_of_birth',
        'accommodation_company',
	    'created_at', 
	    'updated_at' 
	];

    public function store($inputs, $id = null) {
        if ($id){
            return $this->find($id)->update($inputs);
        } else {
            return $this->create($inputs)->id;
        }
    }

    public function getApplication($search = null, $skip, $perPage) {
         $take = ((int)$perPage > 0) ? $perPage : 20;
         $filter = 1; // default filter if no search
         $fields = [
                'applications.id',
                'applications.salutation',
                'applications.middle_name',
                'applications.last_name',
                'applications.name',
                'applications.email',
                'applications.mobile', 
                'applications.status',
                'applications.profile_image',
                'applications.gender',
                'applications.salutation',
                'applications.video',
                'applications.consent_form',
                'applications.cm_type',
                'services.name as service',
                'applications.ref_id',
                'applications.date_of_birth',
                'application_status.name as status',
                'applications.created_at',
                'applications.eid_number',
                'applications.passport_number',
                'applications.passport_expiry_date',
                'applications.nationality',
                'applications.marital_status',
            ];
         $sortBy = [
             'name' => 'name',
         ];
        $orderEntity = 'id';
        $orderAction = 'desc';
        if (isset($search['sort_action']) && $search['sort_action'] != "") {
             $orderAction = ($search['sort_action'] == 1) ? 'desc' : 'asc';
        }
        if (isset($search['sort_entity']) && $search['sort_entity'] != "") {
             $orderEntity = (array_key_exists($search['sort_entity'], $sortBy)) ? $sortBy[$search['sort_entity']] : $orderEntity;
        }
            
        if(isset($search['status'])){
            if($search['status'] == 102){
                unset($search['status']);
                $search['status'] = 0;
            }
        }

        
        if(isset($search['user_id'])){
            $user_id = preg_replace("/[^0-9]/", "", $search['user_id']);
            $id = $user_id - 1300;
            $search['user_id'] = $id;
        }

        if(isset($search['from'])){
            $search['from'] = date('Y-m-d H:i:s', strtotime($search['from']));
        }

        if(isset($search['to'])){
            $search['to'] = date('Y-m-d H:i:s', strtotime($search['to']));
            $search['to'] = date('Y-m-d H:i:s', strtotime($search['to'] . ' +1 day'));
        }
             
        if (is_array($search) && count($search) > 0) {
            $f1 = (array_key_exists('email', $search)) ? " AND (applications.email Like '%" .
                addslashes($search['email']) . "%')" : "";
              
            $f2 = (array_key_exists('mobile', $search)) ? " AND (applications.mobile Like '%" .
                addslashes($search['mobile']) . "%')" : "";

            $f3 = (array_key_exists('status', $search)) ? " AND (applications.status = '" .
                addslashes($search['status']) . "')" : "";

            $f4 = (array_key_exists('name', $search)) ? " AND (applications.name LIKE '%" .
                addslashes(trim($search['name'])) . "%')" : "";  

            $f5 = (array_key_exists('from', $search)) ? " AND (applications.created_at >= '" .
                addslashes($search['from']) . "')" : "";  

            $f6 =  (array_key_exists('to', $search)) ? " AND (applications.created_at <= '" .
                addslashes($search['to']) . "')" : ""; 

            $f7 = (array_key_exists('service_id', $search)) ? " AND (applications.service_id = '" .
                addslashes($search['service_id']) . "')" : "";

            $f8 = (array_key_exists('reference_number', $search)) ? " AND (applications.reference_number = '" .
                addslashes($search['reference_number']) . "')" : "";  

            $f9 = (array_key_exists('ref_id', $search)) ? " AND (applications.ref_id = '" .
                addslashes($search['ref_id']) . "')" : ""; 

            $f10 = (array_key_exists('cm_type', $search)) ? " AND (applications.cm_type = '" .
                addslashes($search['cm_type']) . "')" : ""; 

            $f11 = (array_key_exists('user_id', $search)) ? " AND (applications.user_id = '" .
                addslashes($search['user_id']) . "')" : ""; 

            $filter .= $f1 . $f2 . $f3 . $f4 . $f5 . $f6 . $f7 . $f8 . $f9 . $f10 . $f11;
        }
        
        return $this->join('services', 'services.id', '=', 'applications.service_id')
            ->join('application_status', 'application_status.id', '=', 'applications.status')
            ->whereRaw($filter)
             // ->where('deleted_at', null)
            ->orderBy($orderEntity, $orderAction)
            ->skip($skip)

            ->take($take)
            ->get($fields);
    }

    public function totalApplication($search = null) {

        $filter = 1; // if no search add where
        if(isset($search['from'])){
            $search['from'] = date('Y-m-d H:i:s', strtotime($search['from']));
        }

        if(isset($search['to'])){
            $search['to'] = date('Y-m-d H:i:s', strtotime($search['to']));
            $search['to'] = date('Y-m-d H:i:s', strtotime($search['to'] . ' +1 day'));
        }

        if(isset($search['user_id'])){
            $user_id = preg_replace("/[^0-9]/", "", $search['user_id']);
            $id = $user_id - 1300;
            $search['user_id'] = $id;
        }

        if (is_array($search) && count($search) > 0) {
            $f1 = (array_key_exists('email', $search)) ? " AND (applications.email Like '%" .
                addslashes($search['email']) . "%')" : "";
              
            $f2 = (array_key_exists('mobile', $search)) ? " AND (applications.mobile Like '%" .
                addslashes($search['mobile']) . "%')" : "";

            $f3 = (array_key_exists('status', $search)) ? " AND (applications.status = '" .
                addslashes($search['status']) . "')" : "";
            $f4 = (array_key_exists('name', $search)) ? " AND (applications.name LIKE '%" .
                addslashes(trim($search['name'])) . "%')" : "";  

            $f5 = (array_key_exists('from', $search)) ? " AND (applications.created_at >= '" .
                addslashes($search['from']) . "')" : "";  

            $f6 =  (array_key_exists('to', $search)) ? " AND (applications.created_at <= '" .
                addslashes($search['to']) . "')" : ""; 

            $f7 = (array_key_exists('service_id', $search)) ? " AND (applications.service_id = '" .
                addslashes($search['service_id']) . "')" : "";

            $f8 = (array_key_exists('reference_number', $search)) ? " AND (applications.reference_number = '" .
                addslashes($search['reference_number']) . "')" : "";

            $f9 = (array_key_exists('ref_id', $search)) ? " AND (applications.ref_id = '" .
                addslashes($search['ref_id']) . "')" : ""; 

            $f10 = (array_key_exists('cm_type', $search)) ? " AND (applications.cm_type = '" .
                addslashes($search['cm_type']) . "')" : ""; 
            $f11 = (array_key_exists('user_id', $search)) ? " AND (applications.user_id = '" .
                addslashes($search['user_id']) . "')" : "";     

            $filter .= $f1 . $f2 . $f3 . $f4 . $f5 . $f6 . $f7 . $f8 . $f9 . $f10 . $f11;
        }

         return $this->select(\DB::raw('count(*) as total'))->whereRaw($filter)->first();
    }


}










