<?php

namespace App\Repositories;

use App\Models\UserProfile;

class UserProfileRepository extends BaseRepository {
    
    public function __construct(UserProfile $userProfile) {
        $this->model = $userProfile;
    }
    
    public function randomUserCoverImage() {
        
    }
}