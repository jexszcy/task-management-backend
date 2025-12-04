<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'is_completed',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'is_completed' => 'boolean',
            'title' => 'string',
            'description' => 'string',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
