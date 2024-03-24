<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $totalRoles = Role::count();
        $permissions = Permission::get();
        return view('backend.roles.index', compact('totalRoles', 'permissions'));
    }

    public function list(Request $request)
    {
        try {
            $totalData = Role::count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'id';
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                $results = Role::offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');

                $results = Role::search($search)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                $totalFiltered = count($results);
            }

            $data = array();
            if (!empty($results)) {
                foreach ($results as $row) {
                    $pers = [];
                    foreach ($row->rolePermissions as $rp) {
                        $pers[] = [
                            'name' => $rp->permission->name,
                            'type' => $rp->permission->type,
                        ];
                    }
                    $nestedData['id'] = $row->id;
                    $nestedData['name'] = $row->name;
                    $nestedData['permissions'] = $pers;
                    $nestedData['action'] = view('backend.roles._actions', [
                        'row' => $row,
                    ])->render();
                    $data[] = $nestedData;
                }
            }

            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data
            );

            echo json_encode($json_data);
        } catch (\Throwable $th) {
            throw $th;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'required',
        ]);

        try {
            $role = new Role();
            $role->name = $request->name;
            $role->save();
            foreach ($request->permissions as $per) {
                $role_per = new RolePermission();
                $role_per->role_id = $role->id;
                $role_per->permission_id = $per;
                $role_per->save();
            }
            return redirect()->back()->with('success', 'Role created!');
        } catch (\Exception $e) {
            $role->delete();
            return redirect()->back()->withErrors('Error occured');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'permissions' => 'required',
        ]);

        try {
            $role = Role::where('id',$request->id)->with('rolePermissions')->first();
            $role->name = $request->name;
            $role->save();
            foreach($role->rolePermissions as $pr) {
                $pr->delete();
            }
            foreach ($request->permissions as $per) {
                $role_per = new RolePermission();
                $role_per->role_id = $role->id;
                $role_per->permission_id = $per;
                $role_per->save();
            }
            return redirect()->back()->with('success', 'Role updated!');
        } catch (\Exception $e) {
            $role->delete();
            return redirect()->back()->withErrors('Error occured');
        }
    }

    public function delete($id)
    {
        $role = Role::with('users')->find($id);
        if ($role && $role->users()->exists()) {
            $users = $role->users;
            foreach ($users as $user) {
                $user->role_id = 1;
                $user->save();
            }
        }
        if ($role) {
            $role->delete();
            return response()->json('Success');
        }
    }
}
