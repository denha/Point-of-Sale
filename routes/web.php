<?php
use App\Stock;
use App\modules;
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

//Route::get('/', function () {
    //return view('welcome');
//});

//Route::get('/abouts/{id}/{name}',function ($id,$name){

    //return $id. $name;
//});

//Route::get('/denis','PagesController@index');
//Route::get('/services','PagesController@services');
//Route::get('/about','PagesController@about');



Route::get('users','StocksController@fetch');

Route::post('/list','StocksController@store');
/*Route::post('/list',function(Request $request){
return response()->json(['message'=>$request['text1']])->name('list');
});*/
Route::post('edit/{id}','StocksController@update');
Route::post('delete/{id}','StocksController@destroy');


Route::get('/CodeGenerator','CodeGeneratorsController@index');
Route::get('CodeGenerator/tblnames','CodeGeneratorsController@gettblnames');
Route::post('CodeGenerator/send','CodeGeneratorsController@buildcode');
// Auto generated Routes for table modules 
Route::get('/modules','modulesController@index');
Route::get('/viewmodules','modulesController@view');
Route::post('/savemodules','modulesController@save');
Route::post('/editmodules/{id}','modulesController@update');
Route::post('/destroymodules/{id}','modulesController@destroy');
Route::get('/menu','modulesController@sidemenu');
Route::get('/combomodules','modulesController@combomodules');

// Auto generated Routes for table suppliers 
Route::get('/suppliers','suppliersController@index');
Route::get('/viewsuppliers','suppliersController@view');
Route::post('/savesuppliers','suppliersController@save');
Route::post('/editsuppliers/{id}','suppliersController@update');
Route::post('/destroysuppliers/{id}','suppliersController@destroy');
Route::get('/supplierscombo','suppliersController@viewcombo');

// Auto generated Routes for table requirements 
Route::get('/requirements','requirementsController@index');
Route::get('/viewrequirements','requirementsController@view');
Route::post('/saverequirements','requirementsController@save');
Route::post('/editrequirements/{id}','requirementsController@update');
Route::post('/destroyrequirements/{id}','requirementsController@destroy');
// Auto generated Routes for table requirements 
Route::get('/requirements','requirementsController@index');
Route::get('/viewrequirements','requirementsController@view');
Route::post('/saverequirements','requirementsController@save');
Route::post('/editrequirements/{id}','requirementsController@update');
Route::post('/destroyrequirements/{id}','requirementsController@destroy');
// Auto generated Routes for table requirements 
Route::get('/requirements','requirementsController@index');
Route::get('/viewrequirements','requirementsController@view');
Route::post('/saverequirements','requirementsController@save');
Route::post('/editrequirements/{id}','requirementsController@update');
Route::post('/destroyrequirements/{id}','requirementsController@destroy');
// Auto generated Routes for table customers 
Route::get('/customers','customersController@index');
Route::get('/viewcustomers','customersController@view');
Route::post('/savecustomers','customersController@save');
Route::post('/editcustomers/{id}','customersController@update');
Route::post('/destroycustomers/{id}','customersController@destroy');
Route::get('/customerscombo','customersController@viewcombo');
// Auto generated Routes for table categories 
Route::get('/categories','categoriesController@index');
Route::get('/viewcategories','categoriesController@view');
Route::post('/savecategories','categoriesController@save');
Route::post('/editcategories/{id}','categoriesController@update');
Route::post('/destroycategories/{id}','categoriesController@destroy');
Route::get('/categoriescombo','categoriesController@viewcombo');
// Auto generated Routes for table subcategories 
Route::get('/subcategories','subcategoriesController@index');
Route::get('/viewsubcategories','subcategoriesController@view');
Route::post('/savesubcategories','subcategoriesController@save');
Route::post('/editsubcategories/{id}','subcategoriesController@update');
Route::post('/destroysubcategories/{id}','subcategoriesController@destroy');
Route::get('/subcategoriescombo','subcategoriesController@viewcombo');
// Auto generated Routes for table uoms 
Route::get('/uoms','uomsController@index');
Route::get('/viewuoms','uomsController@view');
Route::post('/saveuoms','uomsController@save');
Route::post('/edituoms/{id}','uomsController@update');
Route::post('/destroyuoms/{id}','uomsController@destroy');
Route::get('/uomscombo','uomsController@viewcombo');

