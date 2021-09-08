<?php

namespace App\Models;

use App\Constants\IStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


/**
 * @mixin IdeHelperPlan
 */
class Plan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'monthly_price',
        'yearly_price',
        'is_active'
    ];

    protected $attributes = ['is_active' => IStatus::ACTIVE];

    public function planoption()
    {
        return $this->hasMany(PlanOptions::class,);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function businessPlan()
    {
        return $this->hasMany(Business::class, 'plan_id');
    }


}
