<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['entry_date', 'amount', 'branch_id', 'expense_category_id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function expense_category()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }
}
