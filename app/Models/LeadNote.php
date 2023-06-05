<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class LeadNote extends Model {
	
    protected $fillable = [ 'lead_id', 'user_id', 'title', 'note', 'created_at', 'updated_at' ];

    public function store($inputs, $id = null)  {
        if ($id) {
            return $this->find($id)->update($inputs);
        } else {
            return $this->create($inputs)->id;
        }
    }


}

 