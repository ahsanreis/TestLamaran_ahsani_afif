<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Authors extends Model
{
    protected $table = 'authors';
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = ['name', 'bio', 'dob'];
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function books(): HasMany{
        return $this->hasMany(Books::class, 'author_id', 'id');
    }
}
