<?php

namespace Fauzannurhidayat\Php\TokoOnline\Controller;

use Fauzannurhidayat\Php\TokoOnline\App\View;
use Fauzannurhidayat\Php\TokoOnline\Config\Database;
use Fauzannurhidayat\Php\TokoOnline\Exception\ValidationException;
use Fauzannurhidayat\Php\TokoOnline\Model\AddProductRequest;
use Fauzannurhidayat\Php\TokoOnline\Model\AdminLoginRequest;
use Fauzannurhidayat\Php\TokoOnline\Model\EditProductRequest;
use Fauzannurhidayat\Php\TokoOnline\Model\UserPasswordUpdateRequest;
use Fauzannurhidayat\Php\TokoOnline\Repository\SessionRepository;
use Fauzannurhidayat\Php\TokoOnline\Repository\UserRepository;
use Fauzannurhidayat\Php\TokoOnline\Service\SessionService;
use Fauzannurhidayat\Php\TokoOnline\Service\UserService;

class AdminController
{
    private UserService $userService;
    private SessionService $sessionService;
    private UserRepository $userRepository;

    public function __construct()
    {
        $connection = Database::getConnection('prod');
        $userRepository = new UserRepository($connection);
        $this->userService = new UserService($userRepository);
        $sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
        $this->userRepository = new UserRepository($connection);
    }

