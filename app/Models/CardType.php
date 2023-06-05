<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardType extends Model {

    protected $table = 'card_type';
   
    protected $fillable = [
        'name', 'image', 'status', 'created_at', 'updated_at'
    ];

    public function validate($inputs, $id = null){
        $rules['title'] = 'required';
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

    public function getCardType($search = null, $skip, $perPage) {
        $take = ((int)$perPage > 0) ? $perPage : 20;
        $filter = 1; // default filter if no search

        $fields = [
            'id',
            'status',
            'name',
        ];

        $sortBy = [
            'title' => 'title',
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

            $f3 = (array_key_exists('status', $search)) ? " AND (status = '" .
                addslashes($search['status']) . "')" : "";


            $filter .= $f1 . $f3;
        }

        return $this->whereRaw($filter)
                ->orderBy($orderEntity, $orderAction)
                ->skip($skip)->take($take)
                ->get($fields);
    }

  
    public function totalCardType($search = null)  {
         $filter = 1; // if no search add where

        if(isset($search['status'])){
            if($search['status'] == 102){
                unset($search['status']);
                $search['status'] = 0;
            }
        }

        if (is_array($search) && count($search) > 0) {
            $f1 = (array_key_exists('name', $search)) ? " AND (name Like '%" .
                addslashes($search['name']) . "%')" : "";

            $f3 = (array_key_exists('status', $search)) ? " AND (status = '" .
                addslashes($search['status']) . "')" : "";


            $filter .= $f1 . $f3;
        }
         return $this->select(\DB::raw('count(*) as total'))
             ->whereRaw($filter)->first();
     }

    public function tempDelete($id)
    {
        $this->find($id)->update([ 'deleted_by' => authUserId(), 'deleted_at' => convertToUtc()]);
    }


}
