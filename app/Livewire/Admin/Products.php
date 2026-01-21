<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    public $search = '';
    public $showForm = false;
    public $editingProductId = null;

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->editingProductId = null;
        $this->showForm = true;
    }

    public function edit($productId)
    {
        $this->editingProductId = $productId;
        $this->showForm = true;
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->editingProductId = null;
    }

    public function delete($productId)
    {
        $product = Product::findOrFail($productId);
        
        // Delete the image file if it exists
        if ($product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        
        session()->flash('message', 'Product deleted successfully.');
    }

    public function render()
    {
        $query = Product::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.products', [
            'products' => $products,
        ]);
    }
}
