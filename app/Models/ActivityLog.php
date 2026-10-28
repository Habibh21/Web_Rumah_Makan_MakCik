<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    // Menghubungkan Model ke nama tabel baru yang aman dari bentrokan tablespace
    protected $table = 'audit_activity_logs';

    protected $guarded = [];

    /**
     * Helper serbaguna untuk mencatat log otomatis dari mana saja
     */
    public static function record($action, $description, $userName = null, $role = null)
    {
        $currentUser = auth()->user();

        self::create([
            'user_id'     => $currentUser ? $currentUser->id : null,
            'user_name'   => $currentUser ? $currentUser->name : ($userName ?? 'Tamu / Unknown'),
            'role'        => $currentUser ? $currentUser->role : ($role ?? 'guest'),
            'action'      => $action,
            'description' => $description,
            'ip_address'  => request()->ip(),
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}