<?php
include_once __DIR__ . "/database.php";
include "totalExpences.php";

$statement = $db->query("SELECT * FROM expenses");
$expenses = $statement->fetchAll(PDO::FETCH_ASSOC);


$monthlyExpenses = 0;
$currentMonth = date("Y-m");

foreach ($expenses as $expense) {
 $total_Expenses += $expense['amount'];
    if (substr($expense['date_expense'], 0, 7) === $currentMonth) {
        $monthlyExpenses += $expense['amount'];
    }
}

$stmt = $db->query("SELECT ROUND(SUM(amount), 2) as total FROM expenses WHERE YEAR(date_expense) = YEAR(NOW()) GROUP BY MONTH(date_expense)");
$monthlySums = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sum = 0;
foreach ($monthlySums as $month) {
    $sum += $month['total'];
}
$averageExpenses = count($monthlySums) > 0 ? $sum / count($monthlySums) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Wallet - Expense Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-50">

<div class="flex h-screen">

    <div class="w-64 bg-white border-r border-gray-200 flex flex-col">
        <div class="p-6 border-b">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Smart Wallet</h1>
            </div>
            <p class="text-gray-500 text-sm mt-1">Personal Finance Manager</p>
        </div>
        <nav class="flex-1 p-4">
            <ul class="space-y-2">
                <li>
                    <a href="index.php" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-tachometer-alt w-5"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="incomes.php" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-money-bill-wave w-5"></i>
                        <span>Incomes</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar-active flex items-center space-x-3 p-3 rounded-lg">
                        <i class="fas fa-shopping-cart w-5"></i>
                        <span>Expenses</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-file-export w-5"></i>
                        <span>Reports</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>


    <div class="flex-1 overflow-auto">
 
        <header class="bg-white border-b border-gray-200 px-8 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Expense Management</h2>
                    <p class="text-gray-600">Track and manage all your expenses</p>
                </div>
                <button id="addExpenseBtn" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 flex items-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>New Expense</span>
                </button>
            </div>
        </header>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl p-6">
                    <p>Total Expenses</p>
                    <h3 class="text-3xl font-bold mt-2">$<?= $total_Expenses ?>.00</h3>
                    <p class="text-red-100 mt-2">All time</p>
                </div>
                 <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                    <p>This Month</p>
                    <h3 class="text-3xl font-bold mt-2 text-gray-800">$<?= number_format($monthlyExpenses, 2) ?></h3>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                    <p>Average Monthly</p>
                    <h3 class="text-3xl font-bold mt-2 text-gray-800">$<?= number_format($averageExpenses, 2) ?></h3>
                </div>
            </div>

           
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left">Description</th>
                            <th class="px-6 py-4 text-left">Destination</th>
                            <th class="px-6 py-4 text-left">Amount</th>
                            <th class="px-6 py-4 text-left">Date</th>
                            <th class="px-6 py-4 text-left">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (count($expenses) > 0): ?>
                            <?php foreach ($expenses as $expense): ?>
                                <tr data-id="<?= $expense['id'] ?>" class="text-center">
                                    <td><?= htmlspecialchars($expense['description']) ?></td>
                                    <td><?= htmlspecialchars($expense['destination']) ?></td>
                                    <td>$<?= number_format($expense['amount'], 2) ?></td>
                                    <td><?= $expense['date_expense'] ?></td>
                                    <td class="flex gap-2 justify-center">
                                        <!-- Update Button - Should open modal with data -->
                                        <button class="updBtn bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600"
                                                onclick="openUpdateModal(<?= $expense['id'] ?>, '<?= htmlspecialchars(addslashes($expense['description'])) ?>', '<?= htmlspecialchars(addslashes($expense['destination'])) ?>', '<?= $expense['amount'] ?>', '<?= $expense['date_expense'] ?>')">
                                            Update
                                        </button>
                                       
                                        <form method="post" action="crud_expenses/delExpences.php" class="inline">
                                            <input type="hidden" name="id" value="<?= $expense['id'] ?>">
                                            <button type="submit" onclick="return confirm('Delete this expense?')" 
                                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-500">
                                    <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
                                    <p>No expense records found</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Expense Modal -->
<div id="expenseModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md slide-in">
        <div class="flex justify-between items-center mb-6">
            <h3 id="modalTitle" class="text-xl font-bold text-gray-800">Add New Expense</h3>
            <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form id="expenseForm" class="space-y-4" action="crud_expenses/addExpences.php" method="POST">
            <div>
                <label class="block text-gray-700 mb-2">Description *</label>
                <input type="text" name="description" required
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Groceries, Rent, Transportation, etc.">
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Destination *</label>
               <select name="destination" required
        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
    <option value="">Select Destination</option>
    <option value="shoping">shoping</option>
    <option value="food">food</option>
    <option value="bills">bills</option>
    <option value="transport">transport</option>
    <option value="trips">trips</option>
   
</select>
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Amount *</label>
                <input type="number" name="amount" step="0.01" min="0" required
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="0.00">
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Date *</label>
                <input type="date" name="date_expense" required
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mt-8 flex justify-end space-x-4">
                <button type="button" id="cancelBtn"
                        class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" id="submitBtn"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Save Expense
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Update Expense Modal -->
<div id="updateModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md slide-in">
        <div class="flex justify-between items-center mb-6">

            <h3 class="text-xl font-bold text-gray-800">Update Expense</h3>
            <button onclick="closeUpdateModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form id="updateForm" class="space-y-4" action="crud_expenses/updExpences.php" method="POST">
            <input type="hidden" id="updateId" name="id">
            <div>
                <label class="block text-gray-700 mb-2">Description *</label>
                <input type="text" id="updateDescription" name="description" required
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Destination *</label>
                <select id="updateDestination" name="destination" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Destination</option>
                        <option value="food">Food</option>
    <option value="shoping">shoping</option>
    <option value="food">food</option>
    <option value="bills">bills</option>
    <option value="transport">transport</option>
    <option value="trips">trips</option>
   
                            
                </select>
            
        
  
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Amount *</label>
                <input type="number" id="updateAmount" name="amount" step="0.01" min="0" required
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Date *</label>
                <input type="date" id="updateDate" name="date_expense" required
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mt-8 flex justify-end space-x-4">
                <button type="button" onclick="closeUpdateModal()"
                        class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                        class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Update Expense
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Modal functions
document.getElementById('addExpenseBtn').addEventListener('click', function() {
    document.getElementById('expenseModal').classList.remove('hidden');
});

document.getElementById('closeModal').addEventListener('click', function() {
    document.getElementById('expenseModal').classList.add('hidden');
});

document.getElementById('cancelBtn').addEventListener('click', function() {
    document.getElementById('expenseModal').classList.add('hidden');
});

// Update modal functions
function openUpdateModal(id, description, destination, amount, date) {
    document.getElementById('updateId').value = id;
    document.getElementById('updateDescription').value = description;
    document.getElementById('updateDestination').value = destination;
    document.getElementById('updateAmount').value = amount;
    document.getElementById('updateDate').value = date;
    document.getElementById('updateModal').classList.remove('hidden');
}

function closeUpdateModal() {
    document.getElementById('updateModal').classList.add('hidden');
}
</script>

</body>
</html>