<?php

namespace App\Http\Controllers\cms;

use Carbon\Carbon;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->hasRole('admin'),403);
        if ($request->ajax()) {
            $data               =    Blog::select('*');

            if ($request->order == null) {
                $data           =   $data->orderBy('created_at', 'desc');
            }

            return DataTables::of($data)
                ->editColumn('image', function ($data) {
                    if (!empty($data->image) && file_exists("uploads/blogs/" . $data->image)) {
                        $imagePath  =  asset('uploads/blogs/' . $data->image);
                        return '<img src="' . $imagePath . '" alt="image">';
                    } else {
                        $defaultImage = asset('images/default.png');
                        return '<img src="' . $defaultImage . '" alt="image">';
                    }
                })
                ->editColumn('status', function ($data) {
                    if ($data->publish_type == 'publish') {
                        return '<span class="badge badge-outline-success">Published</span>';
                   }else{
                        return '<span class="badge badge-outline-warning badge-fw">Unpublish</span>';
                    }
                })
                ->editColumn('action', function ($data) {
                    $editUrl        =   route('blog.edit', ['blog' => $data->id]);
                    $deleteUrl      =   route('blog.destroy', ['blog' => $data->id]);
                    $btn            =   '<div class="row">';
                    $btn            .=  '<a href="' . $editUrl . '"><i class="fa fa-edit"></i></a>';
                    if (isset(auth()->user()->super_admin)) {
                        $btn            .=  '<a style="cursor: pointer;"
                                onclick="deleteItem(\'' . $deleteUrl . '\')">
                                <i class="fa fa-trash text-danger ml-2"></i>
                            </a>';
                    }
                    $btn            .=  '</div>';
                    return $btn;
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        return view('cms.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->hasRole('admin'),403);

        $data['object']             =       new Blog();
        $data['method']             =       'POST';
        $data['url']                =       route('blog.store');

        return view('cms.blog.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        $blog                       =       new Blog();
        $blog->title                =       $request->title;
        $blog->slug                 =       Str::slug($request->title);
        $blog->description          =       $request->description;
        $blog->meta_keywords        =       $request->meta_keywords;
        $blog->content              =       $request->content;
        $blog->publish_type         =       'unpublish';
        if ($request->has("image")) {
            $imageName  = "blog_" . Carbon::now()->timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/blogs/'), $imageName);
            $blog->image   =  $imageName;
        }
        $blog->save();

        $data['message']        =   auth()->user()->name . " has created '$blog->title' blog";
        $data['action']         =   "created";
        $data['module']         =   "blog";
        $data['object']         =   $blog;
        saveLogs($data);
        Session::flash("success", "Blog Created Successfully");

        return redirect(route("blog.index"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(!auth()->user()->hasRole('admin'),403);

        $data['object']             =       Blog::find($id);
        if(empty($data['object']))
        {
            Session::flash('error','Data not found');

            return redirect(route('blog.index'));
        }
        $data['method']             =       'PUT';
        $data['url']                =       route('blog.update',['blog'=>$id]);

        return view('cms.blog.form',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, string $id)
    {
        $blog                       =       Blog::find($id);
        if(empty($blog))
        {
            Session::flash('error','Data not found');

            return redirect(route('blog.index'));
        }
        $blog->title                =       $request->title;
        $blog->slug                 =       Str::slug($request->title);
        $blog->description          =       $request->description;
        $blog->meta_keywords        =       $request->meta_keywords;
        $blog->content              =       $request->content;
        $blog->publish_type         =       $request->publish_type;
        if ($request->has("image")) {
            if (file_exists("uploads/blogs/" . $blog->image)) {
                File::delete("uploads/blogs/" . $blog->image);
            }
            $imageName  = "blog_" . Carbon::now()->timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/blogs/'), $imageName);
            $blog->image   =  $imageName;
        }
        $blog->update();

        $data['message']        =   auth()->user()->name . " has update '$blog->title' blog";
        $data['action']         =   "updated";
        $data['module']         =   "blog";
        $data['object']         =   $blog;
        saveLogs($data);
        Session::flash("success", "Blog Updated Successfully");

        return redirect(route("blog.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize("superAdmin", new User());

        $blog   =   Blog::find($id);
        if (empty($blog)) {
            Session::flash("error", "Blog not found");
            return back();
        }
        if (file_exists("uploads/blogs/" . $blog->image)) {
            File::delete("uploads/blogs/" . $blog->image);
        }
        $data['message']        =   auth()->user()->name . " has deleted $blog->title";
        $data['action']         =   "deleted";
        $data['module']         =   "blog";
        $data['object']         =   $blog;
        saveLogs($data);
        $blog->delete();
        Session::flash("success", "Blog Deleted");
        return response()->json(['success' => '200', 'message' => 'Blog Deleted']);
    }
}
