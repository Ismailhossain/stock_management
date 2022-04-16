<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Requisition;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class RequisitionController extends Controller
{
    public function create(){

        $items = Item::get();

        return view('requisition.create', [
            'items' => $items,
        ]);
    }

    public function store(Request $request){
//        dd($request);
        $request->validate([
            'name' => 'required|string|max:255|unique:requisitions',
        ]);
        // Begin Transaction
        DB::beginTransaction();

        try {
            $requisition = new Requisition();
            $requisition->name = $request->name;
            if(!empty($request['store_item_id'])){
                $arr =[];
                foreach ($request['store_item_id'] as $key => $value)
                {
                    $data['item_id'] = $request['store_item_id'][$key];
                    $data['item_name'] = $request['store_item_name'][$key];
                    $data['qty'] = $request['store_qty'][$key];
                    array_push($arr,$data);
                }
                $request['item_qty'] = json_encode($arr);
            }else{
                $request['item_qty'] = null;
            }
            $requisition->item_qty = $request->item_qty;
            $requisition->save();

            // Commit Transaction
            DB::commit();

            return redirect()->route('requisition-show')->with('success', "Requisition successfully created.");

        } catch (\Illuminate\Database\QueryException $e) {

            // Rollback Transaction
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error($errorMessage);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show(){
        $requisitions = Requisition::get();
        foreach ($requisitions as $requisition){
            $requisition->item_qty = json_decode($requisition->item_qty,true);
        }
        return view('requisition.show', [
            'requisitions' => $requisitions,
        ]);
    }

    public function edit(Request $request,$id){
        $requisition = Requisition::findOrFail($id);
        $items = Item::get();
        return view('requisition.edit', [
            'requisition' => $requisition,
            'items' => $items,
        ]);
    }

    public function update(Request $request,$id,Requisition $requisition){

        $request->validate([
            'name' => 'required|string|max:255|unique:requisitions,name,'.$id,
        ]);

        // Begin Transaction
        DB::beginTransaction();

        try {
            $requisition = Requisition::findOrFail($id);
            $requisition->name = $request->name;
            if(!empty($request['store_item_id'])){
                $arr =[];
                foreach ($request['store_item_id'] as $key => $value)
                {
                    $data['item_id'] = $request['store_item_id'][$key];
                    $data['item_name'] = $request['store_item_name'][$key];
                    $data['qty'] = $request['store_qty'][$key];
                    array_push($arr,$data);
                }
                $request['item_qty'] = json_encode($arr);
            }else{
                $request['item_qty'] = null;
            }
            $requisition->item_qty = $request->item_qty;
            $requisition->updated_at = Carbon::now();
            $requisition->save();

            // Commit Transaction
            DB::commit();

            return redirect()->route('requisition-show')->with('success', "Requisition successfully updated.");

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

            $requisition = Requisition::findOrFail($id);
            $requisition->delete();

            // Commit Transaction
            DB::commit();

            return redirect()->route('requisition-show')->with('success', "Requisition successfully deleted.");

        } catch (\Illuminate\Database\QueryException $e) {

            // Rollback Transaction
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error($errorMessage);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function getItemQtyByAjax(Request $request){
        $requisition =  Requisition::where([
            'id' => $request->id,
        ])->select('item_qty')->first();
        $details = json_decode($requisition->item_qty,  true);
        return response()->json(['success'=>true,'details'=>$details]);
    }

    public function statusUpdate(Request $request,$id){
        // Begin Transaction
        DB::beginTransaction();

        try {

            $requisition = Requisition::findOrFail($id);
            $requisition->status = $request->status_id;
            $requisition->updated_at = Carbon::now();
            $requisition->save();

            // Commit Transaction
            DB::commit();

            return redirect()->route('requisition-show')->with('success', "Requisition status successfully updated.");

        } catch (\Illuminate\Database\QueryException $e) {

            // Rollback Transaction
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error($errorMessage);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
