<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    // لو حبيت تضيف خصائص أو دوال خاصة بـ Role تقدر تضيفها هنا

    /**
     * مثال على علاقة مع مستخدمين (إذا تستخدم علاقة مخصصة)
     */
    // public function users()
    // {
    //     return $this->belongsToMany(User::class);
    // }
}
