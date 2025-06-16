<?php

namespace App\Http\Controllers\Api;


use App\Models\Items;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ItemsRequest;
use Illuminate\Support\Facades\Storage;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Return all the data from the items table
        return Items::all();
    }

  

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemsRequest $request)
    {
        
        $validated = $request->validated();
        
         // Attach the logged-in user's ID/relationship with the user
        $validated['image_path'] =  $request->file('image_path')->storePublicly('item', 'public');

        $validated['user_id'] = $request->user()->id;

        $item = Items::create($validated);
        return $item;


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return Items::findOrFail($id);
        
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemsRequest $request, string $id)
    {
        
        $validated = $request->validated();
        $item = Items::findOrFail($id);

        
      if ($request->hasFile('image_path')) {

        // Delete old image if exists
        if (!is_null($item->image_path)) {
            Storage::disk('public')->delete($item->image_path);
        }

        // Store new image
        $item->image_path = $request->file('image_path')->store('item', 'public');
    }

        $item->update($validated);


         $item->save();

        $response = [   $item,
                        'message' => 'Succesfully Updated Item',];

        return $response;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Items::findOrFail($id);
        $item -> delete();

        $response = ['message' => 'Succesfully Deleted Item'];

        return [response()->json($response),  $item];
    }
}


