<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
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