<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with('category')->latest()->get();
        return view('admin.item.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.item.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_url' => 'nullable|url|max:2048',
            'is_available' => 'boolean',
        ]);

        $validated['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('items', 'public');
        } elseif ($request->filled('image_url')) {
            $validated['image_path'] = $request->input('image_url');
        }

        Item::create($validated);

        return redirect()->route('items.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Item::with('category')->findOrFail($id);
        return view('admin.item.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all();
        return view('admin.item.edit', compact('item', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Item::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_url' => 'nullable|url|max:2048',
            'is_available' => 'boolean',
        ]);

        $validated['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            // Delete old stored file (not if it was a URL)
            if ($item->image_path && !str_starts_with($item->image_path, 'http')) {
                Storage::disk('public')->delete($item->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('items', 'public');
        } elseif ($request->filled('image_url')) {
            // Delete old stored file if switching to URL
            if ($item->image_path && !str_starts_with($item->image_path, 'http')) {
                Storage::disk('public')->delete($item->image_path);
            }
            $validated['image_path'] = $request->input('image_url');
        }

        $item->update($validated);

        return redirect()->route('items.index')->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);

        if ($item->image_path) {
            Storage::disk('public')->delete($item->image_path);
        }

        $item->delete();

        return redirect()->route('items.index')->with('success', 'Menu berhasil dihapus.');
    }
}
