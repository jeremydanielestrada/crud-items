<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\InventoryRequest;
use App\Models\Inventory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inventory::All();
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(InventoryRequest $request)
    {
           $validated = $request->validated();

           $validated["user_id"] = $request->user()->id;
           $validated["item_id"] = $request->item_id;


          $inventory = Inventory::create($validated);

          return $inventory;
        
    }

    

   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
