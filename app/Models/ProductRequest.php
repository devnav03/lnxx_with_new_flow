<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model {

    protected $fillable = [ 
    	'user_id', 
    	'credit_card_limit', 
        'exist_credit',
    	'details_of_cards', 
    	'credit_bank_name', 
    	'card_limit',
        'credit_member_since',

        'variable_income',

    	'details_of_cards2',
    	'credit_bank_name2',
    	'card_limit2',
        'credit_member_since2',

    	'details_of_cards3',
    	'credit_bank_name3',
    	'card_limit3',
        'credit_member_since3',

    	'details_of_cards4',
    	'credit_bank_name4',
    	'card_limit4',
        'credit_member_since4',
        
        'exist_personal',
        'loan_amount', 
        'loan_bank_name', 
        'original_loan_amount', 
        'loan_emi',
        'loan_member_since',

        'loan_bank_name2',
        'original_loan_amount2',
        'loan_emi2',
        'loan_member_since2',

        'loan_bank_name3',
        'original_loan_amount3',
        'loan_emi3',
        'loan_member_since3',

        'loan_bank_name4',
        'original_loan_amount4',
        'loan_emi4',
        'loan_member_since4',

        'expected_monthly_average_spend',
        
        'exist_business',
        'business_loan_amount', 
        'business_loan_emi',
        'business_member_since',

        'business_loan_amount2',
        'business_loan_emi2',
        'business_member_since2',

        'business_loan_amount3',
        'business_loan_emi3',
        'business_member_since3',

        'business_loan_amount4',
        'business_loan_emi4',
        'business_member_since4',
        
        'exist_mortgage',
        'mortgage_loan_amount', 
        'purchase_price', 
        'type_of_loan', 
        'term_of_loan', 
        'end_use_of_property', 
        'interest_rate', 
        'mortgage_emi',
        'mortgage_member_since',


        'mortgage_loan_amount2', 
        'purchase_price2', 
        'type_of_loan2', 
        'term_of_loan2', 
        'end_use_of_property2', 
        'interest_rate2', 
        'mortgage_emi2',
        'mortgage_member_since2',
        

        'mortgage_loan_amount3', 
        'purchase_price3', 
        'type_of_loan3', 
        'term_of_loan3', 
        'end_use_of_property3', 
        'interest_rate3', 
        'mortgage_emi3',
        'mortgage_member_since3',

        'mortgage_loan_amount4', 
        'purchase_price4', 
        'type_of_loan4', 
        'term_of_loan4', 
        'end_use_of_property4', 
        'interest_rate4', 
        'mortgage_emi4',
        'mortgage_member_since4',

        'created_at', 
        'updated_at' 
    ];


    public function store($inputs, $id = null)  {
        if ($id) {
            return $this->find($id)->update($inputs);
        } else {
            return $this->create($inputs)->id;
        }
    }


}

 