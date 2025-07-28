// Animation du formulaire
document
  .getElementById("registerForm")
  .addEventListener("submit", function (e) {
    const btn = document.getElementById("submitBtn");
    const text = document.getElementById("submitText");

    // Vérifier que la date de naissance n'est pas vide
    const dateNaissance = document.getElementById("date_naissance").value;
    if (!dateNaissance) {
      e.preventDefault();
      alert(
        "Veuillez d'abord valider votre CNI pour récupérer vos informations."
      );
      return;
    }

    text.textContent = "Création en cours...";
    btn.disabled = true;
    btn.classList.add("opacity-60");
  });

// Validation du téléphone sénégalais
document.getElementById("phone").addEventListener("input", function (e) {
  const phone = e.target.value.replace(/\D/g, "");
  const isValid = /^(77|78|76|75|70)\d{7}$/.test(phone);

  if (phone.length > 0) {
    if (isValid) {
      e.target.classList.remove("border-red-500", "bg-red-50");
      e.target.classList.add("border-green-500", "bg-green-50");
    } else {
      e.target.classList.remove("border-green-500", "bg-green-50");
      e.target.classList.add("border-red-500", "bg-red-50");
    }
  } else {
    e.target.classList.remove(
      "border-red-500",
      "bg-red-50",
      "border-green-500",
      "bg-green-50"
    );
  }
});
const nciInput = document.getElementById("numerosCarteIdentite");
const autofillFields = document.getElementById("autofillFields");
const spinner = document.getElementById("spinner");

document.getElementById("verifierNciBtn").addEventListener("click", function () {
  const cni = nciInput.value.trim();
  const cniPattern = /^[1-2][0-9]{12}$/;
  const successMsg = nciInput.parentElement.querySelector(".success-message");
  const errorMsg = nciInput.parentElement.querySelector(".error-message");

  if (cniPattern.test(cni)) {
    if (cniPattern.test(cni)) {
      // Affiche le spinner
      spinner.classList.remove("hidden");
      spinner.style.display = "flex";
      spinner.style.position = "absolute";
      spinner.style.right = "12px";
      spinner.style.top = "50%";
      spinner.style.transform = "translateY(-50%)";
      successMsg.classList.add("hidden");
      errorMsg.classList.add("hidden");

      // Appel au proxy PHP local
      fetch("/api/verify-nci.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ nci: cni })
      })
        .then((response) => response.json())
        .then((data) => {
          spinner.classList.add("hidden");
          spinner.style.display = "none";
          if (data && !data.error) {
            autofillFields.style.display = "block";
            setFormData(data);
            successMsg.textContent = "CNI validé et informations récupérées.";
            successMsg.classList.remove("hidden");
            errorMsg.classList.add("hidden");
          } else {
            autofillFields.style.display = "none";
            errorMsg.textContent = data.error || "NCI invalide ou non trouvé.";
            errorMsg.classList.remove("hidden");
            successMsg.classList.add("hidden");
          }
        })
        .catch(() => {
          spinner.classList.add("hidden");
          spinner.style.display = "none";
          autofillFields.style.display = "none";
          errorMsg.textContent = "Erreur de connexion à l'API.";
          errorMsg.classList.remove("hidden");
          successMsg.classList.add("hidden");
        });
    } else {
      errorMsg.textContent = "Format du NCI invalide";
      errorMsg.classList.remove("hidden");
      spinner.classList.add("hidden");
      spinner.style.display = "none";
      autofillFields.style.display = "none";
      successMsg.classList.add("hidden");
    }
    if (cniPattern.test(cni)) {
      // Affiche le spinner
      spinner.classList.remove("hidden");
      spinner.style.display = "flex";
      spinner.style.position = "absolute";
      spinner.style.right = "12px";
      spinner.style.top = "50%";
      spinner.style.transform = "translateY(-50%)";
      successMsg.classList.add("hidden");
      errorMsg.classList.add("hidden");

      // Appel au proxy PHP local
      fetch("/api/verify-nci.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ nci: cni })
      })
        .then((response) => response.json())
        .then((data) => {
          spinner.classList.add("hidden");
          spinner.style.display = "none";
          if (data && !data.error) {
            autofillFields.style.display = "block";
            setFormData(data); // Remplit les champs autocomplétés
            successMsg.textContent = "CNI validé et informations récupérées.";
            successMsg.classList.remove("hidden");
            errorMsg.classList.add("hidden");
          } else {
            autofillFields.style.display = "none";
            errorMsg.textContent = data.error || "NCI invalide ou non trouvé.";
            errorMsg.classList.remove("hidden");
            successMsg.classList.add("hidden");
          }
        })
        .catch(() => {
          spinner.classList.add("hidden");
          spinner.style.display = "none";
          autofillFields.style.display = "none";
          errorMsg.textContent = "Erreur de connexion à l'API.";
          errorMsg.classList.remove("hidden");
          successMsg.classList.add("hidden");
        });
    } else {
      errorMsg.textContent = "Format du NCI invalide";
      errorMsg.classList.remove("hidden");
      spinner.classList.add("hidden");
      spinner.style.display = "none";
      autofillFields.style.display = "none";
      successMsg.classList.add("hidden");
    }
  }
});