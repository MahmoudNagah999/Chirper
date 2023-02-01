<?php

namespace App\Models;

use App\Events\ChirpCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chirp extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'message',
        'path',
        'user_id'
    ];

    protected $dispatchesEvents = [
        'created' => ChirpCreated::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments(){
        return $this->morphOne(Attachment::class, 'attachmentable');
    }
}
