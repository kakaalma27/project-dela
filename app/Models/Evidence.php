<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidence extends Model
{
    protected $fillable = [
        'name',
        'alamat',
        'indikator',
        'domain',
        'image',
        'pdf',
        'status'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
    
}
