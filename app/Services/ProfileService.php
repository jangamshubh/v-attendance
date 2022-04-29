<?php

namespace App\Services;

use Auth;
use App\Models\User;

class ProfileService {

    public function getProfile() {
        if(Auth::user()) {
            $data = Auth::user();
            return $this->profileSuccessMessage($data);
        } else {
            return $this->errorMessage();
        }
    }

    public function updateProfile($request) {
        if(Auth::user()) {
            $data = User::find(Auth::id());
            $data->mobile_number = $request->mobile_number;
            $data->contact_email = $request->contact_email;
            $data->name = $request->name;
            $data->update();
            return $this->updateProfileSuccessMessage($data);
        }
    }


    protected function profileSuccessMessage($data) {
        $profile['status'] = 'success';
        $profile['message'] = 'Profile Retrieved Successfully';
        $profile['data'] = $data;
        return $profile;
    }

    protected function errorMessage() {
        $profile['status'] = 'error';
        $profile['message'] = 'You are not allowed to access this data!';
        return $profile;
    }

    protected function updateProfileSuccessMessage($data) {
        $profile['status'] = 'success';
        $profile['message'] = 'Profile Updated Successfully';
        $profile['data'] = $data;
        return $profile;
    }
}
