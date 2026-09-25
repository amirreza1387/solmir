<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'client_name',
        'category',
        'image',
        'url',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
        ];
    }

    public function scopeFeatured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    protected static function booted(): void
    {
        static::saved(function () {
            cache()->forget('public.portfolios.featured');
            cache()->forget('public.portfolios.all');
        });

        static::deleted(function () {
            cache()->forget('public.portfolios.featured');
            cache()->forget('public.portfolios.all');
        });
    }
}
