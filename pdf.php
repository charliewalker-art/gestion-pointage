<?php
session_start();
require('config.php');
require_once __DIR__ . '/vendor/autoload.php';

use Mpdf\Mpdf;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['idEmploye'])) {
        $_SESSION['error'] = "Identifiant d'employé manquant.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $idEmploye = $_POST['idEmploye'];

    // Définir le chemin du dossier "fiche_de_paie" dans le projet
    $cheminDossier = __DIR__ . "/fiche_de_paie";

    // Vérifier si le dossier existe, sinon le créer
    if (!is_dir($cheminDossier)) {
        mkdir($cheminDossier, 0777, true);
    }

    // Récupération des données de l'employé
    $query = $pdo->prepare("SELECT * FROM EMPLOYE WHERE numEmp = :id");
    $query->execute(['id' => $idEmploye]);
    $employe = $query->fetch();

    if (!$employe) {
        $_SESSION['error'] = "Aucun employé trouvé avec le numero employe fourni.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Nombre d'absences
    $queryAbsences = $pdo->prepare("SELECT COUNT(*) as absences FROM POINTAGE WHERE numEmp = :id AND pointage = FALSE");
    $queryAbsences->execute(['id' => $idEmploye]);
    $absences = $queryAbsences->fetch()['absences'];

    // Calcul du salaire ajusté
    $salaireInitial = $employe['salaire'];
    $penalite = $absences * 10000;
    $salaireAjuste = $salaireInitial - $penalite;

    // Mise à jour du salaire dans la base de données
    $updateSalaire = $pdo->prepare("UPDATE EMPLOYE SET salaire = :salaire WHERE numEmp = :id");
    $updateSalaire->execute(['salaire' => $salaireAjuste, 'id' => $idEmploye]);

    // Génération de la fiche de paie
    $ficheDePaie = "
        <h1>Fiche de paie</h1>
        <p>Date : " . date('d/m/Y') . "</p>
        <p>Nom : " . $employe['Nom'] . "</p>
        <p>Prénoms : " . $employe['Prenom'] . "</p>
        <p>Poste : " . $employe['poste'] . "</p>
        <p>Nombre d'absences : " . $absences . "</p>
        <p>Salaire initial : " . $salaireInitial . " AR</p>
        <p>Pénalité pour absences : -" . $penalite . " AR</p>
        <p>Salaire ajusté : " . $salaireAjuste . " AR</p>
    ";

    try {
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($ficheDePaie);

        // Définir le nom du fichier PDF
        $pdfFileName = "fiche_de_paie_" . $idEmploye . ".pdf";
        $pdfFilePath = $cheminDossier . "/" . $pdfFileName;

        // Sauvegarde du fichier PDF
        $mpdf->Output($pdfFilePath, \Mpdf\Output\Destination::FILE);

        // Générer un lien complet en fonction de l'URL du serveur
        $serverUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
        $pdfUrl = $serverUrl . "/POO/Test5/fiche_de_paie/" . $pdfFileName;

        // Message de succès avec l'ID employé et le lien complet
        $_SESSION['success'] = "PDF généré avec succès pour l'employé ID <b>$idEmploye</b> : 
        <a href='$pdfUrl' target='_blank'>Ouvrir la fiche de paie</a>";
    } catch (Exception $e) {
        $_SESSION['error'] = "Erreur lors de la génération du PDF : " . $e->getMessage();
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