// Auto generated Routes for table stocks 
Route::get('/stocks','stocksController@index');
Route::get('/viewstocksbranch','stocksController@view');
Route::post('/savestocks','stocksController@save');
//Route::get('/viewstockbranch','stocksController@view');
//Route::post('//viewstock/ocks','stocksController@save');
Route::post('/editstocks/{id}','stocksController@update');
Route::post('/destroystocks/{id}','stocksController@destroy');
Route::get('/stockscombo/{id}','stocksController@viewcombo');
Route::get('/bybranch','stocksController@bybranch');
// Auto generated Routes for table posts 
Route::get('/posts','postsController@index');
Route::get('/viewposts','postsController@view');
Route::post('/saveposts','postsController@save');
Route::post('/editposts/{id}','postsController@update');
Route::post('/destroyposts/{id}','postsController@destroy');
Route::get('/comboposts','postsController@viewcombo');
// Auto generated Routes for table purchaseheaders 
Route::get('/purchaseheaders','purchaseheadersController@index');
Route::get('/viewpurchaseheaders','purchaseheadersController@view');
Route::post('/savepurchaseheaders','purchaseheadersController@save');
Route::post('/editpurchaseheaders/{id}','purchaseheadersController@update');
Route::post('/destroypurchaseheaders/{id}','purchaseheadersController@destroy');
Route::get('/combopurchaseheaders','purchaseheadersController@viewcombo');
Route::get('/maxnumber','purchaseheadersController@maximum');
Route::get('/purchasesales','purchaseheadersController@salesindex');
Route::post('/savesales','purchaseheadersController@savesales');
Route::post('/savestransfers','purchaseheadersController@savetransfers');
Route::post('/savetransfertrans','purchaseheadersController@savetransfertrans');
// Auto generated Routes for table modeofpayments 
Route::get('/modeofpayments','modeofpaymentsController@index');
Route::get('/viewmodeofpayments','modeofpaymentsController@view');
Route::post('/savemodeofpayments','modeofpaymentsController@save');
Route::post('/editmodeofpayments/{id}','modeofpaymentsController@update');
Route::post('/destroymodeofpayments/{id}','modeofpaymentsController@destroy');
Route::get('/combomodeofpayments','modeofpaymentsController@viewcombo');
// Auto generated Routes for table stocktrans 
Route::get('/stocktrans','stocktransController@index');
Route::get('/viewstocktrans','stocktransController@view');
Route::post('/savestocktrans','stocktransController@save');
Route::post('/savesalespurchases','stocktransController@savesales');
Route::post('/editstocktrans/{id}','stocktransController@update');
Route::post('/destroystocktrans/{id}','stocktransController@destroystocks');
Route::get('/combostocktrans','stocktransController@viewcombo');
Route::get('viewitempurchase/{id}','stocktransController@viewstock');
Route::get('/viewstocks','stocksController@viewstocks');
//Route for reports
Route::get('/salesreport','reportsController@index');
Route::get('/viewdaily','reportsController@viewdaily');
Route::get('/purchasereport','reportsController@purchasereport');
Route::get('/stockreport','reportsController@stockreport');
Route::get('/viewdailypurchase','reportsController@viewdailypurchase');
Route::get('/viewdailystock','reportsController@viewdailystock');
Route::get('/pdtbranch/{id}/{bra}','reportsController@productavailable');

Route::get('/outstandings','outstandingsController@index');
Route::get('/outstandingcusto','reportsController@outstandingcusto');
Route::get('/pending','pendingsController@index');
Route::get('pendingreport','reportsController@pending');

