<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;   
    protected $with = ['sections.subsections'];
    protected $fillable = ['name'];
    protected $casts = [
        'images' => 'array',
    ];
    public function sections():HasMany{
        return $this->hasMany(Section::class) -> orderBy('index');
    }
    public function randomListing() : Listing{
        return $this -> sections -> random() -> subsections -> random() -> randomListing();
    } 
    public function getLinkAttribute(){
        return '/listings?category=' . $this -> id;
    }
}
