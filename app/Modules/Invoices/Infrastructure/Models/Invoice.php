<?php

namespace App\Modules\Invoices\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use App\Domain\Enums\StatusEnum;
use App\Modules\Products\Infrastructure\Models\Product;
use App\Modules\Companies\Infrastructure\Models\Company;

class Invoice extends Model
{
    use HasUuids, HasFactory;

    // protected $table = 'invoices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'number',
        'date',
        'due_date',
        'company_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be date.
     *
     * @var array
     */
    protected $dates = [
        'due_date',
        'date',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'due_date'   => 'datetime',
        'status'     => StatusEnum::class,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function products(): belongsToMany
    {
        return $this->belongsToMany(Product::class, 'invoice_product_lines')
                    ->withPivot('quantity');
    }

    public function changeStatus(StatusEnum $status): void
    {
        $this->update(['status' => $status]);
    }
}