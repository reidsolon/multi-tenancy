<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\App;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'amount_in_cents',
        'amount',
        'quantity'
    ];

    protected $casts = [
        'amount_in_cents' => 'int',
        'amount' => 'float'
    ];

    public function getAmountAttribute(): float
    {
        return round($this->attributes['amount_in_cents'] / 100, 2);
    }

    public function getFormattedAmountAttribute(): string
    {
        return (new \NumberFormatter(App::getLocale(), \NumberFormatter::CURRENCY))
            ->formatCurrency($this->amount, strtoupper(config('app.currency', 'USD')));
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
