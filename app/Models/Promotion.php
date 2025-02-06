<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Promotion extends Model
{
    use HasFactory;
    protected $casts = [
        'isShow' => 'boolean',
    ]; 

    public function getDisplayImage(){ 
        if(Storage::exists($this -> image))
            return Storage::url($this -> image);
        return $this -> image;
    }
}
