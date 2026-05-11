<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollExport extends Model
{
    use HasFactory;
    protected $fillable = [
        'period_id',
        'company_id',
        'file_name',
        'file_path',
        'status',
        'message',
        'created_by',
    ];
}
