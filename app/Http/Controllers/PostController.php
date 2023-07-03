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
            'file' => 'file|size:5024',
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
            $f_name = random_int(1, 1000) * random_int(1, 1000) . $data['user_id'] . strtoupper(explode("@", auth()->user()->email)[0]);
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
}
