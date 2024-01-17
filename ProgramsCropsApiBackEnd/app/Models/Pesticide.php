<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pesticide extends Model
{
    use HasFactory;

    // Relación varios a varios (Pesticides => Disease)
    public function diseases(): BelongsToMany
    {
        return $this->belongsToMany(Disease::class, 'disease_pesticides', 'pesticide_id', 'disease_id');
    }
    protected $fillable = [
        'name',
        'description',
        'activeIngredient',
        'price',
        'type',
        'dose',
        'image',

    ];
}
