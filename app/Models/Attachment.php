<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'server_name',
        'db_name'
    ];

    public function attachmentable(){
        return $this->morphTo();
    }
}
