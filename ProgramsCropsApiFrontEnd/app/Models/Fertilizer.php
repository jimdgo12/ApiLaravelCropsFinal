<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// class Fertilizer extends Model
// {
//     use HasFactory;

//     // Relación varios a varios (Fertilizer => Crop)
//     public function crops():BelongsToMany{
//         return $this->belongsToMany (Crop::class, 'crop_fertilizers', 'crop_id', 'fertilizer_id');


//     }


//     // Arreglo que indica que campos se pueden insertar en la tabla
//     // Hay campos que ingresan nulos, entonces no van al arreglo
//     protected $fillable = [
//         'name',
//         'description',
//         'dose',
//         'price',
//         'type',
//         'image'

//     ];



// }
