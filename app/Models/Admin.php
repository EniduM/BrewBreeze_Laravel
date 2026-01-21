<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Get the customers managed by this admin.
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'admin_id', 'admin_id');
    }

    /**
     * Get the products managed by this admin.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'admin_id', 'admin_id');
    }
}
