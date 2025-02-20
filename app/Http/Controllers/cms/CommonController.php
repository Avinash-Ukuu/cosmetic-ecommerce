<?php

namespace App\Http\Controllers\cms;

use App\Models\User;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class CommonController extends Controller
{
    public function sortRows(Request $request)
    {
        foreach ($request->order as $position => $id) {
            DB::table($request->table)->where("id", $id)->update(["position" => $position + 1]);
        }

        return "done";
    }

    public function isRestricted(Request $request)
    {
        $this->authorize("admin", new User());
        $object              =   DB::table($request->table)->where("id", $request->id);
        $object->update(["is_restricted" => $request->is_restricted]);
        $object              =   $object->first();

        $action              =   !empty($object->is_restricted) ? "restricted" : "public";
        $data['message']     =   auth()->user()->name . " has make the " . $object->name . " " . $request->module . " $action";
        $data['action']      =   $action;
        $data['module']      =   $request->module;
        $data['object']      =   $object;

        saveLogs($data);
        return "done";
    }

    public function isActiveAction(Request $request)
    {
        $this->authorize("admin",new User());
        $object              =   DB::table($request->table)->where("id", $request->id);
        $object->update(["is_active" => $request->is_active]);
        $object              =   $object->first();

        $data['message']     =   auth()->user()->name . " has updated $request->module";
        $action              =   $object->is_active ? "active" : "in active";
        $data['action']      =   $action;
        $data['module']      =   $request->module;
        $data['object']      =   $object;
        saveLogs($data);
        return "done";
    }

    public function productImageDelete(Request $request)
    {
        $request->validate([
            'image_id' => 'required|exists:product_images,id',
        ]);

        $image  =   ProductImage::find($request->image_id);

        $imagePath = public_path('uploads/products/' . $image->product_id . '/' . $image->url);

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully.'
        ]);
    }

    public function isPublishAction(Request $request)
    {
        $object              =   DB::table($request->table)->where("id", $request->id);
        $object->update(["publish_type" => $request->publish_type]);
        $object              =   $object->first();

        $data['message']     =   auth()->user()->name . " has updated publish type of $request->module ";
        $action              =   $object->publish_type;
        $data['action']      =   $action;
        $data['module']      =   $request->module;
        $data['object']      =   $object;
        saveLogs($data);
        return "done";
    }
}
