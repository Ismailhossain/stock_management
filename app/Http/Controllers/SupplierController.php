<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function create(){
        return view('supplier.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|max:255|unique:suppliers',
        ]);
        // Begin Transaction
        DB::beginTransaction();

        try {
            $supplier = new Supplier();
            $supplier->name = $request->name;
            $supplier->phone = $request->phone;
            $supplier->email = $request->email;
            $supplier->address = $request->address;
            $supplier->save();

            // Commit Transaction
            DB::commit();

            return redirect()->route('supplier-show')->with('success', "Supplier successfully created.");

        } catch (\Illuminate\Database\QueryException $e) {

            // Rollback Transaction
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error($errorMessage);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show(){

        return view('supplier.show');
    }


    public function getSupplierList(Request $request){
        if (!$request->ajax()) {
            abort(404);
        }
        $suppliers = Supplier::get();

        return DataTables::of($suppliers)
            ->addIndexColumn()
            ->addColumn('action',function ($supplier){
                if(auth()->user()->type == 'admin')  return '<form method="post" id="verifyForm-'.$supplier->id.'" action="' . route('supplier-delete', $supplier->id) .'">
                                       '.csrf_field().'
                                        <input type="hidden" name="_method" value="put">
                            </form>
                            <a href="' . route('supplier-edit', $supplier->id) .'" class="btn btn-primary btn-sm" role="button">Edit</a>
                            <a href="#0" class="btn btn-danger btn-sm" onclick="verify('.$supplier->id.')"  role="button">Delete</a>';
                return '<span class="badge badge-danger">N/A</span>';
            })
            ->editcolumn('status',function ($supplier){
                if ($supplier->status == 1) return '<span href="#0" id="ActiveInactive" statusCode="'.$supplier->status.'" data_id="'.$supplier->id.'" tableName="suppliers" class="badge badge-success cursor-pointer" role="button">Active</span>';
                return '<span href="#0" id="ActiveInactive" statusCode="'.$supplier->status.'" data_id="'.$supplier->id.'" tableName="suppliers" class="badge badge-danger cursor-pointer" role="button">Inactive</span>';
            })
            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function edit(Request $request,$id){
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', [
            'supplier' => $supplier
        ]);
    }

    public function update(Request $request,$id,Supplier $supplier){

        $request->validate([
            'name' => 'required',
            'email' => 'required|string|max:255|unique:suppliers,email,'.$id,
        ]);

        // Begin Transaction
        DB::beginTransaction();

        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->name = $request->name;
            $supplier->phone = $request->phone;
            $supplier->email = $request->email;
            $supplier->address = $request->address;
            $supplier->updated_at = Carbon::now();
            $supplier->save();

            // Commit Transaction
            DB::commit();

            return redirect()->route('supplier-show')->with('success', "Supplier successfully updated.");

        } catch (\Illuminate\Database\QueryException $e) {

            // Rollback Transaction
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error($errorMessage);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function delete(Request $request,$id){

        // Begin Transaction
        DB::beginTransaction();

        try {

            $supplier = Supplier::findOrFail($id);
            $supplier->delete();

            // Commit Transaction
            DB::commit();

            return redirect()->route('supplier-show')->with('success', "Supplier successfully deleted.");

        } catch (\Illuminate\Database\QueryException $e) {

            // Rollback Transaction
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error($errorMessage);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
