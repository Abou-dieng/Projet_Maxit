// paiementWoyofal.js : gestion du paiement Woyofal

const btnWoyofal = document.getElementById("btnWoyofal");
const modalWoyofal = document.getElementById("modalWoyofal");
const closeWoyofal = document.getElementById("closeWoyofal");
const formWoyofal = document.getElementById("formWoyofal");
const spinnerWoyofal = document.getElementById("spinnerWoyofal");
const textWoyofal = document.getElementById("textWoyofal");
const resultWoyofal = document.getElementById("resultWoyofal");

if (btnWoyofal && modalWoyofal && closeWoyofal && formWoyofal) {
  btnWoyofal.onclick = () => {
    modalWoyofal.classList.remove("hidden");
    resultWoyofal.textContent = "";
    formWoyofal.reset();
  };
  closeWoyofal.onclick = () => {
    modalWoyofal.classList.add("hidden");
  };
  formWoyofal.onsubmit = async (e) => {
    e.preventDefault();
    spinnerWoyofal.classList.remove("hidden");
    textWoyofal.textContent = "Paiement...";
    resultWoyofal.textContent = "";
    const montant = document.getElementById("montantWoyofal").value;
    const apiUrl = "https://app-woyofal.onrender.com/api/paiement";
    try {
      const response = await fetch(apiUrl, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ montant })
      });
      const data = await response.json();
      if (response.ok) {
        resultWoyofal.textContent = "Paiement réussi !";
        resultWoyofal.classList.add("text-green-500");
      } else {
        resultWoyofal.textContent = data.error || "Erreur lors du paiement.";
        resultWoyofal.classList.add("text-red-500");
      }
    } catch (err) {
      resultWoyofal.textContent = "Erreur de connexion au service Woyofal.";
      resultWoyofal.classList.add("text-red-500");
    }
    spinnerWoyofal.classList.add("hidden");
    textWoyofal.textContent = "Payer";
  };
}
