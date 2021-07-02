<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\services\PayUservice\Exception;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WorkersExport;
use App\Imports\WorkersImport;
use App\Worker;
use Input;
use PDF;


class workerController extends Controller
{

    public function index()
    {
        return view('workers.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request, Worker $worker)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'city' => 'required',
            'contact' => 'required',
            'department' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $worker->storeData($request->all());

        return response()->json(['success'=>'Worker added successfully']);

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $worker = new Worker;
        $data = $worker->findData($id);

        $html = '<div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="editName" value="'.$data->name.'">
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control" name="city" id="editCity" value="'.$data->city.'">
                </div>
                <div class="form-group">
                    <label for="contact">Contact</label>
                    <input type="text" class="form-control" name="contact" id="editContact" value="'.$data->contact.'">
                </div>
                <div class="form-group">
                    <label for="department">Department</label>
                    <input type="text" class="form-control" name="department" id="editDepartment" value="'.$data->department.'">
                </div>';

        return response()->json(['html'=>$html]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'city' => 'required',
            'contact' => 'required',
            'department' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $worker = new Worker;
        $worker->updateData($id, $request->all());

        return response()->json(['success'=>'Worker updated successfully']);

    }

    public function destroy($id)
    {
        $worker = new Worker;
        $worker->deleteData($id);

        return response()->json(['success'=>'Worker deleted successfully']);

    }

    public function getWorkers(Request $request, Worker $worker)
    {
        $data = $worker->getData();

        return DataTables::of($data)
            ->addColumn('Actions', function($data) {
                return '<button type="button" class="btn btn-success btn-sm" id="getEditWorkerData" data-id="'.$data->id.'">Edit</button>
                    <button type="button" data-id="'.$data->id.'" data-toggle="modal" data-target="#DeleteWorkerModal" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>';
            })
            ->rawColumns(['Actions'])
            ->make(true);

    }

    public function export(Request $request)
    {
        return Excel::download(new WorkersExport, 'workers.xlsx');
    }

    public function import(Request $request)
    {
        // dd(request()->file('file'));
        Excel::import(new WorkersImport,request()->file('file'));

        return back();
    }

    public function exportPDF(Request $request)
	{
	    return Excel::download(new WorkersExport, 'workers.pdf');
	}

    // public function generatePDF()
    // {
    //     $data = ['title' => 'workers_list'];
    //     $pdf = PDF::loadView('workers/index', $data);

    //     return $pdf->download('workers_list.pdf');
    // }

}
