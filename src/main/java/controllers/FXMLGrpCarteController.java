package controllers;

import entities.Consultation;
import entities.DossierMedical;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.FlowPane;
import services.ServiceConsultation;
import services.ServiceDossierMedical;

import java.io.IOException;
import java.util.List;

public class FXMLGrpCarteController {

    @FXML
    private FlowPane cardContainer;

    private final ServiceConsultation consultationService = new ServiceConsultation();
    private final ServiceDossierMedical dossierMedicalService = new ServiceDossierMedical();

    public void initialize() {
        // Fetch consultations from the database
        List<Consultation> consultations = consultationService.afficher();

        // Load and add multiple instances of FXMLCarte to the cardContainer
        for (Consultation consultation : consultations) {
            addCard(consultation);
        }
    }

    private void addCard(Consultation consultation) {
        try {
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/FXMLCarte.fxml"));
            AnchorPane card = loader.load();

            FXMLCarteController carteController = loader.getController();

            // Fetch the corresponding DossierMedical for the current consultation
            DossierMedical dossierMedical = dossierMedicalService.getDossierMedicalByConsultationId(consultation.getId());

            if (dossierMedical != null) {
                carteController.setConsultationInfo(
                        consultation.getPatient_name(),
                        dossierMedical.getGroupesang(),
                        dossierMedical.getMaladie_chronique(),
                        dossierMedical.getResultat_analyse().toString(),
                        String.valueOf(consultation.getDate_consultation()),
                        consultation.getEmail()
                );

                cardContainer.getChildren().add(card);
            } else {
                System.out.println("Dossier medical not found for the consultation: " + consultation.getId());
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}
