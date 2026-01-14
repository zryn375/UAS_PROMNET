<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'summary',
        'category',
        'cover_image',
        'reading_time',
        'view_count',
        'user_id',
        'published_at'
    ];

    protected $dates = ['published_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedPublishedAtAttribute()
    {
        return $this->published_at ? $this->published_at->format('d F Y') : 'Belum dipublikasikan';
    }

    public function incrementViewCount()
    {
        $this->view_count++;
        $this->save();
    }
}