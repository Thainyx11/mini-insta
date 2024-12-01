<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'user_id', 'publication_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function publication()
    {
        return $this->belongsTo(Publication::class, 'publication_id');
    }

    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }
}
