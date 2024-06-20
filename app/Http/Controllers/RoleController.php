<?php

namespace App\Http\Controllers;

use App\Http\Transformers\RoleTransformer;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Mail;
use App\Mail\UpdateRoleEmail;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $roleData = fractal($roles, new RoleTransformer())->toArray()['data'];
        return Inertia::render('Dashboard/Role/Index')->with([
            'roles' => $roleData
        ]);
    }

    public function store(Request $request)
    {
        $req = $request->validate([
            'name' => ['required']
        ]);
        Role::create([
            'name' => $req['name']
        ]);
        return redirect()->route('dashboard.roles.index');
    }

    public function create()
    {
        return Inertia::render('Dashboard/Role/Create');
    }

    public function edit(Role $role)
    {
        $roleData = fractal($role, new RoleTransformer())->includeImages()->toArray();
        return Inertia::render('Dashboard/Role/Edit')->with([
            'role' => $roleData
        ]);
    }

    public function update(Role $role, Request $request)
    {
        $req = $request->validate([
            'name' => ['required'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'delete_images' => ['nullable'],
            'delete_images.*.id' => ['required']
        ]);
        $role->name = $req['name'];
        $role->save();

        if (isset($req['delete_images']) && count($req['delete_images']) > 0) {
            $this->handleDeteleImages($req['delete_images'], $role);
        }
        if (isset($req['images']) && count($req['images']) > 0) {
            foreach ($req['images'] as $image) {
                $this->handleUploadImage($image, $role);
            }
        }
        Mail::to('recipient@example.com')->send(new UpdateRoleEmail($role));
        return redirect()->route('dashboard.roles.index');
    }

    private function handleDeteleImages($images, $role)
    {
        $collection = collect($images);
        $imageIds = $collection->pluck('id')->toArray();
        Media::whereIn('id', $imageIds)->delete();
    }

    private function handleUploadImage($image, Role $role)
    {
        $role->addMedia($image)->toMediaCollection(Role::MEDIA_COLLECTION_IMAGE);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('dashboard.roles.index')->with('success', 'role deleted successfuly.');
    }
}