// Auto generated Routes for table branches 
Route::get('/branches','branchesController@index');
Route::get('/viewbranches','branchesController@view');
Route::post('/savebranches','branchesController@save');
Route::post('/editbranches/{id}','branchesController@update');
Route::post('/destroybranches/{id}','branchesController@destroy');
Route::get('/combobranches','branchesController@viewcombo');
// stock Transfers
Route::get('/stocktransfers','stocktransfersController@index');
Route::post('/stockquantity','stocktransController@stocktransfer');


// Auto generated Routes for table accounttypes 
Route::get('/accounttypes','accounttypesController@index');
Route::get('/viewaccounttypes','accounttypesController@view');
Route::post('/saveaccounttypes','accounttypesController@save');
Route::post('/editaccounttypes/{id}','accounttypesController@update');
Route::post('/destroyaccounttypes/{id}','accounttypesController@destroy');
Route::get('/comboaccounttypes','accounttypesController@viewcombo');
// Auto generated Routes for table chartofaccounts 
Route::get('/chartofaccounts','chartofaccountsController@index');
Route::get('/viewchartofaccounts','chartofaccountsController@view');
Route::post('/savechartofaccounts','chartofaccountsController@save');
Route::post('/editchartofaccounts/{id}','chartofaccountsController@update');
Route::post('/destroychartofaccounts/{id}','chartofaccountsController@destroy');
Route::get('/combochartofaccounts/{id}','chartofaccountsController@viewcombo');
Route::get('/combochartofaccounts','chartofaccountsController@viewcombo1');
// Auto generated Routes for table accounttrans 
Route::get('/accounttrans','accounttransController@index');
Route::get('/viewaccounttrans','accounttransController@view');
Route::post('/saveaccounttrans','accounttransController@save');
Route::post('/editaccounttrans/{id}','accounttransController@update');
Route::post('/destroyaccounttrans/{id}','accounttransController@destroy');
Route::get('/comboaccounttrans','accounttransController@viewcombo');

Route::get('/expenses','accounttransController@viewexpenses');
Route::post('/saveexpenses','accounttransController@saveexpenses');
Route::get('/viewtrans/{id}/{id2}','accounttransController@viewtrans');
Route::post('/updatebranch','accounttransController@updatebranch');
Route::post('/updatebranch1','accounttransController@updatebranch1');
Route::get('viewexpenses/{id}','accounttransController@editexpenses');
Route::get('viewtotals/{id}','accounttransController@viewincomes');
Route::post('/incomeedit','accounttransController@incomeedit');
Route::get('/viewexp/{id}','accountingreportsController@viewexp');
Route::get('/viewInc/{id}','accountingreportsController@viewInc');
Route::get('/ledgers','accountingreportsController@index');
Route::get('/ledgerrports','accountingreportsController@ledger');
Route::get("/chartofaccountpreview","chartofaccountsController@chartofaccountpreview");
Route::post("/importchartofaccounts","chartofaccountsController@importchartofaccount");
Route::get('/totalexpenses','accountingreportsController@totalexpensesindex');
Route::get('allexpenses','accountingreportsController@totalexpenses');

Route::get('/trialbalance','accountingreportsController@indextrialbalance');
Route::get('/trialbalancerpt','accountingreportsController@trialbalance');

Route::get('/balancesheet','accountingreportsController@indexbalancesheet');
Route::get('/balancesheetrpt','accountingreportsController@balancesheet');

Route::get('/otherincomes','accounttransController@viewotherincomes');

Route::post('/saveotherincomes','accounttransController@saveotherincomes');

Route::get('/incomestats','accountingreportsController@viewincomestats');
Route::get('/incomestatementrpt','accountingreportsController@incomestatement');

