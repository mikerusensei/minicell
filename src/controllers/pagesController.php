<?php
require_once 'src/controllers/productController.php';
require_once 'src/controllers/userController.php';
require_once 'src/controllers/ordersController.php';
require_once 'src/controllers/voucherController.php';
require_once 'src/models/user.php';
require_once 'src/models/product.php';

class FAQSController{
    public function index(){
        require_once 'src/views/faqs/faqs.php';
    }
}

// Admin Login
class AdminLoginController{
    public function index(){
        $this->user = new User();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $mobile_num = $_POST['mobile_num'];
            $password = $_POST['password'];
            $result = $this->user->getAdmin($mobile_num, $password);

            if ($result) {
                $_SESSION['admin_logged_in'] = true;
                header('Location: /minicell/index.php/adminpage');
                exit(); 
            } else {
                require_once 'src/views/loginfailed/loginfailed.php';
            }
        } else {
            require_once 'src/views/adminpage/adminlogin.php';
        }
    }
}

// Admin Page
class AdminPageController{
    private $result = null;

    public function index() {
        $controller = new ProductController();

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
            $searchTerm = $_GET['search'];
            $this->result = $controller->getProd($searchTerm);
            json_encode($this->result);
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (isset($_POST['method']) && $_POST['method'] === 'DELETE'){
                $result = $controller->delete($_POST['product_id']);

                header('Location: /minicell/index.php/adminpage');
                exit();
            }
            
            $name = $_POST['name'];
            $desc = $_POST['desc'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $material = $_POST['material'];
            $small = $_POST['small'];
            $medium = $_POST['medium'];
            $large = $_POST['large'];
            $status = $_POST['status'];

            $image = $_FILES['img']['name'];
            $temporary = $_FILES['img']['tmp_name'];
            $image_dir = 'src/uploads/'. $image;
            move_uploaded_file($temporary, $image_dir);

            $image1 = $_FILES['img1']['name'];
            $temporary1 = $_FILES['img1']['tmp_name'];
            $image_dir1 = 'src/uploads/'. $image1;
            move_uploaded_file($temporary1, $image_dir1);

            $image2 = $_FILES['img2']['name'];
            $temporary2 = $_FILES['img2']['tmp_name'];
            $image_dir2 = 'src/uploads/'. $image2;
            move_uploaded_file($temporary2, $image_dir2);

            $image3 = $_FILES['img3']['name'];
            $temporary3 = $_FILES['img3']['tmp_name'];
            $image_dir3 = 'src/uploads/'. $image3;
            move_uploaded_file($temporary3, $image_dir3);

            $existingProduct = $controller->getProd($name);

            if ($existingProduct) {
                $result = $controller->update($existingProduct['id'], $image_dir, $image_dir1, $image_dir2, $image_dir3, $name, $desc, $price, $category, $small, $medium, $large, $material, $status);
            } else {
                $result = $controller->create($image_dir, $image_dir1, $image_dir2, $image_dir3, $name, $desc, $price, $category, $small, $medium, $large, $material, $status);
            }

            header('Location: /minicell/index.php/adminpage');
            exit();
        }


        require_once 'src/views/adminpage/adminpage.php';
    }

    public function logout() {
        // session_start();
        $_SESSION['admin_logged_in'] = false; 
        session_destroy();
        header('Location: /minicell/index.php');
        exit();
    }

    public function getAllOrders(){
        $controller = new ProductController();
        $result = $controller->getAllOrders();
        echo json_encode($result);
    }

    public function updateOrderStatus(){
        $controller = new OrderController();
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $controller->updateOrderStatus($data['orderId'], $data['status']);
        echo json_encode($result);
    }
}

// Landing Page
class LandingController{
    public function index(){
        $controller = new ProductController();
        $products = $controller->displayProducts();
        require_once 'src/views/landingpage/landingpage.php';
    }
}

// Login Page
class LogInController {
    public function index() {
        $this->user = new User();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email_add = $_POST['email_add'];
            $password = $_POST['password'];
            $result = $this->user->get($email_add, $password);

            if ($result) {
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user'] = $result;
                require_once 'src/views/loginsuccess/loginsuccess.php';
            } else {
                require_once 'src/views/loginfailed/loginfailed.php';
            }
        } else {
            require_once 'src/views/loginpage/loginpage.php';
        }
    }
}

// Sign Up Page
class SignUpController {
    public function index() {
        $this->user = new User();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email_add = $_POST['email_add'];
            $password = $_POST['password'];
            $result = $this->user->create($email_add, $password);

            if ($result) {
                // Success message or redirect after successful sign-up
                require_once 'src/views/signUpSuccess/signUpSuccess.php';
            } else {
                echo "Failed to register user.";
            }
        } else {
            require_once 'src/views/signUpPage/signUpPage.php';
        }
    }
}

