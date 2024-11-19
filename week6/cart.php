<?php
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    // Redirect user to login page if not logged in
    header('Location: login.php');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'bakery'); // Update credentials

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$total = 0;

// Fetch cart items
$cart_query = "
    SELECT cart.id AS cart_id, items.name, items.cost_per_piece, cart.quantity, 
           (items.cost_per_piece * cart.quantity) AS subtotal 
    FROM cart 
    JOIN items ON cart.item_id = items.id 
    WHERE cart.user_id = $user_id";

$result = $conn->query($cart_query);
$cart_items = $result->fetch_all(MYSQLI_ASSOC);

// Handle cart actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = $_POST['cart_id'];
    $action = $_POST['action'];

    if ($action === 'increase') {
        $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE id = $cart_id");
    } elseif ($action === 'decrease') {
        $conn->query("UPDATE cart SET quantity = quantity - 1 WHERE id = $cart_id AND quantity > 1");
    } elseif ($action === 'remove') {
        $conn->query("DELETE FROM cart WHERE id = $cart_id");
    }

    header('Location: cart.php'); // Refresh cart
    exit();
}
?>

<h1 class="text-center">Your Cart</h1>
<?php if (!empty($cart_items)): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart_items as $item): 
                $total += $item['subtotal'];
            ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td>₹<?php echo $item['cost_per_piece']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>₹<?php echo $item['subtotal']; ?></td>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                            <button type="submit" name="action" value="increase" class="btn btn-sm btn-success">+</button>
                            <button type="submit" name="action" value="decrease" class="btn btn-sm btn-danger">-</button>
                            <button type="submit" name="action" value="remove" class="btn btn-sm btn-warning">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2 class="text-end">Total: ₹<?php echo $total; ?></h2>
    <form method="POST" action="checkout.php" class="text-end">
        <button type="submit" class="btn btn-primary">Checkout</button>
    </form>
<?php else: ?>
    <p class="text-center">Your cart is empty.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
