<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function addStaff(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    Rule::unique('users')->whereNull('deleted_at')
                ],
                'password'=>'required|confirmed|min:8',
            ]);
   
            $user = User::create($validated);
            $user->assignRole('staff');

            return redirect()->route('staff.index')->with('success', 'Staff added successfully!');
        }

        return view('staff.create');
    }

    public function updateStaff(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user || !$user->hasRole('staff')) {
            return redirect()->route('staff.index')->with('fail', 'Staff not found');
        }

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    Rule::unique('users')->whereNull('deleted_at')->ignore($user->id)
                ],
            ]);

            $user->fill($validated);
            $user->save();

            return redirect()->route('staff.index')->with('success', 'Staff updated successfully!');
        }

        return view('staff.edit', compact('user'));
    }

    public function staffs(Request $request)
    {
        return view('staff.index');
    }

    public function getStaffs(Request $request)
    {
        $staffs = User::role('staff')->latest()->get();

        return response([
            'status' => 200,
            'message' => 'Users fetched successfully',
            'staffs' => $staffs
        ], 200);
    }

    public function deleteStaff(Request $request, $id)
    {
        $user = User::role('staff')->find($id);

        if (!$user) {
            return redirect()->route('staff.index')->with('fail', 'Staff not found');
        }

        $user->delete();

        return redirect()->route('staff.index')->with('success', 'Staff deleted successfully!');
    }
}
