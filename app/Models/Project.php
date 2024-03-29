<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'images' => 'array',
        'files' => 'array',
    ];

    public function leaders () {
        return $this->belongsToMany(User::class, 'project_leaders', 'project_id', 'user_id');
    }

    public function members () {
        return $this->belongsToMany(User::class, 'project_members', 'project_id', 'user_id');
    }

    public function tasks () {
        return $this->hasMany(Task::class, 'project_id', 'id');
    }
}
