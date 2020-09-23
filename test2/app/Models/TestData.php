<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestData extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'string1', 'string2', 'string3', 'string4', 'string5', 'data', 'number1', 'number2', 'number3', 'number4', 'number5',
    ];
    
    public function testDataJoins() {
        return $this->hasMany(\App\Models\TestDataJoin::class);
    }
}
