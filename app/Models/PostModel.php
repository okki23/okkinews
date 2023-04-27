<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    use HasFactory;
    protected $table = "post";
    protected $fillable =['id','title','authors','pubdate','is_headline','foto','content','created_at','updated_at'];
}
