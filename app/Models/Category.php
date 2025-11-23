<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * Get the menu items for the category (One-to-Many relationship).
     * This defines the 'One' side of the relationship.
     */
    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }
}