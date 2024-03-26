<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'filename',
        'filepath',
        'size',
        'lastModified',
        'XResolution',
        'YResolution',
        'PixelXDimension',
        'PixelYDimension',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
