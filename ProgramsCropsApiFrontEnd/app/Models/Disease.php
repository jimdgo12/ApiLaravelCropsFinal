<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// class Disease extends Model
// {
//     use HasFactory;

//     // Relación varios a varios (Disease => Crops)
//     public function crops(): BelongsToMany
//     {
//         return $this->belongsToMany(Crop::class, 'crop_diseases','crop_id','disease_id');
//     }

//     // Relación varios a varios ( Disease => Pesticides)
//     public function pesticides(): BelongsToMany
//     {
//         return $this->belongsToMany(Pesticide::class,'disease_pesticides', 'disease_id','pesticide_id');
//     }

//     // Arreglo que indica que campos se pueden insertar en la tabla
//     // Hay campos que ingresan nulos, entonces no van al arreglo
//     protected $fillable = [
//         'nameCommon',
//         'nameScientific',
//         'description',
//         'diagnosis',
//         'symptoms',
//         'transmission',
//         'type',
//         'image',

//     ];
// }
