<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Traits\LatestOrder;
use App\Models\ProductVariation;
use App\Models\PaymentMethod;
use App\Models\Address;
use App\Models\Order;
use App\Models\Traits\CanBeScoped;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, CanBeScoped, LatestOrder;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','gateway_customer_id','image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->password = bcrypt($user->password);
        });
    }

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->id;
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function cart()
    {
        return $this->belongsToMany(ProductVariation::class, 'cart_user')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }
}
