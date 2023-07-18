<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use File;

use App\User;
use App\Category;
use App\Role;
use App\Product;
use App\ProductCategory;


class AdminController extends Controller
{
    public function getAdminLogin(){
      if (Auth::user()) {
        $role_id=Auth::user()->role_id;
        $adminRole = Role::where('name', 'admin')->first();
        if($role_id==$adminRole->id)
        {
          return Redirect::to('admin-dashboard');
        }
        else
        {
          return Redirect::to('/');
        }
      }
      else
      {
        return view('admin.login');
      }
    }

    public function postAdminLogin(Request $request){
    	$validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required|min:8',
        ]);
    	if($validator->fails()) {
            return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
      }
      else
      {
      	$adminEmail = trim($request->get('email'));
        $adminPassword = trim($request->get('password'));
        if($user = User::where('email', $adminEmail)->first()) {
          // echo "<pre>";
          // print_r($user); die();
          $role_id=$user->role_id;
          $adminRole = Role::where('name', 'admin')->first();
          if($role_id==$adminRole->id)
          {  
            if(Hash::check($adminPassword, $user->password)) {
              //dd($user);
              Auth::login($user);
              return Redirect::to('admin-dashboard');
            }
            else
            {
              $errMsg = array();
              $errMsg['loginerror'] = 'Invalid Credentials';
               return Redirect::back()
                                  ->withErrors($errMsg)
                                  ->withInput();
            }
          }
          else
          {
            $errMsg = array();
              $errMsg['loginerror'] = 'You have not permission access this area';
               return Redirect::back()
                                  ->withErrors($errMsg)
                                  ->withInput();
              //return Redirect::to('/');
          }
        }
        else
        {
          $errMsg = array();
          $errMsg['loginerror'] = 'Invalid Credentials';
          return Redirect::back()
                      ->withErrors($errMsg)
                      ->withInput();
            

        }  
      }

    }

    public function getAdminDashboard(Request $request){
      if(Auth::user()){
        $page_title ='Admin Dashboard';
        return view('admin.dashboard')
        ->with('page_title', $page_title);
      }
      else
      {
        return Redirect::to('admin');
      }  
    }

    public function logOut(Request $request){
      if(Auth::user()){

        Auth::logout();
        return Redirect::to('admin');
      }
      return Redirect::back()->withErrors('Unauthorized access');
    }

    public function addCategory(Request $request){
      if(Auth::user())
      {
        $page_title ='Add Category';
        return view('admin.addcategory')
        ->with('page_title', $page_title);
      }
      else
      {
        return Redirect::to('admin');
      }
    }
    public function getCategorySlug(Request $request){
      if(Auth::user())
      {
        $role_id=Auth::user()->role_id; 
        $adminRole = Role::where('name', 'admin')->first();
        if($role_id==$adminRole->id)
        {
          $category_name = trim($request->get('category_name'));
          $text = preg_replace('~[^\pL\d]+~u', '-', $category_name);
          $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
          $text = preg_replace('~[^-\w]+~', '', $text);
          $text = trim($text, '-');
          $text = preg_replace('~-+~', '-', $text);
          $text = strtolower($text);
          $category_slug = Category::select('category_slug')->where('category_slug', $text)->where('is_deleted','0')->get();
          if(count($category_slug)>0)
          {
            header('Content-Type:application/json');
            die(json_encode(array("status"=>"0","message"=>"Failed"))); 
          }    
          else
          {
            header('Content-Type:application/json');
            die(json_encode(array("status"=>"1","message"=>"Success","slug"=>$text))); 
          }             
        }
        else
        {
          return Redirect::to('/');
        }  
      }
      else
      {
        return Redirect::to('admin');
      }
    }
    public function postAddCategory(Request $request){
      if(Auth::user())
      {

        Validator::extend('is_png',function($attribute, $value, $params, $validator){
          $image = base64_decode($value);
          $f = finfo_open();
          $result = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);
          return $result == 'image/png';
        });
         $validator = Validator::make($request->all(), 
        [
            'category_name'             => 'required|category_name|unique:categories',
            'category_slug'           => 'required',
            'category_photo'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ],
        [
            'category_name.unique' =>'This category already exist',
            'category_photo.max'   =>'Allowed maximum size is 2MB',
        ]);

        $categoryName = trim($request->get('category_name'));
        $categorySlug = trim($request->get('category_slug')); 
        $categoryNameExists = Category::where('category_name',$categoryName)
                                      ->first();
        if($categoryNameExists)
        {
          $errorMsg="This category name already exists";
          return Redirect::back()
                 ->with('error',$errorMsg);
        }
        else
        { 
          if($request->hasFile('category_photo')) {
              $file = $request->file('category_photo');
              $fileExt = $file->getClientOriginalExtension();
              $fileName = time() . '.' . $fileExt;
              $destinationPath = resource_path().'/assets/admin/images/category/';
              $file->move($destinationPath, $fileName);
            }
          
                                   
          $createCategory = Category::create([
                          'category_name'=> $categoryName,
                          'category_slug'=> $categorySlug,
                          'category_photo'   => $fileName,
                      ]);

          $successMsg="You have successfully create a category";
          return Redirect::back()
                 ->withSuccess($successMsg);
        }       
      }
      else
      {
        return Redirect::to('admin');
      }
    }

    public function getAllCategory(Request $request)
    {
      if(Auth::user())
      {
        $page_title ='View Category';
        $allCategory = Category::select('*')->where('is_deleted','0')->get();
        // echo "<pre>";
        // print_r($allCategory); die();
        return view('admin.viewcategory')
        ->with('page_title',$page_title)
        ->with('allCategory',$allCategory);
      }
      else
      {
        return Redirect::to('admin');
      }

    }
    public function getEditFromCategory($category_id)
    {
      if(Auth::user())
      {
        //echo $category_id; die();
        $page_title ='Edit Category';
        $getParticularCategory = Category::where('category_id', $category_id)
                           ->first();
        // echo "<pre>";
        // print_r($getParticularCategory); die();                   
        return view('admin.editcategory')
        ->with('page_title',$page_title)
        ->with('category_id',$category_id)
        ->with('getParticularCategory',$getParticularCategory);                   

      }
      else
      {
        return Redirect::to('admin');
      }
    }
    public function postEditFormCategory(Request $request)
    {
      if(Auth::user())
      {
        $validator = Validator::make($request->all(), 
        [
            'category_name'             =>'required|category_name|unique:categories',
            'category_slug'           => 'required',
            'category_photo'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ],
        [
            'category_name.unique' =>'This category already exist',
            'category_photo.max'   =>'Allowed maximum size is 2MB',
        ]);
        $categoryId = trim($request->get('category_id'));
        $categoryName = trim($request->get('category_name'));
        $categorySlug = trim($request->get('category_slug'));
        $categoryPhoto = trim($request->get('category_photo'));
        $getParticularCategory = Category::select('category_name')
                                ->where('category_id', $categoryId)
                                ->first();
        $getParticularCategoryName=$getParticularCategory->category_name;
        $categoryNameExists = Category::where('category_name',$categoryName)
                                        ->where('category_name','!=',$getParticularCategoryName)
                                      ->first(); 
        if($categoryNameExists)
        {                                                      
          $errorMsg="This category name already exists";
            return Redirect::back()
                   ->with('error',$errorMsg);
        }
        else
        {
          if($request->hasFile('category_new_photo')) {
            //echo "new image exist"; die();
            $file = $request->file('category_new_photo');
            $fileExt = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $fileExt;
            $destinationPath = resource_path().'/assets/admin/images/category/';
            $file->move($destinationPath, $fileName);
          }

          if(!empty($fileName))
          {
            //echo $file_path = resource_path().'/assets/admin/images/category/'.$categoryPhoto; die();
            File::delete(resource_path().'/assets/admin/images/category/'.$categoryPhoto);
          }  
          if(!empty($fileName))
          {
            $categoryNewPhotoName=$fileName;
          }
          else
          {
            $categoryNewPhotoName=$categoryPhoto;
          }

          Category::where('category_id', $categoryId)
                    ->update([
                        'category_name'  => $categoryName,
                        'category_slug'  => $categorySlug,
                        'category_photo' => $categoryNewPhotoName,                        
                    ]);

          $successMsg="You have successfully updated a category";
          return Redirect::back()
                 ->withSuccess($successMsg);            

        }                                       
      }
      else
      {
        return Redirect::to('admin');
      }  
    }

    public function getChangeStatusCategory($category_id,$status_code)
    {
      if(Auth::user())
      {
        //echo $category_id; die();
        $role_id=Auth::user()->role_id; 
        $adminRole = Role::where('name', 'admin')->first();
        if($role_id==$adminRole->id)
        {
          if($status_code==1)
          {
            $statusChangeCategory = Category::where('category_id', $category_id)->update([
                                'is_active' =>'1'
                           ]);                                                
          }
          else
          {
            $statusChangeCategory = Category::where('category_id', $category_id)->update([
                                'is_active' =>'0'
                           ]);
          }
          $successMsg="Category status updated successfully!";
          return Redirect::to('view-category')
                  ->withSuccess($successMsg);                   
        }
        else
        {
          return Redirect::to('/');
        }  
      }
      else
      {
        return Redirect::to('admin');
      }
    }
    public function getDeleteCategory($category_id)
    {
      if(Auth::user())
      {
        //echo $category_id; die();
        $role_id=Auth::user()->role_id; 
        $adminRole = Role::where('name', 'admin')->first();
        if($role_id==$adminRole->id)
        {          
          $deleteCategory = Category::where('category_id', $category_id)->update([
                                'is_deleted' =>'1'
                           ]);                                                
          $successMsg="Category deleted successfully!";
          return Redirect::to('view-category')
                  ->withSuccess($successMsg);                   
        }
        else
        {
          return Redirect::to('/');
        }  
      }
      else
      {
        return Redirect::to('admin');
      }
    }
    public function getAllProduct(Request $request)
    {
      if(Auth::user())
      {
        $role_id=Auth::user()->role_id; 
        $adminRole = Role::where('name', 'admin')->first();
        if($role_id==$adminRole->id)
        {
          $page_title ='View Product';
          $allProduct = Product::select('*')->where('is_deleted','0')->get();
          // echo "<pre>";
          // print_r($allProduct); die();
          // foreach($allProduct as $ke=>$value)
          // {
          //   $product_id=$value->id;
          //   $categoryDetails = ProductCategory::join('categories', 
          //                                   'product_category.category', '=', 'categories.category_id')
          //                           ->select('product_category.*','categories.category_name')
          //                           ->where('product_category.product_id', $product_id)
          //                           ->getQuery()
          //                           ->get();
          // // echo "<pre>";
          // // print_r($categoryDetails);                           
          // }
          //die();
          return view('admin.viewproduct')
          ->with('page_title',$page_title)
          //->with('categoryDetails',$categoryDetails)
          ->with('allProduct',$allProduct);
        }
        else
        {
          return Redirect::to('/');
        }    
      }
      else
      {
        return Redirect::to('admin');
      }
    }
    public function addProduct(Request $request){
      if(Auth::user())
      {
        $role_id=Auth::user()->role_id; 
        $adminRole = Role::where('name', 'admin')->first();
        if($role_id==$adminRole->id)
        {
          $page_title ='Add Product';
          $category = Category::select('*')->where('is_deleted','0')->where('is_active','1')->get();
          // echo "<pre>";
          // print_r($category); die();
          return view('admin.addproduct')
          ->with('page_title', $page_title)
          ->with('category',$category);
        }
        else
        {
          return Redirect::to('/');
        }  
      }
      else
      {
        return Redirect::to('admin');
      }
    }
    public function productGetDetails(Request $request){
      if(Auth::user())
      {
        $role_id=Auth::user()->role_id; 
        $adminRole = Role::where('name', 'admin')->first();
        if($role_id==$adminRole->id)
        {
          $product_name = trim($request->get('product_name'));
          $text = preg_replace('~[^\pL\d]+~u', '-', $product_name);
          $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
          $text = preg_replace('~[^-\w]+~', '', $text);
          $text = trim($text, '-');
          $text = preg_replace('~-+~', '-', $text);
          $text = strtolower($text);
          $product_slug = Product::select('product_slug')->where('product_slug', $text)->where('is_deleted','0')->get();
          if(count($product_slug)>0)
          {
            header('Content-Type:application/json');
            die(json_encode(array("status"=>"0","message"=>"Failed"))); 
          }    
          else
          {
            header('Content-Type:application/json');
            die(json_encode(array("status"=>"1","message"=>"Success","slug"=>$text))); 
          }             
        }
        else
        {
          return Redirect::to('/');
        }  
      }
      else
      {
        return Redirect::to('admin');
      }
    }
    public function productGetSku(Request $request){
      if(Auth::user())
      {
        $role_id=Auth::user()->role_id; 
        $adminRole = Role::where('name', 'admin')->first();
        if($role_id==$adminRole->id)
        {
          $sku_code = trim($request->get('sku_code'));
          
          $check_sku = Product::select('sku_code')->where('sku_code', $sku_code)->where('is_deleted','0')->get();
          if(count($check_sku)>0)
          {
            header('Content-Type:application/json');
            die(json_encode(array("status"=>"0","message"=>"Failed"))); 
          }    
          else
          {
            header('Content-Type:application/json');
            die(json_encode(array("status"=>"1","message"=>"Success"))); 
          }             
        }
        else
        {
          return Redirect::to('/');
        }  
      }
      else
      {
        return Redirect::to('admin');
      }
    }
    public function postAddProduct(Request $request){
      if(Auth::user())
      {
        // echo "<pre>";
        // print_r($request->all()); die();
        $role_id=Auth::user()->role_id; 
        $adminRole = Role::where('name', 'admin')->first();
        if($role_id==$adminRole->id)
        {  
          Validator::extend('is_png',function($attribute, $value, $params, $validator){
            $image = base64_decode($value);
            $f = finfo_open();
            $result = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);
            return $result == 'image/png';
          });
           $validator = Validator::make($request->all(), 
          [
              'product_name'           => 'required|product_name|unique:products',
              'product_slug'           => 'required',
              'sku_code'               => 'required', 
              'feature_image'          => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
              'product_price'          => 'required' 
          ],
          [
              'product_name.unique' =>'This product already exist',
              'feature_image.max'   =>'Allowed maximum size is 2MB',
          ]);

          $productName = trim($request->get('product_name'));
          $productSlug = trim($request->get('product_slug'));
          $skuCode = trim($request->get('sku_code'));
          $productPrice = trim($request->get('product_price'));
          $offerPrice = trim($request->get('offer_price'));
          $shortDesc = trim($request->get('short_desc'));
          $longDesc = trim($request->get('long_desc'));
          $aditionalInfo = trim($request->get('aditional_info'));
          $metaTitle = trim($request->get('meta_title'));
          $metaKeywords = trim($request->get('meta_keywords'));
          $metaDescription = trim($request->get('meta_description')); 
          $productNameExists = Product::where('product_name',$productName)
                                        ->first();
          if($productNameExists)
          {
            $errorMsg="This product name already exists";
            return Redirect::back()
                   ->with('error',$errorMsg);
          }
          else
          { 
            if($request->hasFile('feature_image')) {
                $file = $request->file('feature_image');
                $fileExt = $file->getClientOriginalExtension();
                $fileName = time() . '.' . $fileExt;
                $destinationPath = resource_path().'/assets/admin/images/product/';
                $file->move($destinationPath, $fileName);
              }
            
                                     
            $createProduct = Product::create([
                            'product_name'=>$productName,
                            'product_slug'=>$productSlug, 
                            'feature_image'=>$fileName,
                            'sku_code'=>$skuCode,
                            'short_desc'=>$shortDesc,
                            'long_desc'=>$longDesc,
                            'aditional_info'=>$aditionalInfo,
                            'usd_price'=>$productPrice,
                            'usd_offer_price'=>$offerPrice,
                            'meta_title'=>$metaTitle,
                            'meta_keywords'=>$metaDescription,
                            'meta_description'=>$metaDescription
                        ]);

            $lastInsertId=$createProduct->id;
            $category_array=$request->get('category');
            for($i=0; $i<count($category_array); $i++)
            {
              $createProductCategory = ProductCategory::create([
                            'product_id'=>$lastInsertId,
                            'category'=>$category_array[$i] 
                        ]);              
            }
            $successMsg="You have successfully create a product";
            return Redirect::back()
                   ->withSuccess($successMsg);
          }
        }
        else
        {
          return Redirect::to('/');
        }         
      }
      else
      {
        return Redirect::to('admin');
      }
    }
    public function productUpdatePopular(Request $request){
      if(Auth::user())
      {
        $role_id=Auth::user()->role_id; 
        $adminRole = Role::where('name', 'admin')->first();
        if($role_id==$adminRole->id)
        {
          $is_popular = trim($request->get('is_popular'));
          $product_id = trim($request->get('product_id'));

          $update_popular=Product::where('id', $product_id)
                    ->update([
                        'is_popular'  => $is_popular                        
                    ]);
          if($update_popular==1)
          {
            echo "1";
          }
          else
          {
            echo "0";
          }              
        }
        else
        {
          return Redirect::to('/');
        }  
      }
      else
      {
        return Redirect::to('admin');
      }
    }
    public function getChangeStatusProduct($product_id,$status_code)
    {
      if(Auth::user())
      {
        //echo $category_id; die();
        $role_id=Auth::user()->role_id; 
        $adminRole = Role::where('name', 'admin')->first();
        if($role_id==$adminRole->id)
        {
          if($status_code==1)
          {
            $statusChangeProduct = Product::where('id', $product_id)->update([
                                'is_active' =>'1'
                           ]);                                                
          }
          else
          {
            $statusChangeCategory = Product::where('id', $product_id)->update([
                                'is_active' =>'0'
                           ]);
          }
          $successMsg="Product status updated successfully!";
          return Redirect::to('view-product')
                  ->withSuccess($successMsg);                   
        }
        else
        {
          return Redirect::to('/');
        }  
      }
      else
      {
        return Redirect::to('admin');
      }
    }
    public function getDeleteProduct($product_id)
    {
      if(Auth::user())
      {
        //echo $product_id; die();
        $role_id=Auth::user()->role_id; 
        $adminRole = Role::where('name', 'admin')->first();
        if($role_id==$adminRole->id)
        {          
          $deleteProduct = Product::where('id', $product_id)->update([
                                'is_deleted' =>'1'
                           ]);
          $deleteProductCategory=ProductCategory::where('product_id',$product_id)->update(['is_deleted' =>'1']);                                                                 
          $successMsg="Product deleted successfully!";
          return Redirect::to('view-product')
                  ->withSuccess($successMsg);                   
        }
        else
        {
          return Redirect::to('/');
        }  
      }
      else
      {
        return Redirect::to('admin');
      }
    }
    public function getEditFromProduct($product_id)
    {
      if(Auth::user())
      {
        //echo $category_id; die();
        $page_title ='Edit Product';
        $getParticularProduct = Product::where('id', $product_id)
                           ->first();
        // echo "<pre>";
        // print_r($getParticularProduct); die();
        $category = Category::select('*')->where('is_deleted','0')->where('is_active','1')->get();                   
        return view('admin.editproduct')
        ->with('page_title',$page_title)
        ->with('product_id',$product_id)
        ->with('getParticularProduct',$getParticularProduct)
        ->with('category',$category);                   
      }
      else
      {
        return Redirect::to('admin');
      }
    }
    public function postEditFormProduct(Request $request)
    {
      if(Auth::user())
      {
        $validator = Validator::make($request->all(), 
        [
          'product_name'           => 'required|product_name|unique:products',
          'product_slug'           => 'required',
          'sku_code'               => 'required', 
          'feature_image'          => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
          'product_price'          => 'required'
        ],
        [
          'product_name.unique' =>'This product already exist',
          'feature_image.max'   =>'Allowed maximum size is 2MB',
        ]);
        $product_id = trim($request->get('product_id')); 
        $productName = trim($request->get('product_name'));
        $productSlug = trim($request->get('product_slug'));
        $skuCode = trim($request->get('sku_code'));
        $productPrice = trim($request->get('product_price'));
        $offerPrice = trim($request->get('offer_price'));
        $shortDesc = trim($request->get('short_desc'));
        $longDesc = trim($request->get('long_desc'));
        $aditionalInfo = trim($request->get('aditional_info'));
        $metaTitle = trim($request->get('meta_title'));
        $metaKeywords = trim($request->get('meta_keywords'));
        $metaDescription = trim($request->get('meta_description'));
        $feature_old_image = trim($request->get('feature_old_image'));
        $getParticularProduct = Product::select('product_name')
                                ->where('id', $product_id)
                                ->first();
        // echo "<pre>";
        // print_r($getParticularProduct); die;
        $getParticularProductName=$getParticularProduct->product_name;
        $productNameExists=Product::where('product_name',$productName)->where('product_name','!=', $getParticularProductName)->first();
        if($productNameExists)
        {
          $errorMsg="This product name already exists";
          return Redirect::back()->with('error',$errorMsg);
        }
        else
        {
          if($request->hasFile('feature_image')){
            $file = $request->file('feature_image');
            $fileExt = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $fileExt;
            $destinationPath = resource_path().'/assets/admin/images/product/';
            $file->move($destinationPath, $fileName);
          }
          if(!empty($fileName))
          {
            File::delete(resource_path().'/assets/admin/images/product/'.$feature_old_image);
          }
          if(!empty($fileName))
          {
            $productNewPhotoName=$fileName;
          }
          else
          {
            $productNewPhotoName=$feature_old_image;
          }
          $productUpdate=Product::where('id',$product_id)
          ->update([
                    'product_name'=>$productName,
                    'product_slug'=>$productSlug,
                    'feature_image'=>$productNewPhotoName,
                    'sku_code'=>$skuCode,
                    'short_desc'=>$shortDesc,
                    'long_desc'=>$longDesc,
                    'aditional_info'=>$aditionalInfo,
                    'usd_price'=>$productPrice,
                    'usd_offer_price'=>$offerPrice,
                    'meta_title'=>$metaTitle,
                    'meta_keywords'=>$metaKeywords,
                    'meta_description'=>$metaDescription
          ]);
          if($productUpdate)
          {
            $category_array=$request->get('category');
            ProductCategory::where('product_id',$product_id)->delete();
            foreach($category_array as $categoryId)
            {
              $createProductCategory = ProductCategory::create([
                'product_id'=>$product_id,
                'category'=>$categoryId 
              ]);
            }
            $successMsg="You have successfully updated a product";
            return Redirect::back()
                   ->withSuccess($successMsg);
          }
          else
          {
            $errorMsg="Something went wrong with update data";
            return Redirect::back()->with('error',$errorMsg);
          } 
        }                        
      }
      else
      {
        return Redirect::to('admin');
      }
    }
}
