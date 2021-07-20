<?php

namespace App\Models;

use App\Models\Property\PropertyFeature;
use App\Traits\HasWallet;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasWallet;

    const STATUS_CREATED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_PENDING = 3;

    const STATUS_LABELS = [
        self::STATUS_CREATED => 'Created',
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_PENDING => 'Pending',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'mobile',
        'status',
        'role_id',
        'email',
        'password',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    /**
     * @return void
     */
    public static function boot()
    {
        parent::boot();
    }

    /**
     * Wallet relationship
     *
     * @return HasOne
     */
    public function wallet() : HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * Role relationship
     *
     * @return BelongsTo
     */
    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Verification relationship
     *
     * @return HasMany
     */
    public function verifications() : HasMany
    {
        return $this->hasMany(Verification::class);
    }

    /**
     * Property features relationship
     *
     * @return HasMany
     */
    public function propertyFeatures() : HasMany
    {
        return $this->hasMany(PropertyFeature::class)->orderBy('name');
    }

    /**
     * Check if a user has a role by name
     *
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role) : bool
    {
        return $this->role->name == $role;
    }

    /**
     * Check if a user is admin
     *
     * @return bool
     */
    public function isAdmin() : bool
    {
        return $this->role_id == Role::ROLE_ADMIN;
    }

    /**
     * Check if a user is manager
     *
     * @return bool
     */
    public function isManager() : bool
    {
        return $this->role_id == Role::ROLE_MANAGER;
    }

    /**
     * Check if a user is customer
     *
     * @return bool
     */
    public function isCustomer() : bool
    {
        return $this->role_id == Role::ROLE_CUSTOMER;
    }

    /**
     * Get the name of the user role
     *
     * @return string
     */
    public function getRoleLabel()
    {
        return __(Role::ROLE_LABELS[$this->role_id]);
    }

    /**
     * Get the name of the user role
     *
     * @return string
     */
    public function getStatusLabel()
    {
        return __(self::STATUS_LABELS[$this->status]);
    }

    /**
     * Get user's full name
     *
     * @return string
     */
    public function getFullNameAttribute() : string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Scope a query to include the Admin users.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeAdmin($query) : Builder
    {
        return $query->where('role_id', Role::ROLE_ADMIN);
    }

    /**
     * Scope a query to include the Manager users.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeManager($query) : Builder
    {
        return $query->where('role_id', Role::ROLE_MANAGER);
    }

    /**
     * Scope a query to include the Customer users.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeCustomer($query) : Builder
    {
        return $query->where('role_id', Role::ROLE_CUSTOMER);
    }

    /**
     * Scope a query to include Created users.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeCreated($query) : Builder
    {
        return $query->where('status', self::STATUS_CREATED);
    }

    /**
     * Scope a query to include the Active users.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeActive($query) : Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope a query to include the Pending users.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopePending($query) : Builder
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope a query to include the Inactive users.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeInactive($query) : Builder
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    /**
     * Query scope to include the currently logged in user.
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeCurrent(Builder $query) : Builder
    {
        return $query->where('id', Auth::id());
    }
}
