<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Books extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id';
    protected $keyType = "int";
    public $timestamp = true;
    public $incrementing = true;
    protected $fillable = ['title', 'description', 'publish_date', 'author_id'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Books::class, 'author_id', 'id');
    }
}
