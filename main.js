const incomeModal = document.getElementById("incomeModal");
const addIncome = document.getElementById("addIncomeBtn");
const closeAddBtn = document.getElementById("colsingBtn");

addIncome.addEventListener("click", () => {
    incomeModal.classList.remove("hidden");
});

closeAddBtn.addEventListener("click", () => {
    incomeModal.classList.add("hidden");
});



const updateButtons = document.querySelectorAll(".updBtn");
const updateModal = document.getElementById("updateModal");
const cancelUpdate = document.getElementById("closeUpdate");

updateButtons.forEach(button => {
    button.addEventListener("click", (e) => {
        e.preventDefault();
        let tds = button.parentElement.parentElement.children;
        let id = button.parentElement.parentElement.dataset.id;
        
        updateModal.querySelector("#id").value = id;
        updateModal.querySelector("#description").value = tds[0].textContent;
        updateModal.querySelector("#category").value = tds[1].textContent;
        updateModal.querySelector("#amount").value = tds[2].textContent;
        updateModal.querySelector("#date_income").value = tds[3].textContent;
        updateModal.classList.remove("hidden");
    });
});


cancelUpdate.addEventListener("click", () => {
    updateModal.classList.add("hidden");
});


const expensesButton = document.getElementById("addExpenseBtn")
const expModal = document.getElementsByName("expenseModal")

expensesButton.addEventListener("click",()=>{
    
    expModal.classList.remove("hidden")
})