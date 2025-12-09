<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Kategori standar untuk produk herbal.
     */
    private function categoryOptions(): array
    {
        return [
            'Jamu Tradisional',
            'Suplemen Alami',
            'Madu & Propolis',
            'Teh & Infus Herbal',
            'Minyak Atsiri',
            'Aromaterapi',
        ];
    }

    /**
     * Display a listing of the resource (Public).
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Dukungan multi-kategori
        $selectedCategories = collect((array) $request->input('categories', $request->input('category')))->filter()->values();
        if ($selectedCategories->isNotEmpty()) {
            $query->whereIn('category', $selectedCategories);
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        $sortApplied = false;

        // Best selling (join ke order_items + orders selesai)
        if ($sort === 'best_selling') {
            $salesSub = \DB::table('order_items')
                ->selectRaw('order_items.product_id, SUM(order_items.quantity) as total_sold')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.status', 'selesai')
                ->groupBy('order_items.product_id');

            $query->leftJoinSub($salesSub, 'sales', function ($join) {
                $join->on('products.id', '=', 'sales.product_id');
            })->select('products.*', \DB::raw('COALESCE(sales.total_sold, 0) as total_sold'))
              ->orderByDesc('total_sold');

            $sortApplied = true;
        } elseif ($sort === 'price_asc') {
            $query->orderBy('price', 'asc');
            $sortApplied = true;
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price', 'desc');
            $sortApplied = true;
        } elseif ($sort === 'rating' && \Schema::hasColumn('products', 'rating')) {
            $query->orderBy('rating', 'desc');
            $sortApplied = true;
        }

        if (!$sortApplied) {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        $categories = Product::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories,
            'selectedSort' => $sort,
        ]);
    }

    /**
     * Display a listing of the resource (Admin).
     */
    public function adminIndex()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryOptions();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $categories = $this->categoryOptions();
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => ['nullable','string','max:255', Rule::in($categories)],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'category' => $request->category,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = $this->categoryOptions();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $categories = $this->categoryOptions();
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => ['nullable','string','max:255', Rule::in($categories)],
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(), // Regenerate slug to match name if changed
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $product->image,
            'category' => $request->category,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
