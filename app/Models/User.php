<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_name',
        'name',
        'email',
        'password',
        'profile_image'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
//     protected $hidden = [
//         'password', 'remember_token',
//     ];

//     /**
//      * The attributes that should be cast to native types.
//      *
//      * @var array
//      */
//     protected $casts = [
//         'email_verified_at' => 'datetime',
//     ];
// }

    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'following_id');
    }

    public function follows()
    {
        return $this->belongsToMany(self::class, 'followers', 'following_id', 'followed_id');
    }

    public function getAllUsers($user_id)
    {
        return $this->Where('id', '<>', $user_id)->paginate(6);
    }

    public function follow(Int $user_id)
    {
        return $this->follows()->attach($user_id);
    }

    public function unfollow(Int $user_id)
    {
        return $this->follows()->detach($user_id)
    }

    public function isFollowing(Int $user_id)
    {
      return (boolean) $this->follows()->where('followed_id', $user_id)->first(['id']);
    }

    public function isFollowed(Int $user_id)
    {
      return (boolean) $this->followers()->where('following_id',$user_id)->first(['id']);
    }

    public function updateProfile(Array $params){
        if(isset($params['binary_image'])){
            $img = $params['binary_image'];
            $fileData = base64_decode($img);
            $fileName = '/tmp/profile_image.png';
            file_put_contents($fileName, $fileData);

            // バケットの'/profile_images'フォルダへアップロード
            $image = Storage::disk('s3')->putFile('/profile_images', $fileName, 'public');
             // アップロードした画像のフルパスを取得
            $image_path = Storage::disk('s3')->url($image);

            //imageあるかないかのみ
            $this::where('id', $this->id)
            ->update([
              'account_name' => $params['account_name'],
              'name' => $params['name'],
              'self_introduction' => $params['self_introduction'],
              'profile_image' => $image_path,
              'email' => $params['email'],
            ]);
        } else {
            $this::where('id', $this->id)
              ->update([
                'account_name' => $params['account_name'],
                'name' => $params['name'],
                'self_introduction' => $params['self_introduction'],
                'email' => $params['email'],
              ]);
          }
          return;
        }

        public function getFollowingUsers($user_id)
        {
          return $this->follows()->where('following_id', $user_id)->paginate(6);
        }

        public function getFollowers($user_id)
        {
          return $this->followers()->where('followed_id', $user_id)->paginate(6);
        }

        

    }














}
