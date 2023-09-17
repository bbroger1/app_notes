<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
}
