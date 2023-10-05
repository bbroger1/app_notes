<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    public function profile()
    {
        $user = Auth::user();
        return view('users/profile', compact('user'));
    }

    public function update(User $user, UserRequest $request)
    {
        try {
            $data = $request->validated();
            $old_image = $user->image;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $path = $this->imageUploadService->upload($image, $old_image);
                $explode = explode('/', $path);
                $data['image'] = $explode[4];

                if (!Storage::exists($path)) {
                    session()->flash('error', 'Dados não puderam ser editados.[2]');
                    return redirect()->route('profile');
                }
            }

            if (isset($data['new_password'])) {
                if (!$this->changePassword($user, $data)) {
                    session()->flash('error', 'Os dados digitados estão incorretos.');
                    return redirect()->route('profile');
                }

                $data['password'] = Hash::make($data['new_password']);
            } else {
                unset($data['password']);
            }

            if (!$user->update($data)) {
                // Reverter a alteração do caminho da imagem
                $user->image = $old_image;
                $user->save();

                session()->flash('error', 'Dados não puderam ser editados.');
                return redirect()->route('profile');
            }

            session()->flash('success', 'Dados editados com sucesso.');
            return redirect()->route('profile');
        } catch (\Throwable $e) {
            dd($e);
            session()->flash('error', 'Dados não puderam ser editados.');
            return redirect()->route('profile');
        }
    }

    private function changePassword($user, $data)
    {
        return Hash::check($data['password'], $user->password) && $data['new_password'] === $data['password_confirm'];
    }
}
