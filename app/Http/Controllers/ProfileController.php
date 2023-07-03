<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    //

    public function profile()
    {
        $auth_id = auth()->user()->id;
        $user = User::find($auth_id);
        $profile = $user->profile;
        return view('profile.profile', ['profile' => $profile]);
    }

    public function seeProfile($id)
    {
        $user = User::find($id);
        $profile = $user->profile;
        if (auth()->user()->id == $id) {
            return view('profile.profile', compact('profile'));
        }

        if (!$profile) {
            return view('profile.no-pofile');
        }

        return view('profile.see-profile', compact('profile', 'user'));
    }

    public function saveProfile(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'contact' => 'required',
            'status' => 'required',
            'pfp' => 'file|max:5048' // Example: Maximum file size of 5MB
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->save();

        $data = [
            'address' => $request->address,
            'contact' => $request->contact,
            'status' => $request->status,
            'user_id' => $user->id
        ];

        if ($request->hasFile('pfp')) {
            $file = $request->file('pfp');
            $file_ext = $file->getClientOriginalExtension();
            $email = $user->email;
            $f_name = explode("@", $email)[0];
            $fileName = $user->id . '_' . strtoupper($f_name) . '.' . $file_ext;
            $file->move('profile_images', $fileName);
            $data['pfp'] = $fileName;
        }

        try {
            UserProfile::updateOrCreate(['user_id' => $user->id], $data);
            return redirect()->route('user.profile');
        } catch (\Exception $e) {
            // Handle exception and provide appropriate error response
            return redirect()->back()->withErrors(['error' => 'Failed to save profile. Make Sure All fields are not empty']);
        }
    }

    public function deleteProfile($profile_id)
    {
        $profile = UserProfile::findOrFail($profile_id);
        $filePath = public_path('/profile_images/' . $profile->pfp);
        File::delete($filePath);
        $profile->delete();
        return redirect()->route('view.login');
    }
}
