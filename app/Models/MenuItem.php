<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'photo',
    ];

    /**
     * Get the category that the menu item belongs to.
     * This defines the 'Many' side of the relationship.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
