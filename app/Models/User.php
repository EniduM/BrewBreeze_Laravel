<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Determine if the user has admin role.
     */
    public function isAdmin(): bool
    {
        return ($this->role ?? null) === 'admin';
    }

    /**
     * Determine if the user has customer role.
     */
    public function isCustomer(): bool
    {
        return ($this->role ?? null) === 'customer';
    }

    /**
     * Get the customer record associated with this user.
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'user_id', 'id');
    }

    /**
     * Get or create a customer record for this user.
     */
    public function getOrCreateCustomer(): ?Customer
    {
        // If customer already exists for this user, return it
        $customer = $this->customer()->first();
        if ($customer) {
            return $customer;
        }

        // Check if a customer already exists with this email
        $customer = Customer::where('email', $this->email)->first();
        if ($customer) {
            // Link the customer to this user
            $customer->update(['user_id' => $this->id]);
            return $customer;
        }

        // Create a new customer record for this user
        $customer = Customer::create([
            'user_id' => $this->id,
            'first_name' => $this->name ?? 'Customer',
            'last_name' => '',
            'name' => $this->name ?? 'Customer',
            'email' => $this->email,
        ]);

        return $customer;
    }
}
