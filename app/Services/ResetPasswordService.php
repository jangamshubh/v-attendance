<?php

namespace App\Services;

use App\Models\ResetPassword;
use Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
class ResetPasswordService {

    public function generateOTP($request) {
        $data = new ResetPassword;
        $data->unique_identifier = Str::uuid();
        $data->email = $request->email;
        $data->otp = random_int(100000, 999999);
        $data->process_started_time = Carbon::now('Asia/Kolkata')->format('d-m-Y H:i');
        $data->save();
        $user = User::where('contact_email',$request->email)->first();
        $otp = $this->sendOTP($user,$data);
        $array['status'] = json_decode($otp);
        $array['unique_identifier'] = $data->unique_identifier;
        return $array;
    }

    protected function sendOTP($user,$data) {
        $curl = curl_init();
        $template_id = "Reset-Password-Vishleshan";
        $authkey = "308476ARq4VkPBV55df64864";
        $test = "{\n  \"to\": [\n    {\n      \"name\": \"$user->name\",\n      \"email\": \"$user->contact_email\"\n    }\n  ],\n  \"from\": {\n    \"name\": \"Vishleshan\",\n    \"email\": \"admin@mail.chitran.in\"\n  },\n  \"domain\": \"mail.chitran.in\",\n  \"mail_type_id\": \"1\",\n  \"template_id\": \"$template_id\",\n  \"variables\": {\n    \"Name\": \"$user->name\",\n    \"Otp\": \"$data->otp\"\n  },\n  \"authkey\": \"$authkey\"\n}";
        curl_setopt_array($curl, [
          CURLOPT_URL => "https://api.msg91.com/api/v5/email/send",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $test,
          CURLOPT_HTTPHEADER => [
            "Accept: application/json",
            "Content-Type: application/JSON"
          ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $response['message'] = 'Server Error!';
            return $response;
        } else {
            return $response;
        }
    }

    public function checkOTP($request,$unique_identifier) {
        $data = ResetPassword::where('unique_identifier',$unique_identifier)->first();
        if($data->otp == $request->otp) {
            $data->otp_verified_time = Carbon::now('Asia/Kolkata')->format('d-m-Y H:i');
            $data->update();
            return $this->checkOTPSuccessMessage();
        } else {
            return $this->checkOTPErrorMessage();
        }
    }

    public function resetPassword($request,$unique_identifier) {
        $data = ResetPassword::where('unique_identifier',$unique_identifier)->first();
        if($data->otp_verified_time != '') {
            $user = User::where('contact_email',$data->email)->first();
            $user->email = $data->email;
            $user->password = bcrypt($request->password);
            $user->update();
            return $this->resetPasswordSuccessMessage($user);
        } else {
            return $this->resetPasswordErrorMessage();
        }
    }

    public function checkStatus($unique_identifier) {
        $data = ResetPassword::where('unique_identifier',$unique_identifier)->first();
        return $this->checkStatusMessage($data);
    }


    protected function checkStatusMessage($data) {
        $reset['status'] = 'success';
        $reset['message'] = 'Retrieved Successfully';
        $reset['data'] = $data;
        return $reset;
    }

    protected function generateOTPSuccessMessage($data,$user) {
        $reset['status'] = 'success';
        $reset['message'] = 'OTP Generated Successfully';
        $reset['user'] = $user;
        $reset['data'] = $data;
        return $reset;
    }

    protected function resetPasswordErrorMessage() {
        $reset['status'] = 'error';
        $reset['message'] = 'OTP Not Verified!';
        return $reset;
    }

    protected function resetPasswordSuccessMessage($user) {
        $reset['status'] = 'success';
        $reset['message'] = 'Password Reset Successfully Completed';
        $reset['user'] = $user;
        return $reset;
    }

    protected function checkOTPSuccessMessage() {
        $reset['status'] = 'success';
        $reset['message'] = 'OTP Verified, now you can reset your password';
        return $reset;
    }

    protected function checkOTPErrorMessage() {
        $reset['status'] = 'error';
        $reset['message'] = 'Incorrect OTP, please recheck the otp sent!';
        return $reset;
    }
}
