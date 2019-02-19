<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $fillable = ['email', 'subitusTracking', 'phone', 'name', 'company', 'url', 'ascription_id'];

    public function createUsers(){
        // $emails = array('user1', 'user2', 'aprobado', 'reprobado');
        $at = getEmailProvider($email);
        $createdUsers = array();
        // foreach ($emails as $email) {
            
        // }
        $users = factory(App\User::class)->create([
            'ascription_id' => $this->ascription_id
            // 'email' => ''
        ]);
        foreach ($users as $user) {
            # code...
        }
        $ids = $users->pluck('id');
        // User::whereIn('id', )
    }
}
