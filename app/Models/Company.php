<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model {
    use SoftDeletes;
    protected $table = 'company';
   
    protected $fillable = [
        'name', 'type', 'address', 'email', 'mobile', 'status', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function store($inputs, $id = null)  {
        if ($id) {
            return $this->find($id)->update($inputs);
        } else {
            return $this->create($inputs)->id;
        }
    }

     public function getCompany($search = null, $skip, $perPage) {
        $take = ((int)$perPage > 0) ? $perPage : 20;
        $filter = 1; // default filter if no search

        $fields = [
            'id',
            'name',
            'status',
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

        if (is_array($search) && count($search) > 0) {
            $f1 = (array_key_exists('name', $search)) ? " AND (name Like '%" .
                addslashes($search['name']) . "%')" : "";

            $f2 = (array_key_exists('type', $search)) ? " AND (type Like '%" .
                addslashes($search['type']) . "%')" : "";

            $f3 = (array_key_exists('status', $search)) ? " AND (status = '" .
                addslashes($search['status']) . "')" : "";


            $filter .= $f1 . $f2 . $f3;
        }

         return $this->whereRaw($filter)
                ->orderBy($orderEntity, $orderAction)
                ->skip($skip)->take($take)
                ->get($fields);
    }

  
    public function totalCompany($search = null)  {
         $filter = 1; // if no search add where

         // when search
        if(isset($search['status'])){
            if($search['status'] == 102){
                unset($search['status']);
                $search['status'] = 0;
            }
        }

        if (is_array($search) && count($search) > 0) {
            $f1 = (array_key_exists('name', $search)) ? " AND (name Like '%" .
                addslashes($search['name']) . "%')" : "";

            $f2 = (array_key_exists('type', $search)) ? " AND (type Like '%" .
                addslashes($search['type']) . "%')" : "";

            $f3 = (array_key_exists('status', $search)) ? " AND (status = '" .
                addslashes($search['status']) . "')" : "";


            $filter .= $f1 . $f2 . $f3;
        }
         return $this->select(\DB::raw('count(*) as total'))
             ->whereRaw($filter)->first();
    }

    public function tempDelete($id)  {
        $this->find($id)->update([ 'deleted_by' => authUserId(), 'deleted_at' => convertToUtc()]);
    }


}
