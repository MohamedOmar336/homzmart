<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAdminRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Traits\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
    use Authorizable;

    public function updateProfile(UpdateAdminRequest $request)
    {
        auth()->user()->update([
            'user_name' => $request->user_name,
            'email' => $request->email
        ]);
        if ($request->has('password') && $request->password) {
            auth()->user()->update(['password' => Hash::make($request->password)]);
        }
        return redirect()->back();
    }

}
?>
