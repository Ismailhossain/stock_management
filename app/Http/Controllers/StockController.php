<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class StockController extends Controller
{
    public function create(){

        $items = Item::get();

        return view('stock.create', [
            'items' => $items,
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'item_id' => 'required',
            'price' => 'required',
            'qty' => 'required',
        ]);
        // Begin Transaction
        DB::beginTransaction();

        try {
            $stock = new Stock();
            $stock->item_id = $request->item_id;
            $stock->price = $request->price;
            $stock->qty = $request->qty;
            $stock->save();

            // Commit Transaction
            DB::commit();

            return redirect()->route('stock-show')->with('success', "Stock successfully created.");

        } catch (\Illuminate\Database\QueryException $e) {

            // Rollback Transaction
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error($errorMessage);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show(){

        return view('stock.show');
    }


    public function getStockList(Request $request){
        if (!$request->ajax()) {
            abort(404);
        }
        $stocks = Stock::with('item')->get();

        return DataTables::of($stocks)
            ->addIndexColumn()
            ->addColumn('action',function ($stock){
                if(auth()->user()->type == 'admin')    return '<form method="post" id="verifyForm-'.$stock->id.'" action="' . route('stock-delete', $stock->id) .'">
                                       '.csrf_field().'
                                        <input type="hidden" name="_method" value="put">
                            </form>
                            <a href="' . route('stock-edit', $stock->id) .'" class="btn btn-primary btn-sm" role="button">Edit</a>
                            <a href="#0" class="btn btn-danger btn-sm" onclick="verify('.$stock->id.')"  role="button">Delete</a>';
                if(auth()->user()->type == 'store_executive')
                    return '<a href="' . route('stock-edit', $stock->id) .'" class="btn btn-primary btn-sm" role="button">Edit</a>';
                return '<span class="badge badge-danger">N/A</span>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function edit(Request $request,$id){
        $stock = Stock::findOrFail($id);
        $items = Item::get();

        return view('stock.edit', [
            'stock' => $stock,
            'items' => $items,

        ]);
    }

    public function update(Request $request,$id,Stock $stock){

        $request->validate([
            'item_id' => 'required',
            'price' => 'required',
            'qty' => 'required'
        ]);

        // Begin Transaction
        DB::beginTransaction();

        try {
            $stock = Stock::findOrFail($id);
            $stock->item_id = $request->item_id;
            $stock->price = $request->price;
            $stock->qty = $request->qty;
            $stock->updated_at = Carbon::now();
            $stock->save();

            // Commit Transaction
            DB::commit();

            return redirect()->route('stock-show')->with('success', "Stock successfully updated.");

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

            $stock = Stock::findOrFail($id);
            $stock->delete();

            // Commit Transaction
            DB::commit();

            return redirect()->route('stock-show')->with('success', "Stock successfully deleted.");

        } catch (\Illuminate\Database\QueryException $e) {

            // Rollback Transaction
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error($errorMessage);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
