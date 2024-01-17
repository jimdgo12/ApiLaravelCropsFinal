<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seed extends Model
{
    use HasFactory;

    public function crop(): BelongsTo
    {
        return $this->belongsTo(Crop::class);
    }

    // Arreglo que indica que campos se pueden insertar en la tabla
    // Hay campos que ingresan nulos, entonces no van al arreglo
    protected $fillable = [
        'name',
        'nameScientific',
        'origin',
        'morphology',
        'type',
        'quality',
        'spreading',
        'image',
        'crop_id'

    ];
}
