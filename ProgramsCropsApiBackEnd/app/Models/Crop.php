<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Crop extends Model
{
    use HasFactory;


    // Relación 1 a varios (Crop => Seed)
    public function seeds(): HasMany
    {
        return $this->hasMany(Seed::class);
    }

    // Relación varios a varios (Crops => Diseases)
    public function diseases(): BelongsToMany
    {
        return $this->belongsToMany(Disease::class, 'crop_diseases', 'crop_id', 'disease_id');
    }

    // Relación varios a varios (Crops => Fertilizer)
    public function fertilizers(): BelongsToMany
    {
        return $this->belongsToMany(Fertilizer::class, 'crop_fertilizers', 'crop_id', 'fertilizer_id');
    }

    // Arreglo que indica que campos se pueden insertar en la tabla
    // Hay campos que ingresan nulos, entonces no van al arreglo
    protected $fillable = [
        'name',
        'description',
        'nameScientific',
        'history',
        'phaseFertilizer',
        'phaseHarvest',
        'spreading',
        'image'

    ];
}
