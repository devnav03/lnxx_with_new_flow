<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DateTime;
use DB;
use Log;
use Mail;

class LeadDistribute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lead:distribute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lead Distribute hourly';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
       
        //Log::info('here');
    
        $get_lead = DB::table('leads')->where('alloted_to', Null)->get(); 
        foreach($get_lead as $get_lead){
            $check_last_id = DB::table('lead_assign_auto')->orderBy('id', 'desc')->first();
            if(!empty($check_last_id->id)){
                $get_agent_emp = DB::table('users')->wherein('user_type', [3,4])->where('id', '>', $check_last_id->assign_to_id)->first();
            }
            if(!empty($get_agent_emp->id)){
                DB::table('leads')->where('id', $get_lead->id)->update(['alloted_to' => $get_agent_emp->id]);
                DB::table('lead_assign_auto')->insert(['assign_to_id' => $get_agent_emp->id, 'assigned_lead_id' => $get_lead->id]); 
            } else {
                $get_agent_emp1 = DB::table('users')->wherein('user_type', [3,4])->first();
                DB::table('leads')->where('id', $get_lead->id)->update(['alloted_to' => $get_agent_emp1->id]);
                DB::table('lead_assign_auto')->insert(['assign_to_id' => $get_agent_emp1->id, 'assigned_lead_id' => $get_lead->id]);
            }
        }
    }
    
}
