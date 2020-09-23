<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestDataJoin extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'test_data_id', 'string1', 'string2', 'string3', 'string4', 'string5', 'number1', 'number2', 'number3', 'number4', 'number5',
    ];
    
    public function testData() {
        return $this->belongsTo(\App\Models\TestData::class);
    }
}
