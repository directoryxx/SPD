<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class MailController extends Controller
{
    public function index()
    {
        $to_name = 'Karyawan1';
        $to_email = 'gedohiyoyo@crowd-mail.com';
        $data = array('name' => "Sam Jose", "isi" => "Test mail");
        $template = 'xyz.blade.php'; // resources/views/mail/xyz.blade.php
        Mail::send('mail.xyz', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Artisans Web Testing Mail');
            $message->from('laravelemailtestone@gmail.com', 'Artisans Web');
        });
        
    }
}
