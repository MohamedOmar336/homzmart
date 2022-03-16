<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\EnumsSettings;
use App\Http\Controllers\Controller;
use App\Mail\ForgetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|max:191|exists:users,email',
            'password' => 'required|max:191',
            'type' => 'nullable|in:0,1',
        ]);
        $user = User::whereEmail($request->email)
            ->select( 'password', 'email', 'phone', 'first_name as firstname', 'last_name as lastname')->first();
        if ($user) {
            if ($user->password) {
                if (!Auth::guard()->attempt(['password' => $request->input('password'), 'email' => $request->input('email')])) {
                    return ResponseJson(Response::HTTP_UNPROCESSABLE_ENTITY, __('messages.invalid_password'), '');
                 } else {
                    $data = auth()->user();
                    $data['token'] = auth()->user()->createToken(auth()->user()->email)->accessToken;
                    return ResponseJson(Response::HTTP_OK, __('messages.login_successfully'), $data);
                    }
             }
        return ResponseJson(Response::HTTP_UNPROCESSABLE_ENTITY, __('messages.invalid_activation'), '');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:191',
            'last_name' => 'required|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'phone' => ['required'],
            'password' => 'required|min:8|max:25',
            'confirmation_password' => 'required_with:password|same:password'
        ]);
        dd($request->all());
        $record = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'user_name' => $request->first_name . ' ' . $request->last_name, User::class,
            'slug' => $request->first_name . ' ' . $request->last_name, User::class,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        if ($request->hasFile('image') && $request->image) {
            $record->update(['image' => $request->image]);
        } else {
            $record->update(['image' => null]);
        }

        if (!Auth::guard()->attempt(['password' => $request->input('password'), 'email' => $request->input('email')])) {
            return ResponseJson(Response::HTTP_UNPROCESSABLE_ENTITY, __('messages.invalid_password'), '');
        } else {
            $data = auth()->user();
            $data['token'] = auth()->user()->createToken(auth()->user()->email)->accessToken;
            return ResponseJson(Response::HTTP_OK, __('messages.registered_successfully'), $data);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function logout()
    {
        $token = auth()->user()->token();
        $token->revoke();
        auth()->logout();
        return ResponseJson(Response::HTTP_OK, __('messages.logout_successfully'), '');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function updateAccount(Request $request)
    {
        //update if the user is Buyer
        $request->validate([
            'image' => 'nullable|mimes:png,jpeg,jpg,svg',
            'first_name' => 'required|max:191',
            'last_name' => 'required|max:191',
            'email' => 'required|email|max:191|unique:users,email,' . \auth()->user()->id,
            'phone' => [
                'unique:users,phone,' . \auth()->user()->id,
                'required'
            ],
        ]);
        $user = auth()->user();
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country_code' => $request->country_code,
        ]);
        if ($request->hasFile('image') && $request->image) {
            $path = 'Buyer';
            $logo = webpImages($request->file('image'), $path);
            $user->update(['image' => $logo]);
        }
        return ResponseJson(Response::HTTP_OK, __('messages.updated_successfully'), $user);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return ResponseJson(Response::HTTP_OK, __('messages.mail_send_successfully'), "");
        } else {
            return ResponseJson(Response::HTTP_INTERNAL_SERVER_ERROR, __('messages.user_not_found'));
        }
    }

}