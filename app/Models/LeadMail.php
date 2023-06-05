<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class LeadMail extends Model {
	
    protected $fillable = [ 'to_mail_id', 'mail_to', 'subject', 'mail', 'send_by', 'created_at', 'updated_at' ];

    public function store($inputs, $id = null)  {
        if ($id) {
            return $this->find($id)->update($inputs);
        } else {
            return $this->create($inputs)->id;
        }
    }

}




 