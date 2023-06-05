<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class LeadCase extends Model {
	
    protected $fillable = [ 'lead_id', 'user_id', 'reason_for_follow_up', 'note', 'date', 'time', 'created_at', 'updated_at' ];

    public function store($inputs, $id = null)  {
        if ($id) {
            return $this->find($id)->update($inputs);
        } else {
            return $this->create($inputs)->id;
        }
    }


}

 