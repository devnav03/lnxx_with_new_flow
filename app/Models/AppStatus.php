<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppStatus extends Model {

    protected $table = 'app_status';
   
    protected $fillable = [
        'app_id', 'status_id', 'comment', 'created_at', 'updated_at', 'updated_by'
    ];

    public function validate($inputs, $id = null){
        $rules['status_id'] = 'required';
        $rules['app_id'] = 'required';
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

}
