<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Models\ApiProvider;
use App\Models\WalletHistory;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ManageApiController extends Controller
{
    public function home()
    {
        $pageTitle = 'Manage API Website';

        // User Info
        $widget['full_time_profits'] = 0;
        $widget['monthly_profits'] = 0;
        $widget['weekly_profits'] = 0;
        $widget['daily_profits'] = 0;

        $widget['full_time_profits'] = WalletHistory::successful()
        ->whereNotNull('api_trx_id')
        ->where('transaction_type', 2)
        ->sum('final_amo');

        $widget['monthly_profits'] = WalletHistory::successful()
        ->whereNotNull('api_trx_id')
        ->where('transaction_type', 2)
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->sum('final_amo');

        $widget['weekly_profits'] = WalletHistory::successful()
        ->whereNotNull('api_trx_id')
        ->where('transaction_type', 2)
        ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
        ->sum('final_amo');
    
        $widget['daily_profits'] = WalletHistory::successful()
        ->whereNotNull('api_trx_id')
        ->where('transaction_type', 2)
        ->whereDate('created_at', now()->toDateString())
        ->sum('final_amo');

        $currentMonth = Carbon::now()->format('F'); 
        $apiProviderData = ApiProvider::query()->searchable(['domain','username', 'password', 'token', 'balance'])->orderBy('id','desc')->paginate(getPaginate());

        return view('admin.api.home', compact('pageTitle', 'widget', 'currentMonth', 'apiProviderData'));
    }

    public function updateGeneralSettings(Request $request){
        $request->validate([
            'status_connect_api' => 'required',
            'default_api_product_status' => 'required'
        ]);

        $general = GeneralSetting::findOrFail(1);
        $general->status_connect_api = $request->status_connect_api? Status::ENABLE : Status::DISABLE;
        $general->default_api_product_status = $request->default_api_product_status? Status::ENABLE : Status::DISABLE;
        $general->save();

        $notify[] = ['success','API General Settings updated successfully'];
        return back()->withNotify($notify);
    }

    public function new(){ 
        $pageTitle = 'Add Product';
        $formAction = route('admin.api.add');

        return view('admin.api.new',compact('pageTitle', 'formAction'));
    }

    public function add(){
		$this->addNewApi();

    	$notify[] = ['success', 'Api Connected successfully'];
	    return back()->withNotify($notify);
    }

    private function addNewApi(){
		
		$request = request();

        $postData = $request->all();

        $rule['domain'] = "required|url";

        $request->validate([
            'type' => 'required|in:no1logs,CMSNT'
        ]);

        if($postData['type'] === "no1logs"){
            $rule['token'] = "required";
        }else{
            $rule['username'] = "required";
            $rule['password'] = "required";
        }

		$request->validate($rule);
        $price = '';

        if($postData['type'] === "no1logs"){
            $data = curl_get($postData['domain'] . "/api/v1/check-balance?api_token=" . $postData['token']);
            $response = json_decode($data, true);
            if(isset($data['status']) && $data['status'] == 'error'){
                $notify[] = ['error', 'There was an error connecting to the API'];
            }
            $price = $response['balance'];
        }else{
            $response = curl_get($postData['domain'] . "/api/GetBalance.php?username=" . $postData['username'] . "&password=".$postData['password']);
            $price = format_currency($response, true);
            if(isset($data['status']) && $data['status'] == 'error'){
                $notify[] = ['error', 'There was an error connecting to the API'];
                return back()->withNotify($notify);
            }
        }

		$apiProvider = new ApiProvider; 
		
        if($postData['type'] === "no1logs"){
            $apiProvider->domain = $request->domain;
            $apiProvider->type = $request->type; 
            $apiProvider->token = $request->token;
            $apiProvider->base_currency = "₦";
            $apiProvider->balance = $price;
            $apiProvider->status = 1;
        }else{
            $apiProvider->domain = $request->domain;
            $apiProvider->type = $request->type; 
            $apiProvider->username = $request->username;
            $apiProvider->password = $request->password;
            $apiProvider->base_currency = "$";
            $apiProvider->balance = $price;
            $apiProvider->status = 1;
        }

    	$apiProvider->save();

		return $apiProvider;
	}

    public function detail($id)
    {
        $currTab = request()->query("tab");

        if(!$this->isValidDetailsParam($currTab)){
            abort("404");
        }

        $allData = [];
        $apiProvider = ApiProvider::findOrFail($id);
        $pageTitle = 'API Connection - ' . $apiProvider->domain;

        $totalEarnings = WalletHistory::successful()
        ->whereNotNull('api_trx_id')
        ->where('api_provider_id', $apiProvider->id)
        ->where('transaction_type', 2)
        ->sum('final_amo');

        $totalOrder = $totalRecordCount = WalletHistory::successful()
        ->whereNotNull('api_trx_id')
        ->where('api_provider_id', $apiProvider->id)
        ->where('transaction_type', 2)
        ->count();

        if($currTab === "categories"){
            $allData = Category::where('api_provider_id', $apiProvider->id)
            ->searchable(['name'])
            ->paginate(getPaginate());
        }

        if($currTab === "products"){
            $allData = Product::where('api_provider_id', $apiProvider->id)
            ->searchable(['name'])
            ->paginate(getPaginate());
        }

        if($currTab === "orders"){
            $allData = WalletHistory::successful()->with(['user', 'gateway'])
            ->searchable(['api_trx_id', 'wallet.user:username'])
            ->dateFilter()
            ->where('api_provider_id', $apiProvider->id)
            ->orderBy('created_at', 'desc')
            ->paginate(getPaginate());
        }

        return view('admin.api.detail', compact('pageTitle', 'currTab', 'totalEarnings','totalOrder', 'apiProvider', 'allData'));
    }

    protected function isValidDetailsParam($paramValue){
        $acceptableValues = ['edit', 'categories', 'products', 'orders'];

        return !empty($paramValue) && is_string($paramValue) && in_array($paramValue, $acceptableValues, true);
    }

    public function update(Request $request, $id){
        $apiProvider = ApiProvider::findOrFail($id);

        $postData = $request->all();

        $rule['domain'] = "required|url";
        $rule['status_update_ck'] = "required";
        $rule['auto_rename_api'] = "required";
        $rule['ck_connect_api'] = "required";
        $rule['status'] = "required";

        $request->validate([
            'type' => 'required|in:no1logs,CMSNT'
        ]);

        if($postData['type'] === "no1logs"){
            $rule['token'] = "required";
        }else{
            $rule['username'] = "required";
            $rule['password'] = "required";
        }

        $request->validate($rule);
        $price = '';

        if($postData['type'] === "no1logs"){
            $data = curl_get($postData['domain'] . "/api/v1/check-balance?api_token=" . $postData['token']);
            $response = json_decode($data, true);
            if(isset($data['status']) && $data['status'] == 'error'){
                $notify[] = ['error', 'There was an error connecting to the API'];
            }
            $price = $response['balance'];
        }else{
            $response = curl_get($postData['domain'] . "/api/GetBalance.php?username=" . $postData['username'] . "&password=".$postData['password']);
            $price = format_currency($response, true);
            if(isset($data['status']) && $data['status'] == 'error'){
                $notify[] = ['error', 'There was an error connecting to the API'];
                return back()->withNotify($notify);
            }
        }

        if($postData['type'] === "no1logs"){
            $apiProvider->domain = $request->domain;
            $apiProvider->type = $request->type; 
            $apiProvider->token = $request->token;
            $apiProvider->base_currency = "₦";
            $apiProvider->balance = $price;
            $apiProvider->status_update_ck = $request->status_update_ck;
            $apiProvider->auto_rename_api = $request->auto_rename_api;
            $apiProvider->ck_connect_api = $request->ck_connect_api;
            $apiProvider->status = $request->status;
        }else{
            $apiProvider->domain = $request->domain;
            $apiProvider->type = $request->type; 
            $apiProvider->username = $request->username;
            $apiProvider->password = $request->password;
            $apiProvider->base_currency = "$";
            $apiProvider->balance = $price;
            $apiProvider->status_update_ck = $request->status_update_ck;
            $apiProvider->auto_rename_api = $request->auto_rename_api;
            $apiProvider->ck_connect_api = $request->ck_connect_api;
            $apiProvider->status = $request->status;
        }

        $apiProvider->save();

        $notify[] = ['success', 'API details updated successfully'];
        return back()->withNotify($notify);
    }

    public function delete($id){ 
		$apiProvider = ApiProvider::findOrFail($id);

        if($apiProvider){
            $isRemove = $apiProvider->delete();
            if($isRemove){
                Category::where("api_provider_id", $apiProvider->id)->delete();
                Product::where("api_provider_id", $apiProvider->id)->delete();

                $notify[] = ['success', 'API deleted successfully'];
            }

        }else{
            $notify[] = ['error', 'API details not found'];
        }

	    return back()->withNotify($notify);
	}

    public function apiCronJob(){
        if(time() > gs('check_api_cron_time')){
            if((time() - gs('check_api_cron_time')) < 5){
                return [
                    'error' => 'The operation is too fast'
                ];
            }
        }

        ugs('check_api_cron_time', time());

        if(gs('status_connect_api') === 1){
            $purifier = new \HTMLPurifier();
            $apiProviders = ApiProvider::where('status', 1)->get();

            foreach($apiProviders as $apiProvider){
                if($apiProvider->type === "CMSNT"){
                    $getBalance = curl_get($apiProvider->domain ."/api/GetBalance.php?username=".$apiProvider->username."&password=".$apiProvider->password);
                    $price = format_currency($getBalance, true);
                    if(isset($data['status']) && $data['status'] == 'error'){
                        return;
                    }
                    $apiProvider->balance = $price;
                    $apiProvider->save();

                    // List all active products from api and store in database
                    $getProducts = curl_get($apiProvider->domain ."/api/ListResource.php?username=".$apiProvider->username.'&password='.$apiProvider->password);
                    $data = json_decode($getProducts, true);
                    if($data['status'] == 'success'){
                        foreach($data['categories'] as $category){
                            $categoryConditions = [
                                'api_id' => $category['id'],
                                'api_provider_id' => $apiProvider->id,
                            ];

                            $existingCategory = Category::where($categoryConditions)->first();

                            if(!$existingCategory){
                                $productImage = remoteFileUploader($category['image'], getFilePath('product'), getFileSize('product'));
                            }else{
                                $productImage = $existingCategory->products->first()->image ?? "favicon.png";
                            }
                        
                            $categoryRecord = Category::updateOrCreate(
                                $categoryConditions,
                                [
                                    'status' => gs("default_api_product_status"),
                                    'name' => $category['name'],
                                    'api_id' => $category['id'],
                                    'api_provider_id' => $apiProvider->id
                                ]
                            );
                            
                            foreach($category['accounts'] as $product){
                                $product_name = htmlspecialchars_decode($purifier->purify($product['name']));
                                $ck = (float) htmlspecialchars_decode($purifier->purify($product['price'])) * $apiProvider->ck_connect_api / 100;
                                $price = (float) htmlspecialchars_decode($purifier->purify($product['price'])) + $ck;

                                $category_id = $categoryRecord->id;
                                $productConditions = [
                                    'api_id' => $product['id'],
                                    'api_provider_id' => $apiProvider->id,
                                ];

                                $existingProduct = Product::where($productConditions)->first(); 

                                if($existingProduct){
                                    $price = $existingProduct->price;

                                    if($apiProvider->status_update_ck == 1){
                                        $ck = (float) htmlspecialchars_decode($purifier->purify($product['price'])) * $apiProvider->ck_connect_api / 100;
                                        $price = (float) htmlspecialchars_decode($purifier->purify($product['price'])) + $ck;
                                    }

                                    $product_name = $existingProduct->name;
                                    $product_content = $existingProduct->description;

                                    if($apiProvider->auto_rename_api){
                                        $product_name = htmlspecialchars_decode($purifier->purify($product['name']));
                                        $product_content = htmlspecialchars_decode($purifier->purify($product['description']));
                                    }

                                    $existingProduct->update([
                                        'category_id' => $category_id,
                                        'name' => $product_name,
                                        'description' => $product_content,
                                        'price' => format_currency($price),
                                        'api_price' => format_currency($product['price']),
                                        'status' => gs("default_api_product_status"),
                                        'api_id' => $product['id'],
                                        'api_provider_id' => $apiProvider->id,
                                        'api_stock' => $product['amount'],
                                        'name_api' => $product_name
                                    ]);
                                }else{
                                    Product::create(
                                        [
                                            'category_id' => $category_id,
                                            'name' => $product_name,
                                            'description' => htmlspecialchars_decode($purifier->purify($product['description'])),
                                            'price' => format_currency($price),
                                            'api_price' => format_currency($product['price']),
                                            'image' => $productImage,
                                            'status' => gs("default_api_product_status"),
                                            'api_id' => $product['id'],
                                            'api_provider_id' => $apiProvider->id,
                                            'api_stock' => $product['amount'],
                                            'name_api' => $product_name
                                        ]
                                    );
                                }
                            }
                        //    return $productImage;
                        }
                    }
                }
            }  
        }
    } 
}
