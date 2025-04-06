// Fonction pour valider le formulaire d'inscription
function validateRegistrationForm() {
  const form = document.getElementById("registrationForm");
  if (!form) return;

  form.addEventListener("submit", function (e) {
    const password = document.getElementById("mot_de_passe").value;
    const phone = document.getElementById("telephone").value;

    // Validation du mot de passe
    if (password.length < 8) {
      e.preventDefault();
      alert("Le mot de passe doit contenir au moins 8 caractères");
      return;
    }

    // Validation du numéro de téléphone
    const phoneRegex = /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/;
    if (!phoneRegex.test(phone)) {
      e.preventDefault();
      alert("Numéro de téléphone invalide");
      return;
    }
  });
}

// Fonction pour gérer les créneaux de rendez-vous
function handleAppointmentSlots() {
  const dateInput = document.getElementById("date");
  const medecinSelect = document.getElementById("id_medecin");
  const heureSelect = document.getElementById("heure");

  if (!dateInput || !medecinSelect || !heureSelect) return;

  function updateSlots() {
    const medecinId = medecinSelect.value;
    const date = dateInput.value;

    if (medecinId && date) {
      fetch(`api/creneaux.php?medecin=${medecinId}&date=${date}`)
        .then((response) => response.json())
        .then((creneaux) => {
          heureSelect.innerHTML = '<option value="">Choisir une heure</option>';
          creneaux.forEach((creneau) => {
            const option = document.createElement("option");
            option.value = creneau;
            option.textContent = `${creneau}:00`;
            heureSelect.appendChild(option);
          });
        })
        .catch((error) => console.error("Erreur:", error));
    }
  }

  dateInput.addEventListener("change", updateSlots);
  medecinSelect.addEventListener("change", updateSlots);
}

// Initialisation
document.addEventListener("DOMContentLoaded", function () {
  validateRegistrationForm();
  handleAppointmentSlots();
});
