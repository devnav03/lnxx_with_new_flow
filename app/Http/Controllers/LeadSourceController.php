<?php

namespace App\Http\Controllers;
/**
 * :: Bank Controller ::
 * 
 *
 **/
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Files;
use Illuminate\Support\Facades\Storage;
use App\Models\LeadSource;
use Illuminate\Http\Request;

class LeadSourceController extends  Controller{

    public function index() {
        return view('admin.lead_source.index');
    }
  
    public function create() {
        return view('admin.lead_source.create');
    }

    public function  store(Request $request) {
        $inputs = $request->all();
       // dd($request);
        try {

            $validator = (new LeadSource)->validate($inputs);
            if( $validator->fails() ) {
                return back()->withErrors($validator)->withInput();
            }

            $id = (new LeadSource)->store($inputs);

            return redirect()->route('lead-source.index')
                ->with('success', 'Lead Source successfully created');
        } catch (\Exception $exception) {
            return redirect()->route('lead-source.create')
                ->withInput()
                ->with('error', lang('messages.server_error').$exception->getMessage());
        }
    }

  
    public function update(Request $request, $id = null) {
        $result = (new LeadSource)->find($id);
        if (!$result) {
            abort(401);
        }
        $inputs = $request->all();
        try {

            (new LeadSource)->store($inputs, $id);

            return redirect()->route('lead-source.index')
                ->with('success', 'Lead source successfully updated');

        } catch (\Exception $exception) {
            return redirect()->route('lead-source.edit', [$id])
                ->withInput()
                ->with('error', lang('messages.server_error'));
        }
    }
  
    public function edit($id = null) {
        $result = (new LeadSource)->find($id);
        if (!$result) {
            abort(401);
        }
        return view('admin.lead_source.create', compact('result'));
    }


    public function lead_sourcePaginate(Request $request, $pageNumber = null) {
        // dd($request);

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
            $data = (new LeadSource)->getLeadSource($inputs, $start, $perPage);
            $totalGameMaster = (new LeadLeadSource)->totalLeadSource($inputs);
            $total = $totalGameMaster->total;
            // dd($data);
        } else {
            $data = (new LeadSource)->getLeadSource($inputs, $start, $perPage);
            $totalGameMaster = (new LeadSource)->totalLeadSource();
            $total = $totalGameMaster->total;
        }

       // dd($data);

        return view('admin.lead_source.load_data', compact('inputs', 'data', 'total', 'page', 'perPage'));
    }

 
    public function lead_sourceToggle($id = null) {
        if (!\Request::isMethod('post') && !\Request::ajax()) {
            return lang('messages.server_error');
        }
        try {
            $game = LeadSource::find($id);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('Lead Source')));
        }

        $game->update(['status' => !$game->status]);
        $response = ['status' => 1, 'data' => (int)$game->status . '.gif'];
        // return json response
        return json_encode($response);
    }

  
    public function lead_sourceAction(Request $request)  {

        $inputs = $request->all();
        if (!isset($inputs['tick']) || count($inputs['tick']) < 1) {
            return redirect()->route('lead-source.index')
                ->with('error', lang('messages.atleast_one', string_manip(lang('Lead Source'))));
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

        LeadSource::whereRaw('id IN (' . $ids . ')')->update(['status' => $status]);
        return redirect()->route('lead-source.index')
            ->with('success', lang('messages.updated', lang('Lead Source')));
    }


    public function drop($id) {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }
        $result = (new LeadSource)->find($id);
        if (!$result) {
            // use ajax return response not abort because ajaz request abort not works
            abort(401);
        }
        try {
            // get the unit w.r.t id
            $result = (new LeadSource)->find($id);
            // if($result->status == 1) {
            //     $response = ['status' => 0, 'message' => lang('category.category_in_use')];
            // }
            //  else {
                (new LeadSource)->tempDelete($id);
                $response = ['status' => 1, 'message' => lang('messages.deleted', lang('LeadSource'))];
             // }
        }
        catch (Exception $exception) {
            $response = ['status' => 0, 'message' => lang('messages.server_error')];
        }        
        // return json response
        return json_encode($response);
    }
    

}
