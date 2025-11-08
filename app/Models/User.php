<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
     * Get all notifications for the user
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get unread notifications for the user
     */
    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class)->where('is_read', false)->orderBy('created_at', 'desc');
    }

    /**
     * Get all bookings made by this user
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    /**
     * Get bookings approved by this user (admin)
     */
    public function approvedBookings()
    {
        return $this->hasMany(Booking::class, 'approved_by');
    }

    /**
     * Get bookings rejected by this user (admin)
     */
    public function rejectedBookings()
    {
        return $this->hasMany(Booking::class, 'rejected_by');
    }
}