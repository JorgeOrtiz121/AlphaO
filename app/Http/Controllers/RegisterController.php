<?php

namespace App\Http\Controllers;

use App\Helpers\PasswordHelper;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{

 
     protected string $role_slug;

 
     protected bool $can_receive_notifications;
 
 
     
     public function __construct(string $role_slug, bool $can_receive_notifications = false)
     {
        
         $this->role_slug = $role_slug;
 
       
         $this->can_receive_notifications = $can_receive_notifications;
     }
 
 
 
    
     public function store(Request $request)
     {
        
         $request -> validate([
             'first_name' => ['required', 'string', 'min:3', 'max:35'],
             'last_name' => ['required', 'string', 'min:3', 'max:35'],
             'username' => ['required', 'string', 'min:5', 'max:20', 'unique:users'],
             'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
             'personal_phone' => ['required', 'numeric', 'digits:10'],
             'home_phone' => ['required', 'numeric', 'digits:9'],
             'address' => ['required', 'string', 'min:5', 'max:50'],
             'password'=>['required','string','min:5','max:20']
             
         ]);
         $request->request->add([
            'password' => Hash::make($request['password'])
        ]);
         
         $role = Role::where('slug', $this->role_slug)->first();
         
         $user = new User($request->all());
         // Crear el password
         //$temp_password = PasswordHelper::generatePassword();
        
        // $user->password = Hash::make($temp_password);
        
         $role->users()->save($user);
        
         /*if ($this->can_receive_notifications)
         {
          
             $this->sendNotifications($user, $temp_password);
         }

         **/
  
         return $this->sendResponse(message: 'User stored successfully');
     
        }
 
 
 
}
