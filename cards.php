<?php
session_start();

if(!isset($_SESSION["user_id"])){
    header("Location: login.php");
    exit();
}


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
                    <h1 class="text-2xl font-bold text-gray-800">Smart Wallet</h1>
                </div>
                <p class="text-gray-500 text-sm mt-1">Personal Finance Manager</p>
            </div>
            
            <nav class="flex-1 p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="index.php" class="flex items-center space-x-3 p-3 rounded-lg bg-gray-100 text-gray-700 font-medium">
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
                        <a href="cards.php" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-red-500">
                        <i class="fas fa-credit-card w-5"></i>
                            <span>my Card</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="/auth/logout.php" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-red-500">
                            <i class="fas fa-file-export w-5"></i>
                            <span>log out</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>


        <div class="flex-1 overflow-auto">
    
        <header class="bg-white border-b border-gray-200 px-8 py-4">
        <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Cards Overview</h2>
                        <p class="text-gray-600">Welcome back! Here's your cards</p>
                    </div>
                    <div>
                        <button class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center space-x-2">
                            <i class="fas fa-plus"></i> add card
                        </button>
                    </div>
                </div>
            </header>

            <main class="p-8">

        <div class="col-sm-6">


    
<div class="w-[40%] h-screen absolute backdrop-bkur-md">
    
    <form action="GetCard.php/addCard.php" method="POST" class="flex flex-col">

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
        Bank Name
        </label>
        <select name="bank" id="cardModal" class="block text-sm font-medium text-gray-700 mb-1 w-[80%] h-10">
            <option value="CIH">CIH bank</option>
            <option value="BMCE">BMCE</option>
            <option value="bank_pop">bank populaire</option>
            <option value="post">post maroc</option>
            <option value="credit_maroc">credit_maroc</option>
            
        </select>
    </div>
    
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Account Number
        </label>
        <input type="text" name="account_number" placeholder="XXXX XXXX XXXX"
        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
    </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
            CVC code
            </label>
            <input type="text" name="account_holder" placeholder="Your full name"
              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
          </div>

      <div>

        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
            Save Bank Info
        </button>

    </div>

    </form>
</div>
      <div>

  </div>
        
        </div>
    </div>

   
</body>
</html>