    public function login()
    {
        View::Render('Admin/Login', [
            'title' => 'Login Admin',
            'logo' => 'iStore',
            'error' => null
        ]);
    }
    public function postLogin()
    {
        $request = new AdminLoginRequest();
        $request->username = $_POST['username'];
        $request->password = $_POST['password'];

        try {
            $response = $this->userService->loginAdmin($request);
            if ($response->user->status == 'admin') {
                $this->sessionService->createByUsername($response->user->username);
                //redirect to users/dashboard
                View::Redirect('/toko_online/public/');
            }
            View::Render('Admin/Login', [
                'title' => 'Login Admin',
                'logo' => 'iStore',
                'error' => 'Username or password is wrong'
            ]);
        } catch (ValidationException $exception) {
            View::Render('Admin/Login', [
                'title' => 'Login Admin',
                'logo' => 'iStore',
                'error' => $exception->getMessage()
            ]);
        }
    }
    public function logout()
    {
        $user = $this->sessionService->current();
        if($user->status == 'admin'){
            $this->sessionService->destroy();
        View::Redirect("/toko_online/public/");
        }else{
            View::Render(
                'Home/NotFound',
                []
            );
        }
        
    }
    public function updatePassword()
    {
        $user = $this->sessionService->current();
        if($user->status == 'admin'){
            View::Render('Admin/Password', [
                "title" => "Update Admin Password",
                'logo' => 'iStore',
                "user" => [
                    "username" => $user->username
                ]
            ]);
        }else{
            View::Render(
                'Home/NotFound',
                []
            ); 
        }
        
    }
    public function postUpdatePassword()
    {
        $user = $this->sessionService->current();
        if($user->status == 'admin'){
            $request = new UserPasswordUpdateRequest();
        $request->username = $user->username;
        $request->oldPassword = $_POST['oldPassword'];
        $request->newPassword = $_POST['newPassword'];

        try {
            $this->userService->updatePassword($request);
            //redirect ke halaman dashboard
            View::Redirect('/toko_online/public/');
        } catch (ValidationException $exception) {
            View::Render(
                'Admin/Password',
                [
                    'title' => 'Update Admin Password',
                    'logo' => 'iStore',
                    'error' => $exception->getMessage(),
                    'user' => [
                        "username" => $user->username,
                    ]
                ]
            );
        }
        }else{
            View::Render(
                'Home/NotFound',
                []
            );
        }
        
    }
    public function addProduct()
    {
        $user = $this->sessionService->current();
        if($user->status == 'admin'){
            View::Render('Admin/AddProduct', [
                "title" => "Add Product",
                'logo' => 'iStore',
                "user" => [
                    "username" => $user->username
                ]
            ]);
        }else{
            View::Render(
                'Home/NotFound',
                []
            );
        }
        
    }
    public function postAddProduct()
    {
        $user = $this->sessionService->current();
        if($user->status == 'admin'){
        $request = new AddProductRequest();
        $request->image = $_FILES['image'];
        $request->name = $_POST['name'];
        $request->category = $_POST['category'];
        $request->price = $_POST['price'];
        $request->color = $_POST['color'];
        $request->stock = $_POST['stock'];
        $request->capacity = $_POST['capacity'];
        $request->description = $_POST['description'];
        $request->created_at = null;
        $request->modified_at = null;
        try {
            // var_dump($_POST); die;
            // var_dump($_FILES); die;
            //var_dump($_FILES['image']['name']); die;
            $this->userService->addProduct($request);
            //redirect ke halaman dashboard
            View::Redirect('/toko_online/public/admin/productManagement');
        } catch (ValidationException $exception) {
            View::Render(
                'Admin/AddProduct',
                [
                    'title' => 'Add Product',
                    'logo' => 'iStore',
                    'error' => $exception->getMessage(),
                    'user' => [
                        "username" => $user->username,
                    ],
                    "submit" => "Add Product"
                ]
            );
        }
        }else{
            View::Render(
                'Home/NotFound',
                []
            );
        }
        
    }
    public function editProduct()
    {
        $user = $this->sessionService->current();
        if($user->status == 'admin'){
            $locationImage = "http://localhost/toko_online/public/assets/images/products/";
        $product = $this->userRepository->findProductsById($_GET['id']);
        View::Render('Admin/EditProduct', [
            "title" => "Edit Product",
            'logo' => 'iStore',
            "user" => [
                "username" => $user->username
            ],
            "productId" => $product->id,
            "productName" => $product->name,
            "imageLocation" => $locationImage,
            "productImage" => $product->image,
            "productStock" => $product->stock,
            "productColor" => $product->color,
            "productCapacity" => $product->capacity,
            "productDescription" => $product->description,
            "productCategory" => $product->category,
            "productPrice" => $product->price
        ]);
        }else{
            View::Render(
                'Home/NotFound',
                []
            );
        }
        
    }
    public function postEditProduct()
    {
        $user = $this->sessionService->current();
        if($user->status == 'admin'){
        $request = new EditProductRequest();
        $request->image = $_FILES['image'];
        $request->name = $_POST['name'];
        $request->category = $_POST['category'];
        $request->price = $_POST['price'];
        $request->color = $_POST['color'];
        $request->stock = $_POST['stock'];
        $request->capacity = $_POST['capacity'];
        $request->description = $_POST['description'];
        $request->id = $_POST['id'];

        try {
            var_dump($request->image); die;
            // var_dump($request); die;
            $this->userService->editProduct($request);
            //redirect ke halaman dashboard
            View::Redirect('/toko_online/public/admin/productManagement');
        } catch (ValidationException $exception) {
            View::Render(
                'Admin/EditProduct',
                [
                    'logo' => 'iStore',
                    'title' => 'Edit Product',
                    'error' => $exception->getMessage(),
                    'user' => [
                        "username" => $user->username,
                    ]
                ]
            );
        }
        }else{
            View::Render(
                'Home/NotFound',
                []
            );
        }
        
    }
    public function deleteProduct()
    {
        $user = $this->sessionService->current();
        if($user->status == 'admin'){
            View::Render('Admin/Delete', []);
            $id = $_GET['id'];
        if (isset($id)) {
            $this->userRepository->deleteProductById($id);
            View::Redirect('/toko_online/public/admin/productManagement');
        }
        }else{
            View::Render(
                'Home/NotFound',
                []
            );
        }
        
    }
    public function deleteUser()
    {
        $user = $this->sessionService->current();
        if($user->status == 'admin'){
            View::Render('Admin/Delete', []);
            $id = $_GET['id'];
        if (isset($id)) {
            $this->userRepository->deleteUserById($id);
            View::Redirect('/toko_online/public/admin/userManagement');
        }  
        }else{
            View::Render(
                'Home/NotFound',
                []
            );
        }
        
    }
    public function productDetail()
    {
        $user = $this->sessionService->current();
        if($user->status == 'admin'){
            $locationImage = "http://localhost/toko_online/public/assets/images/products/";
            $product = $this->userRepository->findProductsById($_GET['id']);
            View::Render('Admin/DetailProduct', [
                'logo' => 'iStore',
                'title' => 'Product Detail',
                "productId" => $product->id,
                "productName" => $product->name,
                "imageLocation" => $locationImage,
                "productImage" => $product->image,
                "productStock" => $product->stock,
                "productColor" => $product->color,
                "productCapacity" => $product->capacity,
                "productDescription" => $product->description,
                "productCategory" => $product->category,
                "productPrice" => $product->price,
                "productCreatedAt" => $product->created_at,
                "productModifiedAt" => $product->modified_at
            ]);
        }else{
            View::Render(
                'Home/NotFound',
                []
            );
        }
       
    }
    public function userDetail()
    {
        $user = $this->sessionService->current();
        if($user->status == 'admin'){
            $user = $this->userRepository->findById($_GET['id']);
        View::Render('Admin/DetailUser', [
            'logo' => 'iStore',
            'title' => 'Product Detail',
            'userId' => $user->id,
            'userName' => $user->username,
            'userFirstname' => $user->firstname,
            'userLastname' => $user->lastname,
            'userEmail' => $user->email,
            'userGender' => $user->gender,
            'userPassword' => $user->password,
            'userPhoneNumber' => $user->phoneNumber,
            'userAddress' => $user->address,
            'userJobs' => $user->jobs,
            'userDateOfBirth' => $user->dateOfBirth,
            'userStatus' => $user->status,
            'userJoinedAt' => $user->created_at
        ]);
        }else{
            View::Render(
                'Home/NotFound',
                []
            );
        }
        
    }
    public function productManagement()
    {
        $user = $this->sessionService->current();
        if ($user->status == 'admin') {
            $countProducts = $this->userRepository->countAllProduct();
            $products = $this->userRepository->showAllProduct();
            View::Render('Admin/ProductManagement', [
                "title" => "iStore Admin",
                'logo' => 'iStore',
                "user" => [
                    "username" => $user->username
                ],
                "showAllProducts" => $products,
                "countAllProducts" => $countProducts
            ]);
        } else {
            View::Render(
                'Home/NotFound',
                []
            );
        }
    }
    public function userManagement()
    {
        $user = $this->sessionService->current();
        if ($user->status == 'admin') {
            $users = $this->userRepository->showAllUser();
            $countUsers = $this->userRepository->countAllUsers();
            View::Render('Admin/UserManagement', [
                "title" => "iStore Admin",
                'logo' => 'iStore',
                "user" => [
                    "username" => $user->username ?? ""
                ],
                "showAllUsers" => $users ?? [],
                "countAllUsers" => $countUsers ?? 0
            ]);
        }else{
            View::Render(
                'Home/NotFound',
                []
            );
        }
    }
}
