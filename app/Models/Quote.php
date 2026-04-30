<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        // Company
        'company_name',
        'company_address',
        'company_email',
        'company_contact',
        'company_date',
        'company_website',

        // Client
        'client_name',
        'client_address',
        'client_email',
        'client_contact',

        // Quote
        'quote_number',
        'quote_valid_date',
        'status',
        'project_title',

        // Items & totals
        'items',
        'sub_total',
        'tax',
        'discount',
        'grand_total',
    ];

    protected $casts = [
        'items' => 'array',
        'company_date' => 'date',
        'quote_valid_date' => 'date',
    ];

    /* ===============================
        QUOTE STATUS ENUM CONSTANTS
       =============================== */
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_ACCEPTED    = 'accepted';
    public const STATUS_REJECTED    = 'rejected';
    public const STATUS_COMPLETED   = 'completed';

    /* ===============================
        RELATIONSHIPS
       =============================== */

    // Quote == Project
    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id');
    }

    public function project()
    {
        return $this->hasOne(Project::class,"quote_id");
    }

    /* ===============================
        ACCESSORS
       =============================== */

    // Auto project progress percentage
    public function getProgressPercentageAttribute(): int
    {
        $totalTasks = $this->tasks()->count();

        if ($totalTasks === 0) {
            return 0;
        }

        $completedTasks = $this->tasks()
            ->where('status', 'done')
            ->count();

        return (int) round(($completedTasks / $totalTasks) * 100);
    }

    /* ===============================
        HELPERS
       =============================== */

    public function isAccepted(): bool
    {
        return $this->quote_status === self::STATUS_ACCEPTED;
    }

    public function isCompleted(): bool
    {
        return $this->quote_status === self::STATUS_COMPLETED;
    }
}
