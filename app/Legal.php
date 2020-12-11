<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LegalCategory;

class Legal extends Model
{
    protected $fillable = [
        'insurance_starting', 'insurance_ending', 'taxtoken_starting','taxtoken_ending','category_id',
    ];
    public function legal_categories()
    {
        return $this->belongsTo(LegalCategory::class);
    }
}
