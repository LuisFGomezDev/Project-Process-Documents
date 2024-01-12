<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Auth;
use App\Role;
use App\User;
use App\Mail\UserNotification;
use DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;
use Clickatell\Rest;
use Clickatell\ClickatellException;

class UserController extends Controller
{

    public function create()
    {
        $todayDate = date('Y-m-d');
        $interval = date('Y-m-d', strtotime('+30 days'));
        $ldms_expired_documents_all = DB::table('documents')
                                ->where('expired_date', '<', $todayDate)->get();
        
        $ldms_close_expired_documents_all = DB::table('documents')
                    ->where([
                        ['expired_date', '>=', $todayDate],
                        ['expired_date', '<' , $interval]
                    ])->get();
        $ldms_users_all = User::all();
        $ldms_total_users_number = count($ldms_users_all);
        $ldms_user_list = User::all();
        $ldms_roles = Role::pluck('title', 'id');
        return view('user.create', compact('ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_users_all', 'ldms_user_list', 'ldms_total_users_number', 'ldms_roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'max:255',
            'email' => 'email|max:255|unique:users',
            'password' => 'min:6',
        ]);
        $data = $request->all();
        $ldms_general_setting_data = \App\GeneralSetting::latest()->first();
        if($ldms_general_setting_data->notify_by == 'email'){
            try{
                Mail::send( 'mail.notification', $data, function( $message ) use ($data)
                {
                    $message->to( $data['email'] )->subject( 'User Account Details' );
                });
                $message = ' User created successfully.';
            }
            catch(\Exception $e){
                $message = ' User created successfully. Please setup your mail setting to send mail.';
            }
        }
        else {
            if( env('SMS_GATEWAY') == 'twilio') {
                $account_sid = env('ACCOUNT_SID');
                $auth_token = env('AUTH_TOKEN');
                $twilio_phone_number = env('Twilio_Number');
                try{
                    $client = new Client($account_sid, $auth_token);
                    $client->messages->create(
                        $data['mobile_no'],
                        array(
                            "from" => $twilio_phone_number,
                            "body" => 'User Name : '.$data['name'].' Password : '.$data['password']
                        )
                    );
                    $message = 'User created successfully.';
                }
                catch(\Exception $e){
                    $message = 'User created successfully. Please setup your SMS Setting to send SMS';
                }
            }
            elseif( env('SMS_GATEWAY') == 'clickatell') {
                try {
                    $clickatell = new \Clickatell\Rest(env('CLICKATELL_API_KEY'));
                    $result = $clickatell->sendMessage(['to' => [$data['mobile_no']], 'content' => 'User Name : '.$data['name'].' Password : '.$data['password']]);
                    $message = 'User created successfully.';
                } 
                catch (ClickatellException $e) {
                    $message = 'User created successfully. Please setup your SMS Setting to send SMS';
                }
            }
            else
                $message = 'User created successfully. Please setup your SMS Setting to send SMS';
        }

        $data['password'] = bcrypt($data['password']);
        User::create($data);
        return redirect('user/create')->with('message', $message);
    }

    public function ldmsUserSearch()
    {
        $userData = DB::table('users')->where('id', Auth::id())->first();
        $todayDate = date('Y-m-d');
        $interval = date('Y-m-d', strtotime('+30 days'));
        
        $ldms_users_all = User::all();
        $ldms_expired_documents_all = DB::table('documents')
                                ->where('expired_date', '<', $todayDate)->get();
        $ldms_close_expired_documents_all = DB::table('documents')
                    ->where([
                        ['expired_date', '>=', $todayDate],
                        ['expired_date', '<' , $interval]
                    ])->get();
        
        $ldms_user_name = $_GET['ldms_userNameSearch'];
        $ldms_user_list = DB::table('users')
                        ->where('name', $ldms_user_name)->get();
        $ldms_roles = Role::pluck('title', 'id');
        if (count($ldms_user_list)==0) {
            return redirect()->back()->with('message1', 'Searched item does not exists.');
        }

        return view('user.search', compact('ldms_users_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_user_list', 'ldms_roles'));
    }

    
    public function edit($id)
    {
        $todayDate = date('Y-m-d');
        $interval = date('Y-m-d', strtotime('+30 days'));
        $ldms_expired_documents_all = DB::table('documents')
                                ->where('expired_date', '<', $todayDate)->get();
        $ldms_close_expired_documents_all = DB::table('documents')
                    ->where([
                        ['expired_date', '>=', $todayDate],
                        ['expired_date', '<' , $interval]
                    ])->get();
        $ldms_user_data = User::findOrFail($id);
        $ldms_role_all = Role::all();
        return view('user.edit', compact('ldms_user_data', 'ldms_role_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all'));
    }

    public function update(Request $request, $id)
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        $this->validate($request, [
            'email' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
         ]);
        $input = $request->all();
        $ldms_user_data = User::findOrFail($id);
        $ldms_user_data->update($input);
        return redirect('user/create')->with('message', 'User Data Updated Successfully');
    }

    public function destroy($id)
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        
        $data = User::findOrFail($id);
        $data->delete();
        return redirect('user/create')->with('message', 'User Data Deleted Sucessfully');
    }

    public function userPass()
    {
        echo str_random(8);
    }
}
