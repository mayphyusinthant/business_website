<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'category',
        'size',
        'medium',
        'price',
        'status',
        'img',
        'created_by',
        'updated_by'
    ];

    public function User(){
        return $this->belongsTo(User::class, 'created_by');
    }    

    public function category(){
        return $this->belongsTo(Category::class, 'category');
    }    
    
    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function updatedBy() {
        return $this->belongsTo(User::class, 'updated_by');
    }
    
   

}
