<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;
use App\Document;
use DB;
use Auth;
use Illuminate\Validation\Rule;

class RolesController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
        $ldms_user_data = DB::table('users')->where('id', Auth::id())->first();
        $ldms_role_data = Role::where('id', $ldms_user_data->role_id)->first();
        $todayDate = date('Y-m-d');
        $interval = date('Y-m-d', strtotime('+30 days'));
        if ($ldms_role_data->title == 'admin') {
            $ldms_expired_documents_all = DB::table('documents')
                                ->where('expired_date', '<', $todayDate)->get();
        
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where([
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                        ])->get();
            $ldms_roles_all = Role::all();
            $ldms_total_roles_number = count($ldms_roles_all);
            $role_list = Role::all();
            return view('role.create', compact('ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_roles_all', 'role_list', 'ldms_total_roles_number'));
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'string|max:255|unique:roles',
        ]);
        $data = $request->all();
        Role::create($data);
        return redirect('role/create');
    }

    public function ldmsRoleSearch(Request $request)
    {
        $ldms_user_data = DB::table('users')->where('id', Auth::id())->first();
        $ldms_role_data = Role::where('id', $ldms_user_data->role_id)->first();
        $todayDate = date('Y-m-d');
        $interval = date('Y-m-d', strtotime('+30 days'));
        if ($ldms_role_data->title == 'admin') {
            $ldms_role_all = Role::all();
            $ldms_expired_documents_all = DB::table('documents')
                                    ->where('expired_date', '<', $todayDate)->get();
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where([
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                        ])->get();
            
            $ldms_role_title = $_GET['ldms_roleTitleSearch'];
            $role_list = DB::table('roles')
                            ->where('title', $ldms_role_title)->get();

            if (count($role_list)==0) {
                return redirect()->back()->with('message1', 'Searched item does not exists.');
            }

            return view('role.search', compact('ldms_role_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'role_list'));
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $ldms_user_data = DB::table('users')->where('id', Auth::id())->first();
        $todayDate = date('Y-m-d');
        $interval = date('Y-m-d', strtotime('+30 days'));
        $ldms_expired_documents_all = DB::table('documents')
                                ->where('expired_date', '<', $todayDate)->get();
        $ldms_close_expired_documents_all = DB::table('documents')
                    ->where([
                        ['expired_date', '>=', $todayDate],
                        ['expired_date', '<' , $interval]
                    ])->get();
        $data = Role::findOrFail($id);
        return view('role.edit', compact('data', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [

            'title' => [
                'required',
                Rule::unique('roles')->ignore($id),
            ],
         ]);

        $input = $request->all();
        $data = Role::findOrFail($id);
        $status =  $data->update($input);
        return redirect('role/create')->with('message', 'Role Updated Successfully');
    }

    public function destroy($id)
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        
        $lamds_role_data = Role::findOrFail($id);
        $ldms_document_data = Document::where('role_id', $id)->get();
        $ldms_user_data = User::where('role_id', $id)->get();
        
        foreach ($ldms_user_data as $data) {
            $data->delete();
        }

        foreach ($ldms_document_data as $data) {
            $data->delete();
        }
        $lamds_role_data->delete();
        return redirect('role/create')->with('message', 'Data Deleted Successfully');
    }
}
