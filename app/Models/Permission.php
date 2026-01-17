<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;

    // لو حبيت تضيف خصائص أو دوال خاصة بالصلاحية تقدر تضيفها هنا
}
