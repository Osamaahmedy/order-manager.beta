<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;


    /**
     * الخصائص التي يمكن تعبئتها جماعياً
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * الخصائص التي يجب إخفاؤها عند التحويل إلى JSON
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * الخصائص التي يجب تحويل نوعها
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * العلاقة مع الأدوار (هذه العلاقة مضافة تلقائياً بفضل HasRoles trait,
     * لكن لو حبيت تضيفها بشكل يدوي، كالتالي:)
     */
    /*
    public function roles()
    {
        return $this->belongsToMany(\Spatie\Permission\Models\Role::class, 'model_has_roles', 'model_id', 'role_id')
            ->wherePivot('model_type', self::class);
    }
    */
}