Route::get('/inventorysettings','chartofaccountsController@inventorysettings');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Auto generated Routes for table companynames 
Route::get('/companynames','companynamesController@index');
Route::get('/viewcompanynames','companynamesController@view');
Route::post('/savecompanynames','companynamesController@save');
Route::post('/editcompanynames/{id}','companynamesController@update');
Route::post('/destroycompanynames/{id}','companynamesController@destroy');
Route::get('/combocompanynames','companynamesController@viewcombo');
Auth::routes();
Route::get('/','LoginController@Index');
//Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware'=>'auth'],function(){
    Route::get('/dash','dashboardsController@index')->name('dashboard');



});

Route::get('/totalincome','accountingreportsController@indextotalincome');
Route::get('/allincomes','accountingreportsController@totalincome');
Route::get('registers','LoginController@registerindex');
Route::get("/viewjournelfooters/{id}","journelsController@viewjournelfooters");
// Auto generated Routes for table users 
Route::get('/users','usersController@index');
Route::get('/viewusers','usersController@view');
Route::post('/saveusers','usersController@save');
Route::post('/editusers/{id}','usersController@update');
Route::post('/destroyusers/{id}','usersController@destroy');
Route::get('/combousers','usersController@viewcombo');
// Auto generated Routes for table financialyears 
Route::get('/financialyears','financialyearsController@index');
Route::get('/viewfinancialyears','financialyearsController@view');
Route::post('/savefinancialyears','financialyearsController@save');
Route::post('/editfinancialyears/{id}','financialyearsController@update');
Route::post('/destroyfinancialyears/{id}','financialyearsController@destroy');
Route::get('/combofinancialyears','financialyearsController@viewcombo');
Route::get('/activeyear','financialyearsController@activeyear');
Route::get('/itemprofits','reportsController@indexprofit');
Route::get('/totalprofits','reportsController@totalprofits');
Route::get('/fundtransfers','fundtransfersController@index');
Route::post('/savetransferheaders','fundtransfersController@savetransferheaders');
Route::get('/journels','journelsController@index');
Route::post('/journelsave','journelsController@journelsave');
Route::post('/journelheader','journelsController@journelheader');
Route::post('/importstock','stocksController@importstock');
Route::post('/savebalance','stockbalancesController@stockbalance');
Route::post('/savebalance2','stockbalancesController@pendingpayments');
Route::post('/destroysalesrecord/{id}','stocktransController@destorys');
Route::post('/upDateUrl','stocktransController@updaterow');
Route::post('/deletesales','stocktransController@deletesales');
Route::post('/updatepurchase','stocktransController@updatepurchase');
Route::post('/editxpenses','editxpensesController@editexpenses');
Route::post('editincome','editxpensesController@editincomes');
Route::post('deleteincome2','editxpensesController@deleteincome2');
Route::post('destroysincome1/{id}','editxpensesController@delincome1');
Route::get('dashboardhome','dashboardsController@index');
Route::get('dashboardhome1','dashboardsController@totaloutstanding');
Route::post('updatestockbranch','stocktransController@updatestockbranch');
Route::post('editpurchases','stocktransController@editpurchases');
Route::get('viewstockout/{id}','stocktransController@viewstockout');
Route::get('viewstock/{id}','stocktransController@viewstock');
Route::Post('barcode','stocktransController@editsales');
Route::get('viewexp/{id}','accountingreportsController@viewexp');
Route::post('expenseedit','accounttransController@expenseedit');
Route::post('delxp/{id}','stocktransController@delxp');
Route::get("viewtransfer/{id}","stocktransfersController@viewtransfers");
Route::post('stocktransferedit','stocktransfersController@stocktransferedit');
Route::post('transferdel/{id}','stocktransfersController@transferdel');
Route::get('transferreports','stocktransfersController@transferreports');
Route::get('/transferview','stocktransfersController@transferview');
Route::POST('/deletetransfers/{id}','stocktransfersController@deletetransfers');
//Route::post('/updatestocktransferb','stocktransfersController@updatestockbranch');
Route::get('/try','productsController@news');
Route::get('exception/index', 'ExceptionController@index');

// our examples 

