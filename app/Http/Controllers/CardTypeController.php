<?php

namespace App\Http\Controllers;
/**
 * :: CardType Controller ::
 * 
 *
**/
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Files;
use Illuminate\Support\Facades\Storage;
use App\Models\CardType;
use App\Models\CardTypeBank;
use App\Models\Bank;
use Illuminate\Http\Request;

class CardTypeController extends  Controller{

    public function index() {
        return view('admin.card_type.index');
    }
  
    public function create() {
        $banks =  Bank::where('status', 1)->select('id', 'name')->get();
        return view('admin.card_type.create', compact('banks'));
    }

    public function store(Request $request) {
        $inputs = $request->all();
       // dd($request);
        try {

            if(isset($inputs['image']) or !empty($inputs['image'])) {
                $image_name = rand(100000, 999999);
                $fileName = '';
                if($file = $request->hasFile('image')) {
                    $file = $request->file('image') ;
                    $img_name = $file->getClientOriginalName();
                    $fileName = $image_name.$img_name;
                    $destinationPath = public_path().'/uploads/card_type/' ;
                    $file->move($destinationPath, $fileName);
                }
                $fname ='/uploads/card_type/';
                $image = $fname.$fileName;
            }  else{
                $image = '';
            }
            
            unset($inputs['image']);
            $inputs['image'] = $image;

            $id = (new CardType)->store($inputs);

            if(isset($request->bank)){
                foreach($request->bank as $bank_id){
                    $apply_ser = CardTypeBank::where('bank_id', $bank_id)->where('card_type_id', $id)->count();
                    if($apply_ser == 0) {
                        CardTypeBank::create([
                            'bank_id'  =>  $bank_id,
                            'card_type_id'  => $id,
                        ]);
                    }
                }
            }

            return redirect()->route('card-type.index')
                ->with('success', 'Card type successfully created');
        } catch (\Exception $exception) {
            return redirect()->route('card-type.create')
                ->withInput()
                ->with('error', lang('messages.server_error').$exception->getMessage());
        }
    }

  
    public function update(Request $request, $id = null) {
        $result = (new CardType)->find($id);
        if (!$result) {
            abort(401);
        }
        $inputs = $request->all();
        try {

            if(isset($inputs['image']) or !empty($inputs['image'])) {
                $image_name = rand(100000, 999999);
                $fileName = '';
                if($file = $request->hasFile('image')) {
                    $file = $request->file('image') ;
                    $img_name = $file->getClientOriginalName();
                    $fileName = $image_name.$img_name;
                    $destinationPath = public_path().'/uploads/card_type/' ;
                    $file->move($destinationPath, $fileName);
                }
                $fname ='/uploads/card_type/';
                $image = $fname.$fileName;
            }  else{
                $image = $result->image;
            }
            
            unset($inputs['image']);
            $inputs['image'] = $image;

            (new CardType)->store($inputs, $id);

            $count = CardTypeBank::where('card_type_id', $id)->count();
            if($count != 0){
                \DB::table('card_type_banks')->where('card_type_id', $id)->delete();
            }

            if(isset($request->bank)){
                foreach($request->bank as $bank_id){
                    $apply_ser = CardTypeBank::where('bank_id', $bank_id)->where('card_type_id', $id)->count();
                    if($apply_ser == 0) {
                        CardTypeBank::create([
                            'bank_id'  =>  $bank_id,
                            'card_type_id'  => $id,
                        ]);
                    }
                }
            }

            return redirect()->route('card-type.index')
                ->with('success', 'Card type successfully updated');
        } catch (\Exception $exception) {
           // dd($exception);                                                                             
            return redirect()->route('card-type.edit', [$id])
                ->withInput()->with('error', lang('messages.server_error'));
        }
    }
  
    public function edit($id = null) {
        $result = (new CardType)->find($id);
        if (!$result) {
            abort(401);
        }
        $banks =  Bank::where('status', 1)->select('id', 'name')->get();
        $bank_id = CardTypeBank::where('card_type_id', $id)->pluck('bank_id')->toArray();
        return view('admin.card_type.create', compact('result', 'banks', 'bank_id'));
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
            $data = (new CardType)->getCardType($inputs, $start, $perPage);
            $totalGameMaster = (new CardType)->totalCardType($inputs);
            $total = $totalGameMaster->total;
            // dd($data);
        } else {
            $data = (new CardType)->getCardType($inputs, $start, $perPage);
            $totalGameMaster = (new CardType)->totalCardType();
            $total = $totalGameMaster->total;
        }

        return view('admin.card_type.load_data', compact('inputs', 'data', 'total', 'page', 'perPage'));
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
