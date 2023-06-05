<?php

namespace App\Http\Controllers;
/**
 * 
 * 
 *
 **/
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Files;
use Illuminate\Support\Facades\Storage;
use App\Models\ApplicationStatus;
use Illuminate\Http\Request;

class ApplicationStatusController extends  Controller{

    public function index() {
        return view('admin.application_status.index');
    }
  
    public function create() {
        return view('admin.application_status.create');
    }

    public function  store(Request $request) {
        $inputs = $request->all();
       // dd($request);
        try {

            $validator = (new ApplicationStatus)->validate($inputs);
            if( $validator->fails() ) {
                return back()->withErrors($validator)->withInput();
            }

            $id = (new ApplicationStatus)->store($inputs);

            return redirect()->route('application-status.index')
                ->with('success', 'Application status successfully created');
        } catch (\Exception $exception) {
            return redirect()->route('application-status.create')
                ->withInput()
                ->with('error', lang('messages.server_error').$exception->getMessage());
        }
    }

  
    public function update(Request $request, $id = null) {
        $result = (new ApplicationStatus)->find($id);
        if (!$result) {
            abort(401);
        }
        $inputs = $request->all();
        try {

            (new ApplicationStatus)->store($inputs, $id);

            return redirect()->route('application-status.index')
                ->with('success', 'Application status successfully updated');

        } catch (\Exception $exception) {
            return redirect()->route('application-status.edit', [$id])
                ->withInput()
                ->with('error', lang('messages.server_error'));
        }
    }
  
    public function edit($id = null) {
        $result = (new ApplicationStatus)->find($id);
        if (!$result) {
            abort(401);
        }
        return view('admin.application_status.create', compact('result'));
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
            $data = (new ApplicationStatus)->getLeadSource($inputs, $start, $perPage);
            $totalGameMaster = (new ApplicationStatus)->totalLeadSource($inputs);
            $total = $totalGameMaster->total;
            // dd($data);
        } else {
            $data = (new ApplicationStatus)->getLeadSource($inputs, $start, $perPage);
            $totalGameMaster = (new ApplicationStatus)->totalLeadSource();
            $total = $totalGameMaster->total;
        }

       // dd($data);

        return view('admin.application_status.load_data', compact('inputs', 'data', 'total', 'page', 'perPage'));
    }

 
    public function lead_sourceToggle($id = null) {
        if (!\Request::isMethod('post') && !\Request::ajax()) {
            return lang('messages.server_error');
        }
        try {
            $game = ApplicationStatus::find($id);
        } catch (\Exception $exception) {
            return lang('messages.invalid_id', string_manip(lang('Application Status')));
        }

        $game->update(['status' => !$game->status]);
        $response = ['status' => 1, 'data' => (int)$game->status . '.gif'];
        // return json response
        return json_encode($response);
    }

  
    public function lead_sourceAction(Request $request)  {

        $inputs = $request->all();
        if (!isset($inputs['tick']) || count($inputs['tick']) < 1) {
            return redirect()->route('application-status.index')
                ->with('error', lang('messages.atleast_one', string_manip(lang('Application Status'))));
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

        ApplicationStatus::whereRaw('id IN (' . $ids . ')')->update(['status' => $status]);
        return redirect()->route('application-status.index')
            ->with('success', lang('messages.updated', lang('Lead Source')));
    }


    public function drop($id) {
        if (!\Request::ajax()) {
            return lang('messages.server_error');
        }
        $result = (new ApplicationStatus)->find($id);
        if (!$result) {
            // use ajax return response not abort because ajaz request abort not works
            abort(401);
        }
        try {
            // get the unit w.r.t id
            $result = (new ApplicationStatus)->find($id);
            // if($result->status == 1) {
            //     $response = ['status' => 0, 'message' => lang('category.category_in_use')];
            // }
            //  else {
                (new ApplicationStatus)->tempDelete($id);
                $response = ['status' => 1, 'message' => lang('messages.deleted', lang('Application Status'))];
             // }
        }
        catch (Exception $exception) {
            $response = ['status' => 0, 'message' => lang('messages.server_error')];
        }        
        // return json response
        return json_encode($response);
    }
    

}
