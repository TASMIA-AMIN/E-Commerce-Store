 <?php 
 
 require_once 'auth_guard.php'; 
 require_once '../model/Connect.php'; 
 require_once '../model/SellerModel.php'; 
 require_once '../model/Close.php'; 
 
 $action = $_GET['action'] ?? $_POST['action'] ?? 'index'; 
 $sellerId = $_SESSION['seller_id'];

 switch ($action) { 
    case 'index': 
        $conn = connect(); 
        $reviews = getReviewsBySeller($conn, $sellerId); 
        close($conn); 
        include '../view/review.php'; 
        break; 
    case 'reply_save': 
        $reviewId = (int)($_POST['review_id'] ?? 0); 
        $reply = htmlspecialchars(trim($_POST['reply'] ?? '')); 
        if (!$reviewId || !$reply) { 
            $_SESSION['error'] = 'Reply cannot be empty.'; 
            header('Location: ReviewController.php?action=index'); 
            exit; 
            } 
            $conn = connect(); 
            replyToReview($conn, $reviewId, $sellerId, $reply); 
            close($conn); 
            $_SESSION['msg'] = 'Reply posted successfully.'; 
            header('Location: ReviewController.php?action=index'); exit; 
    default: 
        header('Location: ReviewController.php?action=index'); exit; 
 }