<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'short_description',
        'description',
        'price',
        'discount_price',
        'duration',
        'features',
        'thumbnail',
        'is_popular',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'price' => 'decimal:2',
            'discount_price' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Service $service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->name) . '-' . Str::random(5);
            }
        });
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'wisuda' => 'Foto Wisuda',
            'umkm' => 'Foto Produk UMKM',
            'acara' => 'Dokumentasi Acara',
            'video_promosi' => 'Video Promosi',
            default => ucfirst($this->category),
        };
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format((float)$this->price, 0, ',', '.');
    }

    public function getFormattedEffectivePriceAttribute(): string
    {
        $amount = $this->discount_price && $this->discount_price > 0 ? $this->discount_price : $this->price;
        return 'Rp ' . number_format((float)$amount, 0, ',', '.');
    }

    public function getEffectivePriceAttribute(): float
    {
        return (float) ($this->discount_price && $this->discount_price > 0 ? $this->discount_price : $this->price);
    }
}
