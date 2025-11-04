<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AcademicYear extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'is_current',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_current' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // When an academic year is set as current, unset all others
        static::saving(function ($academicYear) {
            if ($academicYear->is_current) {
                static::where('id', '!=', $academicYear->id)
                    ->update(['is_current' => false]);
            }
        });
    }

    /**
     * Get the academic year's duration in days.
     *
     * @return int|null
     */
    public function getDurationAttribute(): ?int
    {
        if ($this->start_date && $this->end_date) {
            return $this->start_date->diffInDays($this->end_date);
        }

        return null;
    }

    /**
     * Get the academic year's formatted period.
     *
     * @return string
     */
    public function getFormattedPeriodAttribute(): string
    {
        if ($this->start_date && $this->end_date) {
            return $this->start_date->format('M Y') . ' - ' . $this->end_date->format('M Y');
        }

        return $this->name;
    }

    /**
     * Check if the academic year is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        if (!$this->start_date || !$this->end_date) {
            return false;
        }

        $now = now();
        return $now->between($this->start_date, $this->end_date);
    }

    /**
     * Check if the academic year has ended.
     *
     * @return bool
     */
    public function hasEnded(): bool
    {
        if (!$this->end_date) {
            return false;
        }

        return now()->gt($this->end_date);
    }

    /**
     * Check if the academic year hasn't started yet.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        if (!$this->start_date) {
            return false;
        }

        return now()->lt($this->start_date);
    }

    /**
     * Scope a query to only include current academic year.
     */
    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    /**
     * Scope a query to only include active academic years.
     */
    public function scopeActive($query)
    {
        $now = now();
        return $query->where('start_date', '<=', $now)
                     ->where('end_date', '>=', $now);
    }

    /**
     * Scope a query to order by most recent.
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('start_date', 'desc');
    }
}