<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id';    // Tentukan primary key
    public $incrementing = false;    // Nonaktifkan auto increment
    protected $keyType = 'string';   // Gunakan string untuk tipe key

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'roles',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Generate custom ID untuk user dengan panjang tertentu
            $latestUser = DB::table('users')->orderBy('id', 'desc')->first();

            if ($latestUser) {
                $lastId = $latestUser->id;
                $number = (int)substr($lastId, 3) + 1; // Ambil angka terakhir
                $user->id = 'USR' . str_pad($number, 3, '0', STR_PAD_LEFT); // Format dengan panjang 6 karakter
            } else {
                $user->id = 'USR001'; // ID pertama
            }

            // Validasi panjang ID
            if (strlen($user->id) !== 6) {
                throw new \Exception('ID harus memiliki panjang tepat 6 karakter.');
            }
        });
    }
    
    protected $table = 'users';

    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function sales()
    {
        return $this->hasMany(Sales::class);
    }
}
