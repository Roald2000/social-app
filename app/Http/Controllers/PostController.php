<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function create_post(Request $request)
    {
        $request->validate([
            'content' => "required",
            'status' => "required|integer"
        ]);

        $data = [
            'content' => $request['content'],
            'status' => $request['status'],
            'user_id' => auth()->user()->id
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_ext = $file->getClientOriginalExtension();
            $f_name = random_int(1, 1000) * random_int(1, 1000) . $data['user_id'] . strtoupper(explode("@", auth()->user()->email)[0]) . strtoupper(uniqid());
            $fileName = $data['user_id'] . '_' . strtoupper($f_name) . '.' . $file_ext;
            $file->move('post_files', $fileName);
            $data['file'] = $fileName;
        }

        try {
            //code...
            $post = new PostModel();
            $post['content'] = $data['content'];
            $post['status'] = $data['status'];
            $post['user_id'] = $data['user_id'];
            if ($request->hasFile('file')) {
                $post['file'] = $data['file'];
            }
            $post->save();
            return redirect()->route('welcome');
        } catch (\Exception $th) {
            //throw $th;
            return redirect()->back()->withErrors(['error' => 'Failed to save profile. Make Sure All fields are not empty']);
        }
    }


    public function deletePost($id)
    {
        $post = PostModel::findOrFail($id);

        if (!$post) {
            return redirect()->back()->withErrors(["error" => "Post doest not exist"]);
        }

        $isthere =  is_file(public_path("/post_files/" . $post->file));

        if ($post->user_id !== auth()->user()->id) {
            return redirect()->back()->withErrors(["error" => "You are not the owner of this post!"]);
        }

        if ($isthere) {
            unlink(public_path("/post_files/" . $post->file));
        }

        $post->delete($id);

        return redirect()->back()->with("message", "Post Deleted Succesfully!");
    }

    public function editPost($id)
    {
        $post = PostModel::findOrFail($id);

        if (!$post) {
            return redirect()->back()->withErrors(["error" => "Post does not exist"]);
        } else if ($post->user_id !== auth()->user()->id) {
            return redirect()->back()->withErrors(["error" => "You are not the owner of this post!"]);
        }

        return view('posts.edit-post', compact('post'));
    }

    public function updatePost(Request $request, $id)
    {
        $request->validate([
            
        ]);
    }
}