// Home page
class HomePageController{
    public function index(){
        $controller = new ProductController();
        $products = $controller->displayProducts();
        $result = [];

        if ($_SERVER['REQUEST_METHOD'] == 'GET'  && isset($_GET['category'])){
            $category = strtolower($_GET['category']);
            $result = $controller->getCategory($category);
        }
        require_once 'src/views/homepage/homepage.php';
    }
    public function account(){
        $controller = new UserController();

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $userId = $_SESSION['user']['id'];
            $username = $_POST['username'];
            $name = $_POST['name'];
            $phone_num = $_POST['phone'];
            $birthdate = $_POST['birthdate'];
            $password = $_POST['password'];
            $result = $controller->update($userId, $username, $name, $phone_num, $birthdate, $password);

            header('Location: /minicell/index.php/homepage');
            exit();
        }
        require_once 'src/views/accountpage/account.php';
    }
    public function logout(){
        $_SESSION['user_logged_in'] = false; 
        session_destroy();
        header('Location: /minicell/index.php');
        exit();
    }

    public function prod($matches){
        $controller = new ProductController();
        $product = $controller->getSpecific($matches);
        require_once 'src/views/viewproduct/viewproduct.php';
    }

    public function addtocart(){
        $controller = new UserController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = json_decode(file_get_contents('php://input'), true);
            $checkCart = $controller->checkCart($data['userId'], $data['prodId'], $data['size'], $data['quantity']);
            if ($checkCart){
                $result = $controller->updateCart($data['userId'], $data['prodId'], $data['size'], $data['quantity']);
                echo json_encode(['cartId' => $result]);
            }else{
                $result = $controller->addtocart($data['userId'], $data['prodId'], $data['size'], $data['quantity']);
                echo json_encode(['cartId' => $result]);
            }
        }
    }

    public function resetSessionProducts(){
        $_SESSION['products'] = null;
    }

    public function postReview(){
        $controller = new UserController();
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $controller->postReview($_SESSION['user']['id'], $data['rating'], $data['orderId'], $data['content']);
        echo json_encode(['data' => json_encode($data)]);
    }

    public function createVoucher(){
        $controller = new VoucherController();
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode($data);
        $result = $controller->create($data['code'], $data['name'], $data['desc'], $data['valid']);
    }

    public function fetchVoucher(){
        $controller = new VoucherController();
        $result = $controller->fetchVoucher();
        echo json_encode($result);
    }

    public function addAddress(){
        $controller = new UserController();
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $controller->addAddress($_SESSION['user']['id'], $data['fullname'], $data['phonenum'], $data['housenum'], $data['street'], $data['brgy'], $data['city'], $data['prov'], $data['zip']);
        echo json_encode($result);
    }

    public function getAddress(){
        $controller = new UserController();
        $result = $controller->getAddress($_SESSION['user']['id']);
        echo json_encode($result);
    }

    public function removeAddress(){
        $controller = new UserController();
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $controller->removeAddress($data['id']);
        echo json_encode($result);
    }
}

class CartController{
    public function index(){
        $controller = new UserController();
        $controller2 = new ProductController();

        $products = $controller->getCart($_SESSION['user']['id']);
        require_once 'src/views/cart/cart.php';
    }

    public function getCart(){
        $controller = new UserController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = json_decode(file_get_contents('php://input'), true);
            $result = $controller->getProdCart($data['cartId']);
            echo json_encode($result);
        }
    }

    public function fetchProducts(){
        $controller = new ProductController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = json_decode(file_get_contents('php://input'), true);
            $result = $controller->getSpecific($data['prodId']);
            echo json_encode($result);
        }
    }

    public function deleteProduct(){
        $controller = new UserController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = json_decode(file_get_contents('php://input'), true);
            $result = $controller->removeCart($data['cartId']);
            echo json_encode($result);
        }
    }

    public function updateCart(){
        $controller = new UserController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = json_decode(file_get_contents('php://input'), true);
            $result = $controller->updateCart($data['cartId'], $data['quantity']);
            echo json_encode($result);
        }
    }
}

class CheckOutController{
    public function index(){
        require_once 'src/views/checkout/checkout.php';
    }

    public function checkoutSuccess(){
        require_once 'src/views/checkout/checkoutsuccess.php';
    }

    public function buyNow(){
        $controller =new USerController();
        $products = $controller->getCart($_SESSION['user']['id']);
        echo json_encode($products);
        // if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        //     $data = json_decode(file_get_contents('php://input'), true);
        //     $_SESSION['buyNow-prod'] = $data;
        //     echo json_encode($_SESSION['products']);
        // }
    }

    public function setProds(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = json_decode(file_get_contents('php://input'), true);
            $_SESSION['products'] = $data['products'];
        }
    }

    public function payment(){
        require_once 'src/views/checkout/payment.php';
    }

    public function processCheckout(){
        $ordercontroller = new OrderController();
        $usercontroller = new UserController();
        $productcontroller = new ProductController();
        $userId = $_SESSION['user']['id'];
        $productInCart = $_SESSION['products'];
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'];
        $payment = $data['paymentOption'];
        $address = $data['shippingAddress'];
        $subtotal = $data['subtotal'];
        $pattern = '/₱.(\d.+)/';
        preg_match($pattern, $subtotal, $clean);
        $orderId = $ordercontroller->generateOrderId();
        $order = $ordercontroller->create($orderId, $userId, $address, $payment,$email, $clean[1]);


        foreach ($productInCart as $value){
            $product = $usercontroller->getProdCart($value);
            $size = $product[0][3];
            $quantity = $product[0][4];
            $prodId = $product[0][2];
            $result = $productcontroller->getSpecific($prodId);
            $stocks = $productcontroller->getStocks($prodId, $size);
            $updated_stock = $stocks[$size] - $quantity;
            $usercontroller->removeCart($product[0][0]);
            $addprod = $ordercontroller->addProdOrders($orderId, $prodId, $quantity, $size);
            $productcontroller->updateStocks($prodId, $size, $updated_stock);
        }
    }

    public function fetchOrders(){
        $controller = new OrderController();
        $result = $controller->fetchOrders($_SESSION['user']['id']);
        echo json_encode($result);
    }

    public function fetchOrderDetails(){
        $controller = new OrderController();
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $controller->fetchOrderDetails($data['orderId']);
        echo json_encode($result);
    }
}

class Test{
    public function printSession(){
        echo json_encode($_SESSION['products']);
    }
}
// Not Found Page
class NotFoundController{
    public function index(){
        require_once 'src/views/notfound/notfound.php';
    }
}
?>