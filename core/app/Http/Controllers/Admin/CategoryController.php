<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller{

    public function all(){
        $pageTitle = 'All Categories (Excluding API)';
        $categories = Category::searchable(['name'])->where('api_provider_id', '=', 0)->with('products.productDetails')->paginate(getPaginate());
        return view('admin.category.all',compact('pageTitle', 'categories'));
    }
    
    public function add(){
		
		$this->formSubmit();

    	$notify[] = ['success', 'Category added successfully'];
	    return back()->withNotify($notify);
    }

	public function update(){

		$this->formSubmit(update:true);

    	$notify[] = ['success', 'Category updated successfully'];
	    return back()->withNotify($notify);
    }

	private function formSubmit($update = false){

		$request = request();
		$rule = [
    		'name' => 'required|max:255|unique:categories,name,'.$request->id,
    	];

		if($update){
			$rule['id'] = 'required|integer';
		}
	
		$request->validate($rule);
	
		if($update){
			$category = Category::findOrFail($request->id); 
		}else{
			$category = new Category; 
		}
		
    	$category->name = $request->name;
    	$category->save();

		return $category;
	}

	public function status($id){ 
		return Category::changeStatus($id);
	}

	public function delete($id){ 
		$category = Category::whereDoesntHave('products')->findOrFail($id);
		$category->delete();

		$notify[] = ['success', 'Category deleted successfully'];
	    return back()->withNotify($notify);
	}

}
