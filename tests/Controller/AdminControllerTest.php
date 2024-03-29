<?php

namespace Fauzannurhidayat\Php\TokoOnline\Controller {
    require_once __DIR__ . "/../Helper/Helper.php";

    use Fauzannurhidayat\Php\TokoOnline\Config\Database;
    use Fauzannurhidayat\Php\TokoOnline\Domain\Session;
    use Fauzannurhidayat\Php\TokoOnline\Domain\User;
    use Fauzannurhidayat\Php\TokoOnline\Domain\Product;
    use Fauzannurhidayat\Php\TokoOnline\Repository\SessionRepository;
    use Fauzannurhidayat\Php\TokoOnline\Repository\UserRepository;
    use Fauzannurhidayat\Php\TokoOnline\Service\UserService;
    use Fauzannurhidayat\Php\TokoOnline\Service\SessionService;
    use PHPUnit\Framework\TestCase;

    class AdminControllerTest extends TestCase
    {
        private HomeController $homeController;
        private UserRepository $userRepository;
        private SessionRepository $sessionRepository;
        private AdminController $adminController;
        private UserService $userService;

        protected function setUp(): void
        {
            $connection = Database::getConnection();
            $this->homeController = new HomeController();
            $this->sessionRepository = new SessionRepository($connection);
            $this->userRepository = new UserRepository($connection);
            $this->adminController = new AdminController();
            $this->userService = new UserService($this->userRepository);
            $this->sessionRepository->deleteAll();
            $this->userRepository->deleteAll();
            putenv("mode=test");
        }
        public function testLoginAsAdminPage()
        {
            $this->adminController->login();
            $this->expectOutputRegex("[Login Admin]");
            $this->expectOutputRegex("[Username]");
            $this->expectOutputRegex("[Password]");
        }
        public function testAdminLoginSuccess()
        {
            $user = new User();
            $user->id = 12;
            $user->firstname = 'admin';
            $user->lastname = 'admin';
            $user->email = 'admin';
            $user->gender = 'male';
            $user->phoneNumber = '091233243';
            $user->address = 'on earth';
            $user->dateOfBirth = '2001-05-02';
            $user->jobs = 'admin';
            $user->image = '34234234.jpeg';
            $user->username = 'admin';
            $user->password = password_hash('admin', PASSWORD_BCRYPT);
            $user->status = 'admin';
            $this->userRepository->save($user);

            $_POST["username"] = "admin";
            $_POST["password"] = "admin";
            $this->adminController->postLogin();
            $this->expectOutputRegex("[Location: /]");
        }
        // public function testUpdatePasswordAdmin()
        // {
        //     $user = new User();
        //     $user->id = 12;
        //     $user->firstname = 'admin';
        //     $user->lastname = 'admin';
        //     $user->email = 'admin';
        //     $user->gender = 'male';
        //     $user->phoneNumber = '091233243';
        //     $user->address = 'on earth';
        //     $user->dateOfBirth = '2001-05-02';
        //     $user->jobs = 'admin';
        //     $user->image = '34234234.jpeg';
        //     $user->username = 'admin';
        //     $user->password = password_hash('admin', PASSWORD_BCRYPT);
        //     $user->status = 'admin';
        //     $this->userRepository->save($user);

        //     $session = new Session();
        //     $session->id = uniqid();
        //     $session->userId = $user->id;
        //     $this->sessionRepository->save($session);
        //     $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        //     $this->homeController->index();
        //     $this->adminController->updatePassword();
        //     $_POST['oldPassword'] = "admin";
        //     $_POST['newPassword'] = "admin1";
        //     $this->adminController->postUpdatePassword();
        //     //$this->homeController->index();
        //     //$this->expectOutputRegex("[Location: /toko_online/public/]");
        //     $this->expectOutputRegex("[Add Product]");
        // }
        public function testDashboardMenuAdmin()
        {
            $user = new User();
            $user->id = 12;
            $user->firstname = 'admin';
            $user->lastname = 'admin';
            $user->email = 'admin';
            $user->gender = 'male';
            $user->phoneNumber = '091233243';
            $user->address = 'on earth';
            $user->dateOfBirth = '2001-05-02';
            $user->jobs = 'admin';
            $user->image = '34234234.jpeg';
            $user->username = 'admin';
            $user->password = password_hash('admin', PASSWORD_BCRYPT);
            $user->status = 'admin';
            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->userId = $user->id;
            $this->sessionRepository->save($session);
            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;
            $this->homeController->index();

            $this->expectOutputRegex("[Transactions]");
        }
        public function testProductManagement()
        {
            $product = new Product();
            $product->id = '12';
            $product->image = 'iPhone3g.jpg';
            $product->name = 'iPhone 3g';
            $product->category = 'iPhone';
            $product->price = 10000;
            $product->color = 'yellow';
            $product->stock = 13;
            $product->capacity = '128GB';
            $product->description = 'this is an iphone';
            $product->created_at = null;
            $product->modified_at = null;
            $this->userRepository->saveProduct($product);

            $user = new User();
            $user->id = 12;
            $user->firstname = 'admin';
            $user->lastname = 'admin';
            $user->email = 'admin';
            $user->gender = 'male';
            $user->phoneNumber = '091233243';
            $user->address = 'on earth';
            $user->dateOfBirth = '2001-05-02';
            $user->jobs = 'admin';
            $user->image = '34234234.jpeg';
            $user->username = 'admin';
            $user->password = password_hash('admin', PASSWORD_BCRYPT);
            $user->status = 'admin';
            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->userId = $user->id;
            $this->sessionRepository->save($session);
            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;
            $this->homeController->index();

            $this->adminController->productManagement();

            $this->expectOutputRegex("[iPhone 3g]");
        }
        public function testAddProduct()
        {
            $user = new User();
            $user->id = 12;
            $user->firstname = 'fauzan';
            $user->lastname = 'nurhidayat';
            $user->email = 'admin';
            $user->gender = 'male';
            $user->phoneNumber = '091233243';
            $user->address = 'on earth';
            $user->dateOfBirth = '2001-05-02';
            $user->jobs = 'admin';
            $user->username = 'admin';
            $user->image = "foto.jpg";
            $user->password = password_hash('admin', PASSWORD_BCRYPT);
            $user->status = 'admin';
            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->userId = $user->id;
            $this->sessionRepository->save($session);
            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

            // $tmp_name = tempnam('/Applications/XAMPP/xamppfiles/temp', 'php');

            // $_FILES['image'] = [
            //     [
            //     "name" => "iphone4.jpeg",
            //     "full_path" => "iphone4.jpeg",
            //     "type" => "image/jpeg",
            //     "tmp_name" => $tmp_name,
            //     "error" => 0,
            //     "size" => 1000
            // ]];

            $_POST['name'] = 'iPhone 4';
            $_POST['category'] = 'iPhone';
            $_POST['price'] = 50000;
            $_POST['color'] = 'blue';
            $_POST['capacity'] = '256GB';
            $_POST['stock'] = 500;
            $_POST['description'] = 'this is an iPhone 4 the color is blue';
            $this->adminController->postAddProduct();
            $this->expectOutputRegex("[Location: /toko_online/public/admin/productManagement]");
        }
    }
}

