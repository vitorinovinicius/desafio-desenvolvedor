<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

if (!function_exists('geraActivityLog')) {
    function geraActivityLog($logName = null, $description = null, $properties = null, $subject_id = null, $subject_type = null, $causer_type = null)
    {
        if (Auth::user()) {
            $user_id = Auth::user()->id;
        } else {
            $user_id = null;
        }

        ActivityLog::create([
            "log_name" => $logName,
            "description" => $description,
            "subject_id" => $subject_id,
            "subject_type" => $subject_type,
            "causer_id" => $user_id,
            "causer_type" => $causer_type,
            "properties" => $properties,
        ]);
    }
}