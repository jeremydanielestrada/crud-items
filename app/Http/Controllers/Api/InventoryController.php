<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\InventoryRequest;
use App\Models\Inventory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Items;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return Inventory::with(['item', 'user'])->get();
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(InventoryRequest $request,$id)
    {
           $validated = $request->validated();

           $validated['item_id'] = $id;

           $validated["user_id"] = $request->user()->id;

          $inventory = Inventory::create($validated);

          if (!Items::where('item_id', $id)->exists()) {
                return response()->json(['message' => 'Invalid item ID'], 422);
          }

          return $inventory;
        
    }


   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $invItem = Inventory::findOrFail($id);

         $invItem -> delete();

         $response = ['message' => 'Succesfully Deleted Inventory Item'];


        return $response;

    }
}
