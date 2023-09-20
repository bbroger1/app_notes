<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;

    protected $table = 'notes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'category_id',
        'priority',
        'status',
        'title',
        'description',
        'deadline'
    ];

    public function getFormattedDeadlineAttribute()
    {
        return Carbon::parse($this->attributes['deadline'])->format('d-m-Y');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
