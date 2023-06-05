<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refer extends Model {


    protected $table = 'refers';
   
    protected $fillable = [
       'user_id', 'email', 'name', 'mobile', 'status', 'created_at', 'updated_at'
    ];

    public function validate($inputs, $id = null){
        $rules['name'] = 'required|unique:refers';
        return \Validator::make($inputs, $rules);
    }

    public function store($inputs, $id = null) {
       // dd($inputs);
        if ($id) {
            return $this->find($id)->update($inputs);
        } else {
            return $this->create($inputs)->id;
        }
    }

    public function getRefer($search = null, $skip, $perPage) {
        $take = ((int)$perPage > 0) ? $perPage : 20;
        $filter = 1; // default filter if no search

        $fields = [
            'refers.id',
            'refers.name',
            'refers.status',
            'refers.email',
            'refers.created_at',
            'refers.mobile',
            'users.id as user_id',
            'users.name as user_name'
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

        if(isset($search['from'])){
            $search['from'] = date('Y-m-d H:i:s', strtotime($search['from']));
        }
        if(isset($search['to'])){
            $search['to'] = date('Y-m-d H:i:s', strtotime($search['to']));
            $search['to'] = date('Y-m-d H:i:s', strtotime($search['to'] . ' +1 day'));
        }

        if (is_array($search) && count($search) > 0) {
            $f1 = (array_key_exists('email', $search)) ? " AND (refers.email Like '%" .
                addslashes($search['email']) . "%')" : "";
            $f2 = (array_key_exists('mobile', $search)) ? " AND (refers.mobile Like '%" .
                addslashes($search['mobile']) . "%')" : "";
            $f3 = (array_key_exists('status', $search)) ? " AND (refers.status = '" .
                addslashes($search['status']) . "')" : "";
            $f4 = (array_key_exists('name', $search)) ? " AND (refers.name LIKE '%" .
                addslashes(trim($search['name'])) . "%')" : "";  

            $f5 = (array_key_exists('from', $search)) ? " AND (refers.created_at >= '" .
                addslashes($search['from']) . "')" : "";  

            $f6 =  (array_key_exists('to', $search)) ? " AND (refers.created_at <= '" .
                addslashes($search['to']) . "')" : ""; 

            $f7 = (array_key_exists('invitee_name', $search)) ? " AND (users.name LIKE '%" .
                addslashes(trim($search['invitee_name'])) . "%')" : ""; 

            $filter .= $f1 . $f2 . $f3 . $f4 . $f5 . $f6 . $f7;
        }

        return $this->join('users', 'users.id', '=', 'refers.user_id')
            ->whereRaw($filter)
            ->orderBy($orderEntity, $orderAction)
            ->skip($skip)->take($take)
            ->get($fields);
    }

  
    public function totalRefer($search = null)  {
         $filter = 1; // if no search add where

         if(isset($search['status'])){
            if($search['status'] == 102){
                unset($search['status']);
                $search['status'] = 0;
            }
        }

        if(isset($search['from'])){
            $search['from'] = date('Y-m-d H:i:s', strtotime($search['from']));
        }
        if(isset($search['to'])){
            $search['to'] = date('Y-m-d H:i:s', strtotime($search['to']));
            $search['to'] = date('Y-m-d H:i:s', strtotime($search['to'] . ' +1 day'));
        }

        if (is_array($search) && count($search) > 0) {
            $f1 = (array_key_exists('email', $search)) ? " AND (refers.email Like '%" .
                addslashes($search['email']) . "%')" : "";
            $f2 = (array_key_exists('mobile', $search)) ? " AND (refers.mobile Like '%" .
                addslashes($search['mobile']) . "%')" : "";
            $f3 = (array_key_exists('status', $search)) ? " AND (refers.status = '" .
                addslashes($search['status']) . "')" : "";
            $f4 = (array_key_exists('name', $search)) ? " AND (refers.name LIKE '%" .
                addslashes(trim($search['name'])) . "%')" : "";  

            $f5 = (array_key_exists('from', $search)) ? " AND (refers.created_at >= '" .
                addslashes($search['from']) . "')" : "";  

            $f6 =  (array_key_exists('to', $search)) ? " AND (refers.created_at <= '" .
                addslashes($search['to']) . "')" : ""; 

            $f7 = (array_key_exists('invitee_name', $search)) ? " AND (users.name LIKE '%" .
                addslashes(trim($search['invitee_name'])) . "%')" : ""; 

            $filter .= $f1 . $f2 . $f3 . $f4 . $f5 . $f6 . $f7;
        }

        return $this->join('users', 'users.id', '=', 'refers.user_id')->select(\DB::raw('count(*) as total'))
             ->whereRaw($filter)->first();
     }

  


}
