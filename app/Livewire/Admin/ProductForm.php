<?php

namespace App\Livewire\Admin;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductForm extends Component
{
    use WithFileUploads;

    public $productId;
    public $name = '';
    public $description = '';
    public $roastLevel = '';
    public $origin = '';
    public $price = '';
    public $stock = 0;
    public $image;
    public $imagePreview;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'roastLevel' => 'nullable|string|max:255',
        'origin' => 'nullable|string|max:255',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|max:2048', // Max 2MB
    ];

    public function mount($productId = null)
    {
        if ($productId) {
            $product = Product::findOrFail($productId);
            $this->productId = $product->product_id;
            $this->name = $product->name;
            $this->description = $product->description ?? '';
            $this->roastLevel = $product->roast_level ?? '';
            $this->origin = $product->origin ?? '';
            $this->price = $product->price;
            $this->stock = $product->stock;
            $this->imagePreview = $product->image_url;
        }
    }

    public function updatedImage()
    {
        $this->validateOnly('image');
        $this->imagePreview = $this->image->temporaryUrl();
    }

    public function save()
    {
        $this->validate();

        // Get admin_id from Admin table using user email
        $admin = Admin::where('email', auth()->user()->email)->first();
        
        if (!$admin) {
            // Create admin record if it doesn't exist
            $admin = Admin::create([
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'password' => auth()->user()->password,
            ]);
        }

        $data = [
            'admin_id' => $admin->admin_id,
            'name' => $this->name,
            'description' => $this->description,
            'roast_level' => $this->roastLevel ?: null,
            'origin' => $this->origin ?: null,
            'price' => $this->price,
            'stock' => $this->stock,
        ];

        // Handle image upload
        if ($this->image) {
            // Delete old image if updating
            if ($this->productId) {
                $oldProduct = Product::findOrFail($this->productId);
                if ($oldProduct->image && Storage::disk('public')->exists($oldProduct->image)) {
                    Storage::disk('public')->delete($oldProduct->image);
                }
            }

            // Store new image
            $imagePath = $this->image->store('products', 'public');
            $data['image'] = $imagePath;
        } elseif ($this->productId) {
            // Keep existing image if not updating
            $existingProduct = Product::findOrFail($this->productId);
            $data['image'] = $existingProduct->image;
        }

        if ($this->productId) {
            $product = Product::findOrFail($this->productId);
            $product->update($data);
            session()->flash('message', 'Product updated successfully.');
        } else {
            Product::create($data);
            session()->flash('message', 'Product created successfully.');
        }

        $this->dispatch('product-saved');
        $this->reset(['name', 'description', 'roastLevel', 'origin', 'price', 'stock', 'image', 'imagePreview', 'productId']);
    }

    public function render()
    {
        return view('livewire.admin.product-form');
    }
}
