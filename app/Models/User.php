<?php

namespace App\Models;

use App\Notifications\CustomVerifyEmail;
use App\Notifications\ResetPassword;
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
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'date_of_birth',
        'address',
        'postal_code',
        'city',
        'province',
        'tax_id',
        'business_name',
        'vat_number',
        'pec_address',
        'sdi_code',
        'telephone',
        'price_list',
        'active',
        'discount',
        'mobile_pin',             
        'mobile_access_enabled',   
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'mobile_pin',              
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
            'mobile_access_enabled' => 'boolean',  
            'last_mobile_login' => 'datetime',  
        ];
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Genera un PIN di 4 cifre univoco per questo tenant
     */
    public static function generateMobilePin(): string
    {
        do {
            // Genera PIN di 4 cifre (non inizia per 0)
            $pin = str_pad(random_int(1000, 9999), 4, '0', STR_PAD_LEFT);
            
        } while (self::where('mobile_pin', $pin)->exists());

        return $pin;
    }

    /**
     * Abilita accesso mobile e genera PIN se non esiste
     */
    public function enableMobileAccess(): self
    {
        if (!$this->mobile_pin) {
            $this->mobile_pin = self::generateMobilePin();
        }
        
        $this->mobile_access_enabled = true;
        $this->save();
        
        return $this;
    }

    /**
     * Rigenera il PIN mobile
     */
    public function regenerateMobilePin(): self
    {
        $this->mobile_pin = self::generateMobilePin();
        $this->save();
        
        return $this;
    }

    /**
     * Aggiorna timestamp ultimo accesso mobile
     */
    public function updateLastMobileLogin(): self
    {
        $this->last_mobile_login = now();
        $this->save();
        
        return $this;
    }

    /**
     * Verifica se l'utente ha accesso mobile attivo
     */
    public function hasMobileAccess(): bool
    {
        return $this->active && 
               $this->mobile_access_enabled && 
               !empty($this->mobile_pin);
    }

    /**
     * Trova utente per email e PIN in questo tenant
     */
    public static function findByEmailAndPin(string $email, string $pin): ?self
    {
        return self::where('email', $email)
                   ->where('mobile_pin', $pin)
                   ->where('mobile_access_enabled', true)
                   ->where('active', true)
                   ->first();
    }

    /**
     * Scope per utenti con accesso mobile
     */
    public function scopeMobileEnabled($query)
    {
        return $query->where('mobile_access_enabled', true)
                     ->where('active', true)
                     ->whereNotNull('mobile_pin');
    }

    /**
     * Ottieni dati safe per API mobile (senza PIN)
     */
    public function getMobileApiData(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'mobile_access_enabled' => $this->mobile_access_enabled,
            'has_mobile_pin' => !empty($this->mobile_pin),
            'last_mobile_login' => $this->last_mobile_login?->format('Y-m-d H:i:s'),
        ];
    }
}