<?php

namespace App\Http\Controllers;
/**
 * :: Form Controller ::
 * 
 *
 **/
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Files;
use Illuminate\Support\Facades\Storage;
use App\Models\Form;
use App\Models\Bank;
use App\Models\BankField;
use Illuminate\Http\Request;

class FormController extends  Controller{

    public function index() {
        return view('admin.form.index');
    }
  
    public function create() {
        return view('admin.form.create');
    }

    public function store(Request $request) {
        $inputs = $request->all();
       // dd($request);
        try {

            (new Form)->store($inputs);
            return redirect()->route('forms.index')
                ->with('success', 'Form successfully created');
        } catch (\Exception $exception) {
            return redirect()->route('forms.create')
                ->withInput()
                ->with('error', lang('messages.server_error').$exception->getMessage());
        }
    }

  
    public function update(Request $request, $id = null) {
        $result = (new Form)->find($id);
        if (!$result) {
            abort(401);
        }
        $inputs = $request->all();
        try {

             
            $count = BankField::where('field_id', $request->field_id)->count();
            if($count != 0){
                \DB::table('bank_fields')->where('field_id', $request->field_id)->delete();
            }
             
            if(isset($request->bank)){
                foreach($request->bank as $bank_id){
                    $apply_ser = BankField::where('bank_id', $bank_id)->where('field_id', $request->field_id)->count();
                    if($apply_ser == 0) {
                        BankField::create([
                            'field_id'  =>  $request->field_id,
                            'bank_id'  => $bank_id,
                            // 'created_by'  => \Auth::user()->user_type,
                        ]);
                    }
                }
            }


            return redirect()->route('forms.index')
                ->with('success', 'Field successfully updated');
        } catch (\Exception $exception) {
          //  dd($exception);                                                                   
            return redirect()->route('forms.edit', [$id])
                ->withInput()->with('error', lang('messages.server_error'));
        }
    }
  
    public function edit($id = null) {
        $result = (new Form)->find($id);
        if (!$result) {
            abort(401);
        }
        $banks = Bank::where('status', 1)->select('name', 'id')->get();
        $service_id = BankField::where('field_id', $id)->pluck('bank_id')->toArray();

        return view('admin.form.create', compact('result', 'banks', 'service_id'));
    }


    public function Paginate(Request $request, $pageNumber = null) {

        if (!\Request::isMethod('post') && !\Request::ajax()) { //
            return lang('messages.server_error');
        }

        $inputs = $request->all();
        $page = 1;
        if (isset($inputs['page']) && (int)$inputs['page'] > 0) {
            $page = $inputs['page'];
        }

        $perPage = 20;
        if (isset($inputs['perpage']) && (int)$inputs['perpage'] > 0) {
            $perPage = $inputs['perpage'];
        }

       // dd('test');
        $start = ($page - 1) * $perPage;
        if (isset($inputs['form-search']) && $inputs['form-search'] != '') {
            $inputs = array_filter($inputs);
            unset($inputs['_token']);
            $data = (new Form)->getForms($inputs, $start, $perPage);
            $totalGameMaster = (new Form)->totalForms($inputs);
            $total = $totalGameMaster->total;
            // dd($data);
        } else {
            $data = (new Form)->getForms($inputs, $start, $perPage);
            $totalGameMaster = (new Form)->totalForms();
            $total = $totalGameMaster->total;
        }

        return view('admin.form.load_data', compact('inputs', 'data', 'total', 'page', 'perPage'));
    }

 
    public function Toggle($id = null) {
        if (!\Request::isMethod('post') && !\Request::ajax()) {
            return lang('messages.server_error');
        }
        try {
            $game = CardType::find($id);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('Card Type')));
        }

        $game->update(['status' => !$game->status]);
        $response = ['status' => 1, 'data' => (int)$game->status . '.gif'];
        // return json response
        return json_encode($response);
    }
  
    public function Action(Request $request)  {
        $inputs = $request->all();
        if (!isset($inputs['tick']) || count($inputs['tick']) < 1) {
            return redirect()->route('card-type.index')
                ->with('error', lang('messages.atleast_one', string_manip(lang('Card Type'))));
        }
        $ids = '';
        foreach ($inputs['tick'] as $key => $value) {
            $ids .= $value . ',';
        }
        $ids = rtrim($ids, ',');
        $status = 0;
        if (isset($inputs['active'])) {
            $status = 1;
        }
        CardType::whereRaw('id IN (' . $ids . ')')->update(['status' => $status]);
        return redirect()->route('card-type.index')
            ->with('success', lang('messages.updated', lang('Card Type')));
    }


    public function drop($id) {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }
        $result = (new CardType)->find($id);
        if (!$result) {
            abort(401);
        }
        try {
            $result = (new CardType)->find($id);
            (new CardType)->tempDelete($id);
            $response = ['status' => 1, 'message' => lang('messages.deleted', lang('Card Type'))];
        } catch (Exception $exception) {
            $response = ['status' => 0, 'message' => lang('messages.server_error')];
        }        
        return json_encode($response);
    }

}
