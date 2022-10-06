<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;
class PropertyArea extends Model
{
    protected $table = "property_areas";
    protected $guarded = [];

    public function getTranslation($field = '', $lang = false){

        $lang = $lang == false ? App::getLocale() : $lang;
        $translations = $this->translations->where('lang', $lang)->first();
        return $translations != null ? $translations->$field : $this->$field;
    }
    
    public function translations(){
        return $this->hasMany(PropertyAreaTranslation::class,'ref');
    }


    
    public function city()
    {
        return $this->belongsTo(PropertyCity::class,'city_id','id');
    }

    public function nested()
    {
        return $this->hasMany(PropertyNestedArea::class,'parent_id','id');
    }

    public function products(){
    	return $this->hasMany(Product::class, 'area_id');
    }

    public function publish() {
        return $this->products()->where('published', 1);
    }
    
    
}