<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    // 1. Izinkan semua kolom diisi (termasuk sender_id & receiver_id)
    protected $guarded = [];

    // 2. Relasi Pengirim (Sender)
    // Kita harus sebutkan 'sender_id' karena nama fungsinya bukan 'user'
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // 3. Relasi Penerima (Receiver)
    // Kita harus sebutkan 'receiver_id' secara eksplisit
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}