<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    const STATUS_CREATED = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_DONE = 2;
    const STATUS_CANCELED = 3;

    const PRIORITY_LOW = 0;
    const PRIORITY_MIDDLE = 1;
    const PRIORITY_HIGH = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'manager_id',
        'worker_id',
        'creator_id',
        'done_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'worker_id', 'id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id', 'id');
    }
}
