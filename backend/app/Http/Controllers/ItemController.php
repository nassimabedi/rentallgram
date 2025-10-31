<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0.01',
            'location' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'nullable|in:available,rented,inactive',
            'image_url' => 'nullable|url',
        ]);


        $item = Item::create([
            'owner_id' => $request->user()->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price_per_day' => $validated['price_per_day'],
            'location' => $validated['location'],
        ]);

        return response()->json([
            'message' => 'Item created successfully',
            'item' => $item
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Fetch the item
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        // Check owner
        if ($request->user()->id !== $item->owner_id) {
            return response()->json(['error' => 'Access denied: owners only'], 403);
        }

        // Validate input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0.01',
            'location' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'nullable|in:available,rented,inactive',
            'image_url' => 'nullable|url',
        ]);

        // Update item
        $item->update($validated);

        return response()->json([
            'message' => 'Item updated successfully',
            'item' => $item
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        // Find the item
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        // Check ownership
        if ($request->user()->id !== $item->owner_id) {
            return response()->json(['error' => 'Access denied: owners only'], 403);
        }

        // Delete the item
        $item->delete();

        return response()->json([
            'message' => 'Item deleted successfully'
        ], 200);
    }

    public function show($id)
    {
        // Find the item
        $item = Item::with(['owner','category'])->find($id);

        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        return response()->json([
            'item' => $item
        ], 200);
    }

    public function index(Request $request)
    {
        // Optional: pagination
        $perPage = $request->query('per_page', 10);

        // Fetch all items with owner info
        //$items = Item::with('owner')->paginate($perPage);

        $items = Item::with(['owner','category'])
             ->where('status', 'available')
             ->paginate($perPage);


        return response()->json($items, 200);
    }

    
}

