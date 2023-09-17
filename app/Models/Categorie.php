<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'user_id'];

    public function getPriorityLabelAttribute()
    {
        switch ($this->priority) {
            case 1:
                return 'Muito alta';
            case 2:
                return 'Alta';
            case 3:
                return 'Média';
            case 4:
                return 'Baixa';
            case 5:
                return 'Muito baixa';
            default:
                return '';
        }
    }
}