Route::get('/example','workersController@view');
Route::get('/barcode','productsController@index');
Route::get("/barcodesales","productsController@barcodesales");
Route::post('/editbarcodesales','productsController@editbarcodesales');
Route::post('/barcodesalessave','productsController@barcodesalessave');
Route::get('/search/{key}','productsController@search');
// Auto generated Routes for table companys 
Route::get('/companys','companysController@index');
Route::get('/viewcompanys','companysController@view');
Route::post('/savecompanys','companysController@save');
Route::post('/editcompanys/{id}','companysController@update');
Route::post('/destroycompanys/{id}','companysController@destroy');
Route::get('/combocompanys','companysController@viewcombo');
Route::post('/createcompany','companysController@createcompany');
Route::get('/ledgerpdf/{acode}/{date1}/{date2}/{day1}/{day2}','workersController@ledger');
Route::get('/trialbalancepdf/{date1}/{date2}/{day1}/{day2}','workersController@trialbalancepdfs');
Route::get("/bsheetpdf/{date1}/{date2}/{date3}","workersController@bsheetpdf");
Route::get("/viewcode/{id}","workersController@viewcode");
Route::get("/viewcodeaccount/{id}","accountingreportsController@viewcodeaccount");
Route::get("/incomestatepdf/{date1}/{date2}/{day1}/{day2}","retainedearningsController@incomestatepdf");
Route::get("/bsheetpdf/{date1}/{date2}/{date3}","workersController@bsheetpdf");
Route::get('/journelreports','journelsController@journelreports');
Route::post('/destroyjournel/{id}','journelsController@destroy');
Route::get('/viewjournel','journelsController@viewjournelreport');
Route::get("/expensepreview/{date1}/{date2}","workersController@expensepreview");
Route::get("/incomepreview/{date1}/{date2}","workersController@incomepreview");

Route::get("/reciept","recieptprinterController@reciept");

// Auto generated Routes for table bankings 
Route::get('/bankings','bankingsController@index');
Route::get('/viewbankings','bankingsController@view');
Route::post('/savebankings','bankingsController@save');
Route::post('/editbankings/{id}','bankingsController@update');
Route::post('/destroybankings/{id}','bankingsController@destroy');
Route::get('/combobankings','bankingsController@viewcombo');
Route::get("/bankaccounts","bankingsController@bankaccounts");
Route::post('/editinventoryaccounts/{id}','chartofaccountsController@inventoryaccounts');
Route::get('/isComplete','purchaseheadersController@isComplete');
// Auto generated Routes for table itemgroups 
Route::get('/itemgroups','itemgroupsController@index');
Route::get('/viewitemgroups','itemgroupsController@view');
Route::post('/saveitemgroups','itemgroupsController@save');
Route::post('/edititemgroups/{id}','itemgroupsController@update');
Route::post('/destroyitemgroups/{id}','itemgroupsController@destroy');
Route::get('/comboitemgroups','itemgroupsController@viewcombo');
Route::get("/stockgroupview","reportsController@stockgroupview");
Route::get("salesexcel/{id}/{date1}/{date2}","exportexecelController@salereportexcel");
Route::get("purchaseexcel/{id}/{date1}/{date2}","exportexecelController@purchasereportexcel");
Route::get("/stockcategoryview","reportsController@stockcategoryview");
Route::get("expenseexcel/{id}/{date1}/{date2}","exportexecelController@expensereportexcel");
Route::get("bankexcel/{id}/{date1}/{date2}/{bank}","exportexecelController@bankreportexcel");
Route::get("itemfifos","itemfifosController@index");
Route::post("updatequantity","productsController@updatequantity");
Route::POST("delbarcodeitem","productsController@delbarcodeitem");
Route::get("updatequa",'stocksController@updatequa');
Route::get("salespending","reportsController@salespendings");
Route::get("viewsalespendings","reportsController@viewsalespendings");
Route::POST("/savependings","productsController@savependings");
Route::get('/customerledger','reportsController@customerLedger');
Route::get('/customerledgerview','reportsController@customerledgerview');
Route::POST("/sendmsg","reportsController@sendmessages");
Route::get("/customerled/{date1}/{date2}/{id}","workersController@customerled");
Route::get("/salescredits/{date1}/{date2}","workersController@salescredits");
Route::get("/notifications","notificationsController@notifications");
Route::get("/viewnotifications","notificationsController@viewnotifications");
Route::get("/editbarcodesales/{id}/{id2}","productsController@stockeditbarcode");
Route::POST("/editchanges/{id}","productsController@editchanges");
Route::POST("/editsalesconvert","productsController@editsales");
Route::get("/salesconversion","salesconversionController@salesconversion");
Route::post("/editsconversion","salesconversionController@editsconversion");
Route::post("/saveconversion","salesconversionController@saveconversion");
Route::POST("/printbars/{id}","printbarcodesController@printbarcode");
Route::POST("/printbarselect","printbarcodesController@printbarselect");
Route::POST("/editbarcodepurchases","purchaseheadersController@editbarcodepurchases");
Route::POST("barcodepurchasesave","purchaseheadersController@barcodepurchasesave");
Route::get("/checkPrint","printbarcodesController@checkPrint");
Route::get("/editbarcodepurchase/{id}/{id2}","purchaseheadersController@stockeditbarcode");
Route::POST("/editpurchaseconvert","purchaseheadersController@editPurchases");
Route::POST("/changePurchases/{id}","purchaseheadersController@changePurchases");
Route::get("/stockdetails","stocksController@stockdetails");
Route::get("/viewstockdetails","stocksController@getstockdetails");
Route::get("stockdetal/{excel}/{id}","exportexecelController@stockdetail");
Route::get("doubleClient/{id}","reportsController@doubleClient");
Route::get("dbcustomerledgerview/{id}","reportsController@dbcustomerledgerview");

