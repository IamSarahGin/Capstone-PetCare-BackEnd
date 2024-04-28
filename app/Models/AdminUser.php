<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class AdminUser extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait,SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'level', 'reset_password_token','remember_token',
    ];
    protected $attributes = [
        'level' => 'Admin',
    ];
    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }
}
