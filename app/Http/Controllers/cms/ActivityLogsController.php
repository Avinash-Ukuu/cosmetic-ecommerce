<?php

namespace App\Http\Controllers\cms;

use App\Models\User;
use App\Models\ActivityLogs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogsController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize("superAdmin",new User());

        if ($request->ajax()) {
            $data = ActivityLogs::join("users",'users.id',"=",'activity_logs.action_by')
                              ->select([
                                  'activity_logs.module as Module',
                                  'activity_logs.action as Action',
                                  'users.name as Responsible',
                                  'activity_logs.message as Message',
                                  'activity_logs.created_at as Time'
                              ]);

            return DataTables::of($data)
                ->addIndexColumn()
                ->filterColumn('Module', function($query, $keyword) {
                    $sql = "activity_logs.module LIKE ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('Action', function($query, $keyword) {
                    $sql = "activity_logs.action LIKE ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('Responsible', function($query, $keyword) {
                    $sql = "users.name LIKE ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('Message', function($query, $keyword) {
                    $sql = "activity_logs.message LIKE ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('Time', function($query, $keyword) {
                    $sql = "activity_logs.created_at LIKE ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })

                ->make(true);
        }
        return view("cms.activityLogs");

    }

    public function saveLogs($data)
    {
        if(!auth()->user()->super_admin)
        {
            $activityLogs               =   new ActivityLogs();
            $activityLogs->action       =   $data['action'];
            $activityLogs->module       =   $data['module'];
            $activityLogs->module_id    =   $data['object']->id;
            $activityLogs->message      =   $data['message'];
            $activityLogs->action_by    =   auth()->user()->id;
            $activityLogs->save();
        }
    }
}
