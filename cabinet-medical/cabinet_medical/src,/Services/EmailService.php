<?php include("config.php"); ?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService {
    private $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);
        
        // Configuration SMTP
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com'; // À modifier selon votre serveur SMTP
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'votre-email@gmail.com';
        $this->mailer->Password = 'votre-mot-de-passe';
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 587;
        $this->mailer->CharSet = 'UTF-8';
    }

    public function envoyerConfirmationInscription($email, $nom, $token) {
        try {
            $this->mailer->setFrom('no-reply@cabinet-medical.fr', 'Cabinet Médical');
            $this->mailer->addAddress($email);
            
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Confirmation de votre inscription';
            
            $lien = "http://localhost/cabinet_medical/index.php?page=validation&token=" . $token;
            
            $this->mailer->Body = "
                <h2>Bienvenue {$nom} !</h2>
                <p>Merci de votre inscription au Cabinet Médical.</p>
                <p>Pour valider votre compte, veuillez cliquer sur le lien suivant :</p>
                <p><a href='{$lien}'>Valider mon compte</a></p>
                <p>Si le lien ne fonctionne pas, copiez cette adresse dans votre navigateur :</p>
                <p>{$lien}</p>
            ";

            return $this->mailer->send();
        } catch (Exception $e) {
            error_log("Erreur d'envoi d'email: " . $e->getMessage());
            return false;
        }
    }

    public function envoyerRappelRendezVous($email, $nom, $date_rdv, $medecin) {
        try {
            $this->mailer->setFrom('no-reply@cabinet-medical.fr', 'Cabinet Médical');
            $this->mailer->addAddress($email);
            
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Rappel de rendez-vous';
            
            $date_formattee = date('d/m/Y à H:i', strtotime($date_rdv));
            
            $this->mailer->Body = "
                <h2>Rappel de votre rendez-vous</h2>
                <p>Bonjour {$nom},</p>
                <p>Nous vous rappelons votre rendez-vous prévu le {$date_formattee} avec le Dr. {$medecin}.</p>
                <p>En cas d'empêchement, merci de nous prévenir au moins 24h à l'avance.</p>
            ";

            return $this->mailer->send();
        } catch (Exception $e) {
            error_log("Erreur d'envoi d'email: " . $e->getMessage());
            return false;
        }
    }
}