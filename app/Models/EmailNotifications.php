<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailNotifications extends Model {

    protected $table = 'email_notifications';
   
    protected $fillable = [
        'app_id', 'subject', 'email', 'message', 'attachment', 'created_at', 'updated_at', 'created_by'
    ];

    public function validate($inputs, $id = null){
        $rules['subject'] = 'required';
        $rules['app_id'] = 'required';
        $rules['email'] = 'required';
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
