// Gestionnaire de formulaires
class FormHandler {
  static initialize() {
    document.querySelectorAll("form").forEach((form) => {
      form.addEventListener("submit", this.handleSubmit);
    });
  }

  static async handleSubmit(event) {
    const form = event.target;
    if (form.hasAttribute("data-confirm")) {
      if (!confirm(form.getAttribute("data-confirm"))) {
        event.preventDefault();
        return;
      }
    }
  }
}

// Gestionnaire de rendez-vous
class AppointmentHandler {
  static initialize() {
    const dateInput = document.getElementById("appointment-date");
    const medecinSelect = document.getElementById("medecin-select");

    if (dateInput && medecinSelect) {
      dateInput.addEventListener("change", () => this.loadTimeSlots());
      medecinSelect.addEventListener("change", () => this.loadTimeSlots());
    }
  }

  static async loadTimeSlots() {
    const date = document.getElementById("appointment-date").value;
    const medecinId = document.getElementById("medecin-select").value;
    const container = document.getElementById("time-slots");

    if (!date || !medecinId) return;

    try {
      const response = await fetch(
        `/api/creneaux?date=${date}&medecin=${medecinId}`
      );
      const slots = await response.json();

      container.innerHTML = slots
        .map(
          (slot) => `
              <button class="time-slot" data-time="${slot}">
                  ${slot}
              </button>
          `
        )
        .join("");

      this.initializeSlotSelection();
    } catch (error) {
      console.error("Erreur lors du chargement des créneaux:", error);
    }
  }

  static initializeSlotSelection() {
    document.querySelectorAll(".time-slot").forEach((slot) => {
      slot.addEventListener("click", () => {
        document
          .querySelectorAll(".time-slot")
          .forEach((s) => s.classList.remove("selected"));
        slot.classList.add("selected");
        document.getElementById("appointment-time").value = slot.dataset.time;
      });
    });
  }
}

// Gestionnaire de documents
class DocumentHandler {
  static initialize() {
    const fileInput = document.getElementById("document-upload");
    if (fileInput) {
      fileInput.addEventListener("change", this.handleFileSelect);
    }
  }

  static handleFileSelect(event) {
    const file = event.target.files[0];
    if (file) {
      const maxSize = 5 * 1024 * 1024; // 5MB
      if (file.size > maxSize) {
        alert("Le fichier est trop volumineux. Taille maximum : 5MB");
        event.target.value = "";
      }
    }
  }
}

// Initialisation
document.addEventListener("DOMContentLoaded", () => {
  FormHandler.initialize();
  AppointmentHandler.initialize();
  DocumentHandler.initialize();
});
