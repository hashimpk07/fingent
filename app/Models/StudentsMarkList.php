<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsMarkList extends Model
{
    use HasFactory;
    protected $table = 'student_mark_list';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'term','maths','science','history','students_id','created_at'
    ];
    public function students()
    {
        return $this->hasOne(students::class,'id','students_id');
    }
}
