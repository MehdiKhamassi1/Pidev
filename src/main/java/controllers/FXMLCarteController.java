package controllers;

import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;

import entities.Consultation;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Label;
import javafx.scene.image.ImageView;

public class FXMLCarteController implements Initializable {

    @FXML
    private ImageView image;

    @FXML
    private Label labeldate;

    @FXML
    private Label labelemail;

    @FXML
    private Label labelmaladie;

    @FXML
    private Label labelpatient;

    @FXML
    private Label labelresultat;

    @FXML
    private Label labelsang;

    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // Initialize your controller here
    }

    public void setConsultationInfo(String patientId, String groupeSang, String maladieChronique, String resultatAnalyse, String date_consultation, String email) {
        labelpatient.setText(patientId);
        labelsang.setText(groupeSang);
        labelmaladie.setText(maladieChronique);
        labelresultat.setText(resultatAnalyse);
        labeldate.setText(date_consultation);
        labelemail.setText(email);
    }

    public void setSelectedConsultation(Consultation consultation) {
        labelpatient.setText(String.valueOf(consultation.getPatient_id()));
        labelsang.setText("Groupe Sang Value"); // Set the actual groupe sang value
        labelmaladie.setText("Maladie Chronique Value"); // Set the actual maladie chronique value
        labelresultat.setText("Resultat Analyse Value"); // Set the actual resultat analyse value
        labeldate.setText(String.valueOf(consultation.getDate_consultation()));
        labelemail.setText(consultation.getEmail());    }

}

