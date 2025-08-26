<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';

    // Fields allowed for mass assignment
    protected $fillable = [
        'user_id',
        'file_path',
        'title',
        'description',
        'status',
        'reviewed_by',
        'reviewed_at',
        'remarks',
        'amount'
    ];

    // Dates automatically cast to Carbon instances
    protected $dates = [
        'reviewed_at',
        'created_at',
        'updated_at',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
