<?php 
include "totalIncome.php";
include "totalExpences.php";

// Calculate balance
$balance = $total_Income - $total_Expenses;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinTrack - Personal Finance Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Your Original Sidebar -->
        <div class="w-64 bg-white border-r border-gray-200 flex flex-col">
            <div class="p-6 border-b">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">FinTrack</h1>
                </div>
                <p class="text-gray-500 text-sm mt-1">Personal Finance Manager</p>
            </div>
            
            <nav class="flex-1 p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="flex items-center space-x-3 p-3 rounded-lg bg-gray-100 text-gray-700 font-medium">
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
                        <a href="expences.php" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
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
                        <h2 class="text-2xl font-bold text-gray-800">Dashboard Overview</h2>
                        <p class="text-gray-600">Welcome back! Here's your financial summary</p>
                    </div>
                </div>
            </header>

            <main class="p-8">
                <!-- Financial Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Current Balance Card -->
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-2xl p-6 shadow-lg">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-blue-100">Current Balance</p>
                                <h3 class="text-3xl font-bold mt-2">$<?= number_format($balance, 2) ?></h3>
                                <p class="text-blue-100 mt-2 text-sm">
                                    <i class="fas <?= $balance >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' ?> mr-1"></i>
                                    <?= $balance >= 0 ? 'Positive balance' : 'Negative balance' ?>
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-blue-400 rounded-full flex items-center justify-center">
                                <i class="fas fa-wallet text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Income Card -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500">Total Income</p>
                                <h3 class="text-3xl font-bold mt-2 text-green-600">$<?= number_format($total_Income, 2) ?></h3>
                                <p class="text-green-500 mt-2 text-sm">
                                    <i class="fas fa-arrow-up mr-1"></i> All income sources
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-money-bill-wave text-green-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Expenses Card -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500">Total Expenses</p>
                                <h3 class="text-3xl font-bold mt-2 text-red-600">$<?= number_format($total_Expenses, 2) ?></h3>
                                <p class="text-red-500 mt-2 text-sm">
                                    <i class="fas fa-arrow-down mr-1"></i> All expenses
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-shopping-cart text-red-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Income vs Expenses Pie Chart -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Income vs Expenses</h3>
                        <div class="h-80 flex items-center justify-center">
                            <canvas id="incomeExpenseChart"></canvas>
                        </div>
                        <div class="mt-6 flex justify-center space-x-8">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                <span class="text-gray-700">Income</span>
                                <span class="ml-2 font-bold text-green-600">$<?= number_format($total_Income, 2) ?></span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                <span class="text-gray-700">Expenses</span>
                                <span class="ml-2 font-bold text-red-600">$<?= number_format($total_Expenses, 2) ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Summary -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Financial Summary</h3>
                        
                        <div class="space-y-6">
                            <!-- Income Section -->
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-700 font-medium">Income</span>
                                    <span class="font-bold text-green-600">$<?= number_format($total_Income, 2) ?></span>
                                </div>
                            </div>
                            
                            <!-- Expenses Section -->
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-700 font-medium">Expenses</span>
                                    <span class="font-bold text-red-600">$<?= number_format($total_Expenses, 2) ?></span>
                                </div>
                            </div>
                            
                            <!-- Balance Section -->
                            <div class="pt-4 border-t border-gray-200">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-gray-700 font-medium">Net Balance</p>
                                        <p class="text-sm text-gray-500">Income - Expenses</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-2xl font-bold <?= $balance >= 0 ? 'text-blue-600' : 'text-red-600' ?>">
                                            $<?= number_format($balance, 2) ?>
                                        </p>
                                        <p class="text-sm <?= $balance >= 0 ? 'text-green-600' : 'text-red-600' ?>">
                                            <?= $balance >= 0 ? '✓ Positive balance' : '⚠️ Negative balance' ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Quick Stats -->
                            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <p class="text-sm text-gray-500">Income Percentage</p>
                                    <p class="text-lg font-bold text-green-600">
                                        <?php 
                                        $total = $total_Income + $total_Expenses;
                                        if($total > 0) {
                                            echo number_format(($total_Income / $total) * 100, 1) . '%';
                                        } else {
                                            echo '0%';
                                        }
                                        ?>
                                    </p>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <p class="text-sm text-gray-500">Expense Percentage</p>
                                    <p class="text-lg font-bold text-red-600">
                                        <?php 
                                        if($total > 0) {
                                            echo number_format(($total_Expenses / $total) * 100, 1) . '%';
                                        } else {
                                            echo '0%';
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Circle/Pie Chart for Income vs Expenses
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('incomeExpenseChart').getContext('2d');
            
            new Chart(ctx, {
                type: 'pie', // Changed to pie chart
                data: {
                    labels: ['Income', 'Expenses'],
                    datasets: [{
                        data: [<?= $total_Income ?>, <?= $total_Expenses ?>],
                        backgroundColor: [
                            '#10b981', // Green for income
                            '#ef4444'  // Red for expenses
                        ],
                        borderWidth: 3,
                        borderColor: '#ffffff',
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Hide legend since we have our own
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += '$' + context.parsed.toFixed(2);
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>