<?php include("config.php"); ?>

<div class="home">
    <section class="hero">
        <h2>Bienvenue au Cabinet Médical</h2>
        <p class="subtitle">Une équipe de professionnels à votre service</p>
    </section>

    <section class="services">
        <h3>Nos Services</h3>
        <div class="services-grid">
            <div class="service-card">
                <h4>Consultations</h4>
                <p>Consultations générales et spécialisées sur rendez-vous</p>
            </div>
            <div class="service-card">
                <h4>Urgences</h4>
                <p>Prise en charge rapide des urgences médicales</p>
            </div>
            <div class="service-card">
                <h4>Suivi médical</h4>
                <p>Suivi personnalisé de vos traitements</p>
            </div>
        </div>
    </section>

    <section class="appointments">
        <h3>Prise de Rendez-vous</h3>
        <p>Prenez rendez-vous en ligne avec nos praticiens :</p>
        <div class="cta-buttons">
            <a href="/rendez-vous" class="btn btn-primary">Prendre RDV</a>
            <a href="/urgence" class="btn btn-secondary">Urgence</a>
        </div>
    </section>

    <section class="contact-info">
        <h3>Informations Pratiques</h3>
        <div class="info-grid">
            <div class="info-item">
                <h4>Horaires</h4>
                <p>Lundi - Vendredi : 8h - 19h</p>
                <p>Samedi : 9h - 12h</p>
            </div>
            <div class="info-item">
                <h4>Contact</h4>
                <p>Tél : 01 23 45 67 89</p>
                <p>Email : contact@cabinet-medical.fr</p>
            </div>
            <div class="info-item">
                <h4>Adresse</h4>
                <p>123 rue de la Santé</p>
                <p>75000 Paris</p>
            </div>
        </div>
    </section>
</div>

<style>
.home {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.hero {
    text-align: center;
    margin-bottom: 40px;
}

.hero h2 {
    color: #2c3e50;
    font-size: 2.5em;
    margin-bottom: 10px;
}

.subtitle {
    color: #666;
    font-size: 1.2em;
}

.services-grid, .info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.service-card, .info-item {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.cta-buttons {
    text-align: center;
    margin: 30px 0;
}

.btn {
    display: inline-block;
    padding: 12px 24px;
    margin: 0 10px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
}

.btn-primary {
    background-color: #2c3e50;
    color: white;
}

.btn-secondary {
    background-color: #95a5a6;
    color: white;
}

section {
    margin-bottom: 40px;
}

h3 {
    color: #2c3e50;
    margin-bottom: 20px;
    text-align: center;
}

h4 {
    color: #34495e;
    margin-bottom: 10px;
}
</style> 