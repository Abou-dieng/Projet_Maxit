document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("verifierNciBtn").addEventListener("click", function () {
    const cni = document.getElementById("numerosCarteIdentite").value.trim();
    const cniPattern = /^[1-2][0-9]{12}$/;
    const successMsg = document.querySelector(".success-message");
    const errorMsg = document.querySelector(".error-message");
    const spinner = document.getElementById("spinner");
    const autofillFields = document.getElementById("autofillFields");
    const v = document.getElementById("verifierNciBtn");

    if (!cniPattern.test(cni)) {
      errorMsg.textContent = "Format du NCI invalide";
      errorMsg.classList.remove("hidden");
      successMsg.classList.add("hidden");
      autofillFields.style.display = "none";
      return;
    }

    spinner.classList.remove("hidden");
    successMsg.classList.add("hidden");
    errorMsg.classList.add("hidden");

    fetch(`https://appdaff-z58w.onrender.com/api/v1/citoyens/${cni}`)
      .then((response) => response.json())
      .then((data) => {
        console.log("Contenu complet reçu de l’API :", data);

        spinner.classList.add("hidden");
        v.disabled = true;

        const citoyen = data.data ?? data; // prend data.data si dispo, sinon data direct

        if (citoyen && citoyen.nci) {
          console.log("Données extraites:", citoyen);

          autofillFields.style.display = "block";

          document.getElementById("nom").value = citoyen.nom || "";
          document.getElementById("prenom").value = citoyen.prenom || "";
          document.getElementById("date_naissance").value = citoyen.date_naissance || "";
          document.getElementById("lieu_naissance").value = citoyen.lieu_naissance || "";
          document.getElementById("adresse").value = citoyen.adresse || "";
          document.getElementById("phone").value = citoyen.telephone || "";

          document.getElementById("nom").readOnly = true;
          document.getElementById("prenom").readOnly = true;
          document.getElementById("date_naissance").readOnly = true;
          document.getElementById("lieu_naissance").readOnly = true;

          successMsg.textContent = `✅ CNI trouvé : ${citoyen.nci}`;
          successMsg.classList.remove("hidden");
          errorMsg.classList.add("hidden");
        } else {
          errorMsg.textContent = data.message || "Aucune donnée trouvée pour ce NCI.";
          errorMsg.classList.remove("hidden");
          successMsg.classList.add("hidden");
          autofillFields.style.display = "none";
        }
      });
  })
});
