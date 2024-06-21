<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Detail extends Model
{
    use HasFactory;
    
    protected $fillable = ['inventory', 'sold', 'color', 'size', 'listing_id'];
 
    public function listing(): BelongsTo{
        return $this -> belongsTo(Listing::class);
    } 
     
    public function getAvailableAttribute(){
        return $this -> inventory != 0;
    }
    function getBarcodeAttribute(){
        $generator = new \Picqer\Barcode\BarcodeGeneratorSVG();
        return $generator -> getBarcode($this -> id, $generator::TYPE_CODE_128, 2, 30);
    }
}
