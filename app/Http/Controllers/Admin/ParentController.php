<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\ParentModel;

class ParentController extends Controller
{
    public function index(Request $request)
    {
        $query = ParentModel::with('user');

        if ($request->search) {

            $query->whereHas('user', function($q) use ($request){

                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');

            });
        }

        $parents = $query->latest()->get();

        $totalParents = ParentModel::count();

        return view('admin.parents.index', compact(
            'parents',
            'totalParents'
        ));
    }

    public function create()
    {
        return view('admin.parents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'address' => 'nullable'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password123'),
        ]);

        ParentModel::create([
            'user_id' => $user->id,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()
            ->route('parents.index')
            ->with('success', 'Parent created successfully');
    }

    public function edit($id)
    {
        $parent = ParentModel::with('user')->findOrFail($id);

        return view('admin.parents.edit', compact('parent'));
    }

    public function update(Request $request, $id)
    {
        $parent = ParentModel::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $parent->user->id,
            'phone' => 'required',
            'address' => 'nullable'
        ]);

        $parent->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $parent->update([
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()
            ->route('parents.index')
            ->with('success', 'Parent updated successfully');
    }

    public function destroy($id)
    {
        $parent = ParentModel::findOrFail($id);

        $parent->user()->delete();

        return response()->json([
            'success' => true
        ]);
    }

    public function profile($id)
    {
        $parent = ParentModel::with('user')->findOrFail($id);

        return view('admin.parents.profile', compact('parent'));
    }
}