<?php

use Illuminate\Support\Facades\Route;
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
Route::get('exporter','stockController@exporter')->middleware('auth');
Route::post('importer','stockController@importer')->name('importer')->middleware('auth');

Route::get('/foo', function () {
    Artisan::call('storage:link');
});
Route::get('/', function () {
    return view('app.content');
});
Route::get('utilisateurs/destroy/{id}','userController@destroy')->middleware('auth');
Route::get('maintenances/destroy/{id}','rendezVousController@effacer')->middleware('auth');
Route::get('utilisateurs/reinitialiser/{id}','userController@reinitialiser')->middleware('auth');
Route::get('send-mail','MailSend@mailsend');
Route::get('rendezVous/accept/{id}','rendezVousController@accept')->middleware('auth');
Route::resource('utilisateurs','userController')->middleware('auth');
Route::get('rendezVous/liste/','rendezVousController@liste')->middleware('auth');
Route::put('rendezVous/finished/{id}','rendezVousController@finished')->name('rendezVous.finished')->middleware('auth');
Route::post('rendezVous/reject','rendezVousController@reject')->middleware('auth');
Route::resource('vehicules','vehiculeController')->middleware('auth');
/*Route::get('rendezVous/{id}','rendezVousController@index')->middleware('auth');
*/Route::resource('rendezVous','rendezVousController')->middleware('auth');
Route::get('/calendar','rendezVousController@calendar')->middleware('auth');
Route::get('/vehicule/pression/{id}','vehiculeController@reset')->name('vehicule.pression')->middleware('auth');
Auth::routes();
Route::get('/register','Auth\RegisterController@showFormRegister')->name('register');
Route::get('entreprises','vehiculeController@entreprises')->middleware('auth');
Route::get('maintenances','rendezVousController@maintenances')->name('maintenances')->middleware('auth');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('begin/{id}','vehiculeController@begin')->middleware('auth');
Route::resource('stocks','stockController')->middleware('auth');
Route::get('stocks/destroy/{id}','stockController@remove')->middleware('auth');
Route::get('prediction','predictionController@index')->middleware('auth');
Route::post('prediction','predictionController@store')->name('prediction.store')->middleware('auth');
Route::get('ex/{id}','predictionController@facture')->name('facture')->middleware('auth');
Route::get('test',function(){
	return view('emails.thanks');
});
Route::post('maintenances','predictionController@facture')->name('maintenances.store');
Route::post('vehicules/facture','predictionController@factureV')->name('vehicules.facturer');
Route::post('/vehicules/alert/','vehiculeController@alert')->name('vehicules.alert')->middleware('auth');
Route::post('/prediction/alert','predictionController@alert')->name('predictions.alert')->middleware('auth');
Route::post('changement','vehiculeController@changement')->name('changement.store')->middleware('auth');
Route::post('/user/update','userController@modifier')->name('user.modifier')->middleware('auth');
Route::get('maintenancesRapides','rendezVousController@maintenanceRapide')->middleware('auth');
Route::get('historiques','rendezVousController@historique')->name('historiques')->middleware('auth');
Route::get('historiques/{id}','rendezVousController@hvehicule')->middleware('auth');
Route::put('vehicule/modifRapide/{id}','vehiculeController@modifRapide')->name('vehicules.modifRapide')->middleware('auth');
Route::post('rendezVous/bloquer','rendezVousController@bloquer')->name('rdv.bloquer')->middleware('auth');
Route::get('rdv/debloquer/{id}','rendezVousController@debloquer')->middleware('auth');
Route::get('utiliser','statController@utiliser')->middleware('auth');
Route::post('utiliser','statController@depuis')->name('utiliser.depuis')->middleware('auth');
Route::get('couts','statController@couts')->middleware('auth');
Route::post('stat/update','statController@modifier')->name('stat.store')->middleware('auth');
Route::get('possession','statController@possession')->middleware('auth');
Route::get('flotte/{id}','vehiculeController@flotte')->middleware('auth');
Route::post('/rechercher','vehiculeController@rechercher')->middleware('auth');
Route::get('vehicules/delete/{id}','vehiculeController@delete')->middleware('auth');
Route::post('maintenances/mrapide','rendezVousController@modifierRapide')->name('rendezVous.modifierRapide')->middleware('auth');

Route::get('agenda',function()
{
	return '<iframe src="https://calendar.google.com/calendar/embed?src=5jfn704enpctkok1rjditnds1g%40group.calendar.google.com&ctz=Africa%2FNairobi" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>';
});
Route::get('sauvegarde','stockController@sauvegarde')->middleware('auth');

