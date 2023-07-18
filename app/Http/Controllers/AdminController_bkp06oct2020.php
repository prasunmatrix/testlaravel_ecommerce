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


class AdminController extends Controller
{
    public function getAdminLogin(){
      if (Auth::user()) {
        return Redirect::to('admin-dashboard');
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
          if(Hash::check($adminPassword, $user->password)) {
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
            'category_photo'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ],
        [
            'category_name.unique' =>'This category already exist',
            'category_photo.max'   =>'Allowed maximum size is 2MB',
        ]);

        $categoryName = trim($request->get('category_name')); 
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
        $allCategory = Category::select('*')->get();
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
            'category_photo'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ],
        [
            'category_name.unique' =>'This category already exist',
            'category_photo.max'   =>'Allowed maximum size is 2MB',
        ]);
        $categoryId = trim($request->get('category_id'));
        $categoryName = trim($request->get('category_name'));
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


}
