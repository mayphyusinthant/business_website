<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_logo',
        'company_name',
        'company_info',
        'service_info',
        'company_info_mm',
        'service_info_mm',
        'phone_number',
        'email',
        'address',
        'facebook_page',
        'open_hour',
        'close_hour',
        'close_day',
        'created_by',
        'updated_by',
        'location_point',
        'gallery1_photos',
        'gallery2_photos'
    ];
    
    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function updatedBy() {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
