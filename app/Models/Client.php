<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    // Define the table name if it's not the plural form of the model name
    protected $table = 'clients';

    // Specify the fillable fields for mass assignment
    protected $fillable = [
        'name',
        'phone',
        'password',
        'is_active',
        'merchant',
        'branch_id',
              'otp',
        'phone_verified_at',
        'is_confirmed',
        'verification_code_requests',
        'last_verification_code_sent_at',
    ];

    // Optional: Specify the hidden attributes (e.g., password and OTP for security)
    protected $hidden = [
        'password',
        'otp',
        'remember_token', // if you're using "remember me" functionality
    ];

    // Optional: Casting attributes to specific types (e.g., dates and booleans)
    protected $casts = [
        'is_active' => 'boolean',
        'is_confirmed' => 'boolean',
        'birth_date' => 'date',
        'phone_verified_at' => 'date',
        'last_verification_code_sent_at' => 'date',
    ];

    /**
     * Accessor for hashed password.
     */
    public function setPasswordAttribute($value)
    {
        // Ensure the password is hashed before saving
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Accessor for the phone_verified_at date (if needed for formatting)
     */
    public function getPhoneVerifiedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    // Methods 
    
    public function isVerified()
    {
        return $this->is_confirmed;
    }

    // Relation

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    public function searchHistory()
    {
        return $this->hasMany(SearchHistory::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorites', 'client_id', 'product_id')
            ->withTimestamps();
    }

    public function AccountStatements (){
        return $this->hasMany(AccountStatement::class);
    }
     public function branch(){
        return $this->belongsTo(Branch::class);
    }

 public function routeNotificationForFcm(): ?string
    {
        return $this->fcm_token;
    }

}
