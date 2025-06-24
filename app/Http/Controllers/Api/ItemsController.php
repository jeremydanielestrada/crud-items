<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\UserRequest;
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
    public function index(Request $request)
    {
        $query = Items::query();

      if ($request->has('q')) {
        $search = $request->input('q');
        $query->where('item_name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
              }

         return $query->get();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemsRequest $request)
    {
        try {
        $validated = $request->validated();

        $validated['image_path'] = $request->file('image_path')->storePublicly('item', 'public');
        $validated['user_id'] = $request->user()->id;

        $item = Items::create($validated);

        return response()->json($item, 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $e->errors(),
        ], 422);
    }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Items::findOrFail($id);
        
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemsRequest $request, string $id)
{
    $validated = $request->validated();
    $item = Items::findOrFail($id);

    // If new image is uploaded
    if ($request->hasFile('image_path')) {
        // Delete old image
        if (!is_null($item->image_path)) {
            Storage::disk('public')->delete($item->image_path);
        }

        // Store new image and update in validated data
        $validated['image_path'] = $request->file('image_path')->store('item', 'public');
    }

             // Update item with all validated data (including new image_path if applicable)
             $item->update($validated);

    return response([
        'item' => $item,
        'message' => 'Successfully Updated Item',
    ], 200);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try{
        $item = Items::findOrFail($id);

        $item -> delete();

        $response = ['message' => 'Succesfully Deleted Item'];

        return [response()->json($response),  $item];

        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
            'message' => 'Validation failed',

            'errors' => $e->errors(),
            
        ], 422);
        }
      
    }
}


