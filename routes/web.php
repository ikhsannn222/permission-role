<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('give-permission-to-role', function() {
    // author
    $role = Role::findOrFail(3);
    // create,edit,delete article
    $permission1 = Permission::findOrFail(1);
    $permission2 = Permission::findOrFail(2);
    $permission3= Permission::findOrFail(3);
    $role->givePermissionTo([$permission1,$permission2,$permission3]);
});

Route::get('assign-role-to-user', function() {
    $user = User::create([
        'name'=> 'user multiple role',
        'email' => 'user@gmail.com',
        'password' => '12345678',
    ]);
    $role1 = Role::findOrFail(1);
    $role2 = Role::findOrFail(2);
    $role3 = Role::findOrFail(3);

    $user->assignRole([$role1,$role2,$role3]);
});

Route::get('spatie-method', function() {
    $user = User::findOrFail(1);
    dd($user->getPermissionsViaRoles());
});

$user = User::findOrFail(3);
Auth::login($user);
Route::get('create-article', function(){
    dd('Ini adalah Fitur membuat create article.hanya bisa di akses oleh author/moderator');
})->middleware('can:create article');

Route::get('edit-article', function(){
    dd('Ini adalah Fitur membuat edit article.hanya bisa di akses oleh editor/moderator');
})->middleware('can:edit article');;

Route::get('delete-article', function(){
    dd('Ini adalah Fitur membuat delete article.hanya bisa di akses oleh moderator');
})->middleware('can:delete article');;