// New Routes for the new purchurses

Route::get("/newpurchase","newpurchaseController@index");
Route::post("/savenewpurchase","newpurchaseController@savenewpurchase");
Route::get("newmaximum","newpurchaseController@maximum");
Route::post("/saveinvoices",'newpurchaseController@saveinvoices');
Route::get("/viewnewpurchase/{id}","newpurchaseController@viewnewpurchase");
Route::POST("/editnewpurchases","newpurchaseController@editnewpurchases");
Route::POST("/delnewpurchase/{id}","newpurchaseController@delnewpurchase");
Route::get("/invoicereports","newpurchaseController@invoicereports");
Route::get("/viewinvoicereports","newpurchaseController@viewinvoicereports");
Route::get("/invoiceadd/{id}","invoicesreportsController@invoiceadd");
Route::POST("/saveinvoiceexpense","invoicesreportsController@saveinvoiceexpense");
Route::POST("/saveinvoicesexp","invoicesreportsController@saveinvoicesexp");
Route::POST("/saveinvoicesexpedit","invoicesreportsController@saveinvoicesexpedit");
Route::get("/stockentry/{id}","invoicesreportsController@stockentry");
Route::get("/viewstockentry/{id}","invoicesreportsController@viewstockentry");
Route::POST("/updatestockentry","invoicesreportsController@updatestockentry");
ROute::POST("/savecalculatedstock","invoicesreportsController@savecalculatedstock");
Route::get("/editnewpurchase/{id}","newpurchaseController@editnewpurchase");
Route::get("/newpurchasereports","newpurchaseController@newpurchasereports");
Route::get("/newpurchasereportviews","newpurchaseController@newpurchasereportviews");
Route::POST("/destorypurexp/{id}","newpurchaseController@destorys");
Route::get("/newpurchaseexcel/{id}/{date1}/{date2}","newpurchaseController@purchasereportexcel");
Route::get("/recievedstock","invoicesreportsController@recievedstock");
Route::get("/viewrecieved","newpurchaseController@viewrecieved");
Route::post("/delrecievedstoc/{id}","newpurchaseController@delrecievedstoc");
Route::get("/stockexcel/{id}/{date1}/{date2}","newpurchaseController@stockexcel");
