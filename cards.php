<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
require_once __DIR__ . "/database.php";
$stmt=$db->prepare("select* from cards where user_id=?");
$stmt->execute([$_SESSION["user_id"]]);

$cards=$stmt->fetchAll();
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
                        <a href="index.php"
                            class="flex items-center space-x-3 p-3 rounded-lg bg-gray-100 text-gray-700 font-medium">
                            <i class="fas fa-tachometer-alt w-5"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="incomes.php"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
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
                        <a href="cards.php"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-red-500">
                            <i class="fas fa-credit-card w-5"></i>
                            <span>my Card</span>
                        </a>
                    </li>

                    <li>
                        <a href="/auth/logout.php"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-red-500">
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
                        <button id="addCard"
                            class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center space-x-2">
                            <i class="fas fa-plus"></i> add card
                        </button>
                    </div>
                </div>
            </header>

            <main class="p-8">
                <div class="grid grid-cols-3 grid-rows-1 gap-5">

                    <?php 
                        foreach($cards as $e){
                            $class = isset($_SESSION["card_id"]) ? ($_SESSION["card_id"] === $e["ID"] ? "bg-green-500" : "bg-red-500") : "bg-red-500";
                            echo "
                                <div class='w-[500px] h-[250px] {$class}'>
                                    <h3>{$e["card_number"]}</h3>
                                    <form action='./getCard/selectedCard.php' method='POST'>
                                        <input type='hidden' name='id' value='{$e["ID"]}' >
                                        <button class='bg-yellow-400'>select</button>
                                    </form>
                                </div>

                            ";
                        }
                    ?>
                </div>
            </main>
        </div>

        <div id="cardModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-xl p-6 w-full max-w-md slide-in">
                <div class="flex justify-between items-center mb-6">
                    <h3 id="modalTitle" class="text-xl font-bold text-gray-800">Add New Income</h3>
                    <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                        <i id="colsingBtn" class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <form action="./getCard/addCard.php" method="POST" class="flex flex-col">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Bank Name
                        </label>
                        <select name="bank" id="cardModal"
                            class="block text-sm font-medium text-gray-700 mb-1 w-[80%] h-10">
                            <option value="CIH Bank">CIH bank</option>
                            <option value="BMCE">BMCE</option>
                            <option value="Bank Populaire">bank populaire</option>
                            <option value="Credit Maroc">credit_maroc</option>

                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Account Number
                        </label>
                        <input type="text" name="card_number" placeholder="XXXX XXXX XXXX"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            CVC code
                        </label>
                        <input type="text" name="cvc_code" placeholder="Your full name"
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
        </div>

    <script>
        const cardModal = document.getElementById("cardModal");
        const addCard = document.getElementById("addCard");
        const closeCardModal = document.getElementById("colsingBtn");

        closeCardModal.addEventListener("click", () => {
            cardModal.classList.add("hidden");
        });

        addCard.addEventListener("click", () => {
            cardModal.classList.remove("hidden");
        });

    </script>
</body>

</html>