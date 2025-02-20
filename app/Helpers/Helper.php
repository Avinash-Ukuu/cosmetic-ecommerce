<?php

use App\Http\Controllers\cms\ActivityLogsController;

if (!function_exists("saveLogs")) {
    function saveLogs($data)
    {
        $activityLogs   =   new ActivityLogsController();
        $activityLogs->saveLogs($data);
    }
}
