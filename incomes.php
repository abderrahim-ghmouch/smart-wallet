<?php
include_once __DIR__ . "/database.php";

$stmt = $db->query("select * from incomes", PDO::FETCH_ASSOC);
$incomes = $stmt->fetchAll();

include "totalIncome.php";
$stmt = $db->query("Select round(sum(amount), 2) as total from incomes where MONTH(date_income) = Month(Now());", PDO::FETCH_ASSOC);
$this_Month = $stmt->fetchColumn(0);
$stmt = $db->query("Select round(sum(amount), 2) as total from incomes where YEAR(date_income) = YEAR(Now()) group by MONTH(date_income);", PDO::FETCH_ASSOC);
$all_Month = $stmt->fetchAll();

$sum = 0;

foreach ($all_Month as $element) {
    $sum += $element["total"];
}

$avreage = $sum / 12;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinTrack - Income Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css">

</head>

<body class="bg-gray-50 ">
    <!-- Main Container -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white border-r border-gray-200 flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">Smart Wallet</h1>
                </div>
                <p class="text-gray-500 text-sm mt-1">Personal Finance Manager</p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="index.php"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-tachometer-alt w-5"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="incomes.php" class="sidebar-active flex items-center space-x-3 p-3 rounded-lg">
                            <i class="fas fa-money-bill-wave w-5"></i>
                            <span>Incomes</span>
                        </a>
                    </li>
                    <li>
                        <a href="expences.php"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
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

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 px-8 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Income Management</h2>
                        <p class="text-gray-600">Track and manage all your income sources</p>
                    </div>
                    <button id="addIncomeBtn"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Add New Income</span>
                    </button>
                </div>


            </header>

            <!-- Stats Cards -->
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Total Income Card -->
                    <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-green-100">Total Income</p>
                                <h3 id="totalIncome" class="text-3xl font-bold mt-2">$<?= $total_Income ?>.00</h3>
                                <p class="text-green-100 mt-2">All time</p>
                            </div>
                            <div class="w-12 h-12 bg-green-400 rounded-full flex items-center justify-center">
                                <i class="fas fa-money-bill-wave text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- This Month Income -->
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500">This Month</p>
                                <h3 id="monthlyIncome" class="text-3xl font-bold mt-2 text-gray-800">
                                    $<?= $this_Month ?>.00</h3>

                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-blue-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Average Monthly -->
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500">Average Monthly</p>
                                <h3 id="averageIncome" class="text-3xl font-bold mt-2 text-gray-800">$<?= $avreage ?>
                                </h3>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-chart-bar text-purple-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Incomes Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800">Income Records</h3>
                        <p class="text-gray-600 text-sm mt-1">All your income transactions</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left py-4 px-6 text-gray-700 font-medium">
                                        <button class="flex items-center sortable" data-sort="description">
                                            Description <i class="fas fa-sort ml-2 text-gray-400"></i>
                                        </button>
                                    </th>
                                    <th class="text-left py-4 px-6 text-gray-700 font-medium">
                                        <button class="flex items-center sortable" data-sort="category">
                                            Category <i class="fas fa-sort ml-2 text-gray-400"></i>
                                        </button>
                                    </th>
                                    <th class="text-left py-4 px-6 text-gray-700 font-medium">
                                        <button class="flex items-center sortable" data-sort="amount">
                                            Amount <i class="fas fa-sort ml-2 text-gray-400"></i>
                                        </button>
                                    </th>
                                    <th class="text-left py-4 px-6 text-gray-700 font-medium">
                                        <button class="flex items-center sortable" data-sort="date">
                                            Date <i class="fas fa-sort ml-2 text-gray-400"></i>
                                        </button>
                                    </th>
                                    <th class="text-left py-4 px-6 text-gray-700 font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="incomesTableBody">
                              
                                <?php
                                if (count($incomes) > 0) {
                                    foreach ($incomes as $income) {
                                        echo "
                                                <tr data-id='{$income['id']}' class='text-center'>
                                                        <td>{$income['description']}</td>
                                                        <td>{$income['destination']}</td>
                                                        <td>{$income['amount']}</td>
                                                        <td>{$income['date_income']}</td>
                                                        <td class='flex gap-2'>
                                                 <button class='updBtn'>update</button> 
                                                 <form id='deletFom' method=\"post\" action=\"crud_incomes/delIcome.php\">
                                                 <input type=\"hidden\" name=\"id\" value=\"{$income["id"]}\" />
                                                 <button id='deleteButton'> delete</button>
                                                 </form>
                                                      </td>
                                                    </tr>
                                                ";
                                    }
                                } else {
                                    echo "
                                                <tr>
                                                    <td colspan='5' class='text-center py-8 text-gray-500' id='noIncomesMessage'>
                                                        <i class='fas fa-money-bill-wave text-4xl text-gray-300 mb-4'></i>
                                                        <p class='text-lg'>No income records found</p>
                                                        <p class='text-sm mt-1'>Click 'Add New Income' to get started</p>
                                                    </td>
                                                </tr>
                                            ";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div id="incomeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl p-6 w-full max-w-md slide-in">
            <div class="flex justify-between items-center mb-6">
                <h3 id="modalTitle" class="text-xl font-bold text-gray-800">Add New Income</h3>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <i id="colsingBtn" class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="incomeForm" class="space-y-4" action="./crud_incomes/addIncome.php" method="post">
                <input id="incomeId">

                <div>
                    <label class="block text-gray-700 mb-2">Description *</label>
                    <input type="text" id="description" name="description"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <div id="descriptioFnError" class="text-red-500 text-sm mt-1 ">Description is required</div>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Category *</label>
                    <select id="category" required name="destination"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Category</option>
                        <option value="freelance">freelance</option>
                        <option value="salary">salary</option>
                        <option value="buisness">buisness</option>
                        <option value="transfert">transfert</option>
                      
                    </select>
                    <div id="categoryError" class="text-red-500 text-sm mt-1">Category is required</div>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Amount *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500">$</span>
                        <input type="number" id="amount" step="0.01" min="0" name="amount" required
                            class="w-full p-3 pl-8 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="0.00">
                    </div>
                    <div id="amountError" class="text-red-500 text-sm mt-1 ">Amount must be greater than 0</div>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Date *</label>
                    <input type="date" id="date" name="date_income" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <div id="dateError" class="text-red-500 text-sm mt-1 ">Date is required</div>
                </div>

                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" id="cancelBtn"
                        class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Save Income
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="updateModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl p-6 w-full max-w-md slide-in">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Modify Income</h3>
                <button id="closeUpdate" class="text-gray-500 hover:text-gray-700">
                    <i id="colsingBtn" class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="incomeForm" class="space-y-4" action="./crud_incomes/updIcncomes.php" method="post">
                <input id="id" name="id" type="hidden">

                <div>
                    <label class="block text-gray-700 mb-2">Description *</label>
                    <input type="text" id="description" name="description"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <div id="descriptioFnError" class="text-red-500 text-sm mt-1 ">Description is required</div>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Category *</label>
                    <select id="category" required name="destination"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Category</option>
                        <option value="freelance">freelance</option>
                        <option value="salary">salary</option>
                        <option value="buisness">buisness</option>
                        <option value="transfert">transfert</option>
                      
                    </select>
                    <div id="categoryError" class="text-red-500 text-sm mt-1">Category is required</div>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Amount *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500">$</span>
                        <input type="number" id="amount" step="0.01" min="0" name="amount" required
                            class="w-full p-3 pl-8 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="0.00">
                    </div>
                    <div id="amountError" class="text-red-500 text-sm mt-1 ">Amount must be greater than 0</div>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Date *</label>
                    <input type="date" id="date_income" name="date_income" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <div id="dateError" class="text-red-500 text-sm mt-1 ">Date is required</div>
                </div>

                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" id="cancelBtn"
                        class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Save Income
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <script src="main.js"></script>

</body>

</html>