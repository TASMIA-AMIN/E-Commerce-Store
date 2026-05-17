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
        $requests = getReturnRequestsBySeller($conn, $sellerId); 
        close($conn); 
        include '../view/return.php'; 
        break; 
    case 'update':
        $returnId = (int)($_POST['return_id'] ?? 0); 
        $status = htmlspecialchars(trim($_POST['status'] ?? '')); 
        if (!$returnId || !in_array($status, ['approved','rejected','completed'])) { 
        $_SESSION['error'] = 'Invalid return action.'; 
        header('Location: ReturnController.php?action=index'); exit; 
        } 
        $conn = connect(); 
        updateReturnStatus($conn, $returnId, $status); 
        close($conn); 
        $_SESSION['msg'] = 'Return request marked as "' . ucfirst($status) . '".'; 
        header('Location: ReturnController.php?action=index'); exit; 
    default: 
        header('Location: ReturnController.php?action=index'); exit; 
        }