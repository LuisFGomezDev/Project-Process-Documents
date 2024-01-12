<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/', array('before' => 'auth', 'uses' => 'Auth\LoginController@showLoginForm','name'=>'login'));

Route::group(['middleware' => 'auth'], function() {
	Route::get('language-switch/{locale}', 'HomeController@languageSwitch');
	Route::post('/document/import', 'DocumentController@import')->name('document.import');
	Route::get('/document/ldms_create', 'DocumentController@ldmsCreate');
	Route::post('/document/ldms_store', 'DocumentController@ldmsStore');
	Route::get('/document/ldms_edit/{id}', array("uses"=>'DocumentController@ldmsEdit'));
	Route::post('/document/ldms_edit/ldms_update/{id}', 'DocumentController@ldmsUpdate');
	Route::get('/document/ldms_delete/{id}/{fileName}', array("uses"=>'DocumentController@ldmsDelete'));
	Route::get('/document/ldms_alarm_date/{id}', array("uses"=>'DocumentController@ldmsAlarmDate'));
	Route::post('/document/ldms_alarm_date/ldms_alarm_add', 'DocumentController@ldmsAlarmAdd');
	Route::get('/document/ldms_alarm_date/ldms_alarm_delete/{alarm}/{id}/{alarmList}', array("uses"=>'DocumentController@ldmsAlarmDelete'));
	Route::get('/document/ldms_updateProfile', 'DocumentController@ldmsUpdateProfile');
	Route::post('/document/ldms_manageProfileUpdate', 'DocumentController@ldmsManageProfileUpdate');
	Route::post('/document/ldms_changePassword', 'DocumentController@ldmsChangePassword');
	Route::get('/document/ldms_expired_documents', 'DocumentController@ldmsExpiredDocuments');
	Route::get('/document/ldms_close_to_be_expired_documents', 'DocumentController@ldmsCloseToBeExpiredDocuments');
	Route::get('/document/ldms_search', 'DocumentController@ldmsSearch');
	Route::get('/document/ldms_email_send', 'DocumentController@ldmsEmailSend');
	Route::get('general-settings', 'HomeController@generalSetting')->name('setting.general');
	Route::post('general-settingStore', 'HomeController@generalSettingStore')->name('setting.generalStore');
	Route::get('mail-settings', 'HomeController@mailSetting')->name('setting.mail');
	Route::post('mail-settingStore', 'HomeController@mailSettingStore')->name('setting.mailStore');
	Route::get('sms-settings', 'HomeController@smsSetting')->name('setting.sms');
	Route::post('sms-settingStore', 'HomeController@smsSettingStore')->name('setting.smsStore');
});


Route::group(['middleware' => ['auth', 'admin']], function(){

	Route::get('/role/ldms_role_search', 'RolesController@ldmsRoleSearch');
	Route::get('/user/ldms_user_search', 'UserController@ldmsUserSearch');
	Route::resource('role','RolesController');
	Route::get('/user/password', 'UserController@userPass');
	Route::get('user/demo','UserController@demo');
	Route::resource('user','UserController');
});



// Route::get('/getRequest',function(){
// 	if(Request::ajax(){
// 		return 'hello!';
// 	})
// })
