<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;
    protected $table = 'blogs';
   
    protected $fillable = [
        'title', 'content', 'category', 'short_description', 'image', 'url', 'status', 'created_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function validate($inputs, $id = null){
        $rules['title']  = 'required';
        $rules['content'] = 'required';
        $rules['image'] = 'mimes:jpeg,jpg,png,gif|required|max:10000';
        return \Validator::make($inputs, $rules);
    }

    public function store($inputs, $id = null) {
        if ($id) {
            return $this->find($id)->update($inputs);
        } else {
            return $this->create($inputs)->id;
        }
    }


    public function getBlogs($search = null, $skip, $perPage) {
        $take = ((int)$perPage > 0) ? $perPage : 20;
        $filter = 1; // default filter if no search

        $fields = [
            'blogs.id',
            'blogs.title',
            'blogs.status',
            'blogs.content',
            'blogs.created_at',
            'users.name',
            'users.middle_name',
            'users.last_name',
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

        if(isset($search['from'])){
            $search['from'] = date('Y-m-d H:i:s', strtotime($search['from']));
        }

        if(isset($search['to'])){
            $search['to'] = date('Y-m-d H:i:s', strtotime($search['to']));
            $search['to'] = date('Y-m-d H:i:s', strtotime($search['to'] . ' +1 day'));
        }
             
        if (is_array($search) && count($search) > 0) {
            $f1 = (array_key_exists('title', $search)) ? " AND (blogs.title Like '%" .
                addslashes($search['title']) . "%')" : "";

            $f3 = (array_key_exists('status', $search)) ? " AND (blogs.status = '" .
                addslashes($search['status']) . "')" : "";

            $f4 = (array_key_exists('name', $search)) ? " AND (users.name LIKE '%" .
                addslashes(trim($search['name'])) . "%')" : "";  

            $f5 = (array_key_exists('from', $search)) ? " AND (blogs.created_at >= '" .
                addslashes($search['from']) . "')" : "";  

            $f6 =  (array_key_exists('to', $search)) ? " AND (blogs.created_at <= '" .
                addslashes($search['to']) . "')" : ""; 

            $filter .= $f1 . $f3 . $f4 . $f5 . $f6;
        }

        return $this->leftjoin('users', 'users.id', '=', 'blogs.created_by')
            ->whereRaw($filter)
            ->orderBy($orderEntity, $orderAction)
            ->skip($skip)->take($take)
            ->get($fields);
    }

  
    public function totalBlogs($search = null)
    {
         $filter = 1; // if no search add where

         // when search
         if (is_array($search) && count($search) > 0) {
             $partyName = (array_key_exists('keyword', $search)) ? " AND title LIKE '%" .
                 addslashes(trim($search['keyword'])) . "%' " : "";
             $filter .= $partyName;
         }
         return $this->select(\DB::raw('count(*) as total'))
             ->whereRaw($filter)->first();
     }

    public function tempDelete($id)
    {
        $this->find($id)->update([ 'deleted_by' => authUserId(), 'deleted_at' => convertToUtc()]);
    }


}
