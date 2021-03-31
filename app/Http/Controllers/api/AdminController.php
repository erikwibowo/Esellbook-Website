<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $data = Admin::where(['email' => $email]);

        if ($data->count() == 1) {
            $data = $data->first();
            if ($data->status == 1) {
                if (Hash::check($password, $data->password)) {
                    Admin::where("id", $data->id)->update(['login_at' => now()]);
                    $response = [
                        'status'    => true,
                        'id'        => $data->id,
                        'message'   => "Berhasil login"
                    ];
                } else {
                    $response = [
                        'status'    => false,
                        'id'        => null,
                        'message'   => "Email atau password tidak cocok"
                    ];
                }
            } else {

                $response = [
                    'status'    => false,
                    'id'        => null,
                    'message'   => "Akun anda telah dinonaktifkan hubungi administrator"
                ];
            }
        } else {
            $response = [
                'status'    => false,
                'id'        => null,
                'message'   => "Email atau password tidak cocok"
            ];
        }
        echo json_encode($response);
    }
}
