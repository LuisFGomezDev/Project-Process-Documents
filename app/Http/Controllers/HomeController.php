<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Language;
use App\Role;
use App\User;
use App\Document;
use DB;
use Auth;
use App\GeneralSetting;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function languageSwitch($locale)
    {
        $language = Language::firstOrNew(['id' => 1]);
        $language->code = $locale;
        $language->save();
        return Redirect::back();
    }

    public function generalSetting()
    {
        $ldms_user_data = DB::table('users')->where('id', Auth::id())->first(); 
        if ($ldms_user_data->role_id == 4) {
            $todayDate = date('Y-m-d');
            $interval = date('Y-m-d', strtotime('+30 days'));
            $ldms_expired_documents_all = DB::table('documents')
                                ->where('expired_date', '<', $todayDate)->get();
        
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where([
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                        ])->get();

            $zones_array = array();
            $timestamp = time();
            foreach(timezone_identifiers_list() as $key => $zone) {
                date_default_timezone_set($zone);
                $zones_array[$key]['zone'] = $zone;
                $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
            }

            return view('setting.general_setting', compact('ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'zones_array'));
        }
    }

    public function generalSettingStore(Request $request)
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        
        $data = $request->all();
        //writting timezone info in .env file
        $path = '.env';
        $searchArray = array('APP_TIMEZONE='.env('APP_TIMEZONE'));
        $replaceArray = array('APP_TIMEZONE='.$data['timezone']);

        file_put_contents($path, str_replace($searchArray, $replaceArray, file_get_contents($path)));

        $general_setting = GeneralSetting::firstOrNew(['id' => 1]);
        $general_setting->site_title = $data['site_title'];
        $general_setting->notify_by = $data['notify_by'];
        $logo = $request->site_logo;
        if ($logo) {
            $logoName = $logo->getClientOriginalName();
            $logo->move('public/logo', $logoName);
            $general_setting->site_logo = $logoName;
        }
        $general_setting->save();
        return redirect()->back()->with('message', 'Data updated successfully');
    }

    public function mailSetting()
    {
        $ldms_user_data = DB::table('users')->where('id', Auth::id())->first();
        
        if ($ldms_user_data->role_id == 4) {
            $todayDate = date('Y-m-d');
            $interval = date('Y-m-d', strtotime('+30 days'));
            $ldms_expired_documents_all = DB::table('documents')
                                ->where('expired_date', '<', $todayDate)->get();
        
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where([
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                        ])->get();

            return view('setting.mail_setting', compact('ldms_expired_documents_all', 'ldms_close_expired_documents_all'));
        }
    }

    public function mailSettingStore(Request $request)
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        $data = $request->all();
        //writting mail info in .env file
        $path = '.env';
        $searchArray = array('MAIL_HOST="'.env('MAIL_HOST').'"', 'MAIL_PORT='.env('MAIL_PORT'), 'MAIL_FROM_ADDRESS="'.env('MAIL_FROM_ADDRESS').'"', 'MAIL_FROM_NAME="'.env('MAIL_FROM_NAME').'"', 'MAIL_USERNAME="'.env('MAIL_USERNAME').'"', 'MAIL_PASSWORD="'.env('MAIL_PASSWORD').'"', 'MAIL_ENCRYPTION="'.env('MAIL_ENCRYPTION').'"');
        //return $searchArray;

        $replaceArray = array('MAIL_HOST="'.$data['mail_host'].'"', 'MAIL_PORT='.$data['port'], 'MAIL_FROM_ADDRESS="'.$data['mail_address'].'"', 'MAIL_FROM_NAME="'.$data['mail_name'].'"', 'MAIL_USERNAME="'.$data['mail_address'].'"', 'MAIL_PASSWORD="'.$data['password'].'"', 'MAIL_ENCRYPTION="'.$data['encryption'].'"');
        
        file_put_contents($path, str_replace($searchArray, $replaceArray, file_get_contents($path)));

        return redirect()->back()->with('message', 'Data updated successfully');
    }

    public function smsSetting()
    {
        $ldms_user_data = DB::table('users')->where('id', Auth::id())->first();
        
        if ($ldms_user_data->role_id == 4) {
            $todayDate = date('Y-m-d');
            $interval = date('Y-m-d', strtotime('+30 days'));
            $ldms_expired_documents_all = DB::table('documents')
                                ->where('expired_date', '<', $todayDate)->get();
        
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where([
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                        ])->get();

            return view('setting.sms_setting', compact('ldms_expired_documents_all', 'ldms_close_expired_documents_all'));
        }
    }

    public function smsSettingStore(Request $request)
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        $data = $request->all();
        //writting bulksms info in .env file
        $path = '.env';
        if($data['gateway'] == 'twilio'){
            $searchArray = array('SMS_GATEWAY='.env('SMS_GATEWAY'), 'ACCOUNT_SID='.env('ACCOUNT_SID'), 'AUTH_TOKEN='.env('AUTH_TOKEN'), 'Twilio_Number='.env('Twilio_Number') );

            $replaceArray = array('SMS_GATEWAY='.$data['gateway'], 'ACCOUNT_SID='.$data['account_sid'], 'AUTH_TOKEN='.$data['auth_token'], 'Twilio_Number='.$data['twilio_number'] );
        }
        else{
            $searchArray = array( 'SMS_GATEWAY='.env('SMS_GATEWAY'), 'CLICKATELL_API_KEY='.env('CLICKATELL_API_KEY') );
            $replaceArray = array( 'SMS_GATEWAY='.$data['gateway'], 'CLICKATELL_API_KEY='.$data['api_key'] );
        }

        file_put_contents($path, str_replace($searchArray, $replaceArray, file_get_contents($path)));
        return redirect()->back()->with('message', 'Data updated successfully');
    }
}
