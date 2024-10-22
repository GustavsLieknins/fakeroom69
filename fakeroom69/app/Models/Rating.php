<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    // Specify the fields that can be mass-assigned
    protected $fillable = ['user_id', 'class_id', 'task_id', 'rating'];
}
