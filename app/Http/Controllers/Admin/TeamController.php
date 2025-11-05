<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function team_list()
    {
        $teams = Team::latest()->get();
        return view('admin.team.list', compact('teams'));
    }

    public function create_team()
    {
        return view('admin.team.create');
    }
    public function team_store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            $team = new Team();
            $team->name        = $request->name;
            $team->designation = $request->designation;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'teams/';
                $file->move(public_path($path), $filename);
                $team->image = $path . $filename;
            }

            $team->save();

            return response()->json([
                'status'  => true,
                'message' => 'Team member added successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Error occurred',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
    public function team_edit($id)
    {
        $team = Team::findOrFail($id);
        return view('admin.team.edit', compact('team'));
    }

    public function team_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $team = Team::findOrFail($request->id);
        $team->name = $request->name;
        $team->designation = $request->designation;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'team/';
            $file->move(public_path($path), $filename);
            $team->image = $path . $filename;
        }

        $team->save();

        return response()->json(['status' => true]);
    }
    public function team_destroy($id)
    {
        try {
            $team = Team::findOrFail($id);

            // Delete image if exists
            if ($team->image && file_exists(public_path($team->image))) {
                unlink(public_path($team->image));
            }

            $team->delete();

            return response()->json([
                'status' => true,
                'message' => 'Team member deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
