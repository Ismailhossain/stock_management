<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    public function create(){

        $suppliers = Supplier::get();

        return view('item.create', [
            'suppliers' => $suppliers,
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255|unique:items',
        ]);
        // Begin Transaction
        DB::beginTransaction();

        try {
            $item = new Item();
            $item->name = $request->name;
            $item->description = $request->description;
            $item->supplier_id = $request->supplier_id;
            $item->save();

            // Commit Transaction
            DB::commit();

            return redirect()->route('item-show')->with('success', "Item successfully created.");

        } catch (\Illuminate\Database\QueryException $e) {

            // Rollback Transaction
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error($errorMessage);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show(){

        return view('item.show');
    }


    public function getItemList(Request $request){
        if (!$request->ajax()) {
            abort(404);
        }
        $items = Item::with('supplier')->get();

        return DataTables::of($items)
            ->addIndexColumn()
            ->addColumn('action',function ($item){
                return '<form method="post" id="verifyForm-'.$item->id.'" action="' . route('item-delete', $item->id) .'">
                                       '.csrf_field().'
                                        <input type="hidden" name="_method" value="put">
                            </form>
                            <a href="' . route('item-edit', $item->id) .'" class="btn btn-primary btn-sm" role="button">Edit</a>
                            <a href="#0" class="btn btn-danger btn-sm" onclick="verify('.$item->id.')"  role="button">Delete</a>';
            })
            ->editcolumn('status',function ($item){
                if ($item->status == 1) return '<span href="#0" id="ActiveInactive" statusCode="'.$item->status.'" data_id="'.$item->id.'" tableName="items" class="badge badge-success cursor-pointer" role="button">Active</span>';
                return '<span href="#0" id="ActiveInactive" statusCode="'.$item->status.'" data_id="'.$item->id.'" tableName="items" class="badge badge-danger cursor-pointer" role="button">Inactive</span>';
            })
            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function edit(Request $request,$id){
        $item = Item::findOrFail($id);
        $suppliers = Supplier::get();

        return view('item.edit', [
            'item' => $item,
            'suppliers' => $suppliers,

        ]);
    }

    public function update(Request $request,$id,Item $item){

        $request->validate([
            'name' => 'required|string|max:255|unique:items,name,'.$id,
        ]);

        // Begin Transaction
        DB::beginTransaction();

        try {
            $item = Item::findOrFail($id);
            $item->name = $request->name;
            $item->description = $request->description;
            $item->supplier_id = $request->supplier_id;
            $item->updated_at = Carbon::now();
            $item->save();

            // Commit Transaction
            DB::commit();

            return redirect()->route('item-show')->with('success', "Item successfully updated.");

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

            $item = Item::findOrFail($id);
            $item->delete();

            // Commit Transaction
            DB::commit();

            return redirect()->route('item-show')->with('success', "Item successfully deleted.");

        } catch (\Illuminate\Database\QueryException $e) {

            // Rollback Transaction
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error($errorMessage);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
