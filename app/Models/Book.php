<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'title',
        'filename',
        'publisher',
        'issue_date',
        'price',
        'size',
        'width',
        'height',
        'XResolution',
        'YResolution',
        'ResolutionUnit',
        'lastModified',
        'filepath',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * UUIDを生成して返す
     * @return string
     */
    public function newUniqueId() :string
    {
        return (string) Str::ulid();
    }

    /**
     * 一意の識別子を受け取るカラムの取得
     * @return string[]
     */
    public function uniqueIds(): array
    {
        return ['id', 'user_id'];
    }
}
