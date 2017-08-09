<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace MyTeamTree\Model;
use Illuminate\Database\Eloquent\Model as EloquentModel;
/**
 * Description of User
 *
 * @author vinicius
 */
class User extends EloquentModel
{
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password'
    ];

}