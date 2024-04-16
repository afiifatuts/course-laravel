<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'occupation',
        'avatar',
        'password',
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


    public function courses(){
        return $this->belongsToMany(Course::class,'course_students');
    }

    //function tambahan untuk cek user subscription
    // -satu pengguna bisa memiliki banyak transaksi
    // - bisa jadi bulan ini dia habis masa subcribenya, lalu diperpanjang ke bulan depan 
    public function subscribe_transaction(){
        return $this->hasMany(SubscribeTransaction::class);
    }

    //bikin Reusable function untuk mengecek apakah user masih berlangganan course
    //ini akan dipakai dibeberapa controller
    //DRY (Don't Repeat Yourself)
    public function hasActiveSubscription(){
        // 1. cek apakah dia punya subscribe transaction
        // 2. cek yang status is_paid nya TRUE
        // 3. cek yang updated at nya paling terbaru
        $latestSubscription = $this->subscribe_transaction()
        ->where('is_paid',true)
        ->latest('updated_at')
        ->first();

        //jika datanya tidak ada maka return false, artinya dia tidak berlangganan 
        if(!$latestSubscription){
            return false;
        }
        //tapi jika dia berlangganan maka: 
        // 1. cek sampai kapan dia berlangganan
        // 2. sistem langganannya hanya 1 bulan
        // 3. cek apakah hari ini sama dengan End Datenya 
        // 4. nanti akan mereturn boolean TRUE/FALSE

        $subscriptionEndDate = Carbon::parse($latestSubscription->subscription_start_date)->addMonths(1);
        return Carbon::now()->lessThanOrEqualTo($subscriptionEndDate);


    }

}
