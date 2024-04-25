package controllers;

import java.io.IOException;
import java.net.URL;
import java.util.List;
import java.util.ResourceBundle;

import com.example.gestion_Yasmine.GestionYasmine;
import com.twilio.rest.api.v2010.account.incomingphonenumber.Local;
import entities.DossierMedical;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.*;
import java.util.Date;
import java.util.logging.Level;
import java.util.logging.Logger;
import java.time.LocalDate;
import entities.Consultation;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.stage.Stage;
import services.ServiceConsultation;
import services.ServiceDossierMedical;
public class FXMLConsultationController implements Initializable {
    @FXML
    private TableView<Consultation> tvConsultations;
    @FXML
    private TableColumn<Consultation, Integer> colId;
    @FXML
    private TableColumn<Consultation, Integer> colPatientId;
    @FXML
    private TableColumn<Consultation, Integer> colDocteurId;
    @FXML
    private TableColumn<Consultation, Integer> colDossierMedicalId;
    @FXML
    private TableColumn<Consultation, Date> colDateConsultation;
    @FXML
    private TableColumn<Consultation, String> colEmail;

    @FXML
    private TextField tfPatientId;
    @FXML
    private TextField tfDocteurId;
    @FXML
    private TextField tfDossierMedicalId;
    @FXML
    private DatePicker dpDateConsultation;
    @FXML
    private TextField tfEmail;

    private ServiceConsultation serviceConsultation = new ServiceConsultation();
    private ServiceDossierMedical serviceDossierMedical = new ServiceDossierMedical();
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // Initialize columns and load initial data
        //colId.setCellValueFactory(new PropertyValueFactory<>("id"));
        colPatientId.setCellValueFactory(new PropertyValueFactory<>("patient_name"));
        colDocteurId.setCellValueFactory(new PropertyValueFactory<>("docteur_name"));
        colDossierMedicalId.setCellValueFactory(new PropertyValueFactory<>("dossiermedical_id"));
        colDateConsultation.setCellValueFactory(new PropertyValueFactory<>("date_consultation"));
        colEmail.setCellValueFactory(new PropertyValueFactory<>("email"));

        loadConsultations();
    }

    private void loadConsultations() {
        List<Consultation> consultations = serviceConsultation.afficher();
        ObservableList<Consultation> dataList = FXCollections.observableArrayList(consultations);
        tvConsultations.setItems(dataList);
    }


    @FXML
    private void handleAjouter(ActionEvent event) {
        // Appel de la fonction de contrôle de saisie
        String erreurs = controleDeSaisie();
        if (!erreurs.isEmpty()) {
            // S'il y a des erreurs, affichez une alerte
            Alert alert = new Alert(Alert.AlertType.WARNING);
            alert.setTitle("Erreur d'ajout");
            alert.setHeaderText(null);
            alert.setContentText(erreurs);
            alert.showAndWait();
            return;  // Arrête l'ajout si des erreurs sont détectées
        }

        // Si aucune erreur n'est détectée, récupérer les données de l'interface utilisateur
        int patientId = Integer.parseInt(tfPatientId.getText());
        int docteurId = Integer.parseInt(tfDocteurId.getText());
        int dossierMedicalId = Integer.parseInt(tfDossierMedicalId.getText());
        Date dateConsultation = java.sql.Date.valueOf(dpDateConsultation.getValue());
        String email = tfEmail.getText().trim();

        // Crée une nouvelle instance de Consultation
        Consultation consultation = new Consultation(0, patientId, docteurId, dossierMedicalId, dateConsultation, email);

        // Appeler le service pour ajouter la nouvelle consultation
        serviceConsultation.ajouter(consultation);

        // Rafraîchir la vue de la table et vider les champs de saisie
        loadConsultations();
        clearInputs();
    }

    @FXML
    private void handleModifier(ActionEvent event) {
        Consultation selectedConsultation = tvConsultations.getSelectionModel().getSelectedItem();

        if (selectedConsultation != null) {

            // Update consultation attributes from the UI
            selectedConsultation.setPatient_id(Integer.parseInt(tfPatientId.getText()));
            selectedConsultation.setDocteur_id(Integer.parseInt(tfDocteurId.getText()));
            selectedConsultation.setDossiermedical_id(Integer.parseInt(tfDossierMedicalId.getText()));
            selectedConsultation.setDate_consultation(java.sql.Date.valueOf(dpDateConsultation.getValue()));
            selectedConsultation.setEmail(tfEmail.getText());

            String erreurs = controleDeSaisie();
            if (!erreurs.isEmpty()) {
                // S'il y a des erreurs, affichez une alerte
                Alert alert = new Alert(Alert.AlertType.WARNING);
                alert.setTitle("Erreur d'ajout");
                alert.setHeaderText(null);
                alert.setContentText(erreurs);
                alert.showAndWait();
                return;  // Arrête l'ajout si des erreurs sont détectées
            }
            // Call the service to update the consultation
            serviceConsultation.modifier(selectedConsultation, selectedConsultation.getId());

            // Refresh the table view and clear input fields
            loadConsultations();
            clearInputs();
        } else {
            System.out.println("Please select a consultation to modify.");
        }
    }

    @FXML
    private void handleSupprimer(ActionEvent event) {
        Consultation selectedConsultation = tvConsultations.getSelectionModel().getSelectedItem();

        if (selectedConsultation != null) {
            // Call the service to delete the consultation
            serviceConsultation.supprimer(selectedConsultation.getId());

            // Refresh the table view
            loadConsultations();
        } else {
            System.out.println("Please select a consultation to delete.");
        }
    }
    public String controleDeSaisie() {
        StringBuilder erreurs = new StringBuilder();

        // Vérification de patient_id
        String patientIdStr = tfPatientId.getText().trim();
        if (patientIdStr.isEmpty()) {
            erreurs.append("Patient ID est vide!\n");
        } else {
            try {
                int patientId = Integer.parseInt(patientIdStr);
                if (patientId <= 0) {
                    erreurs.append("Patient ID doit être un entier positif!\n");
                }
            } catch (NumberFormatException e) {
                erreurs.append("Patient ID doit être un entier!\n");
            }
        }

        // Vérification de docteur_id
        String docteurIdStr = tfDocteurId.getText().trim();
        if (docteurIdStr.isEmpty()) {
            erreurs.append("Docteur ID est vide!\n");
        } else {
            try {
                int docteurId = Integer.parseInt(docteurIdStr);
                if (docteurId <= 0) {
                    erreurs.append("Docteur ID doit être un entier positif!\n");
                }
            } catch (NumberFormatException e) {
                erreurs.append("Docteur ID doit être un entier!\n");
            }
        }

        // Vérification de dossiermedical_id
        String dossierMedicalIdStr = tfDossierMedicalId.getText().trim();
        if (dossierMedicalIdStr.isEmpty()) {
            erreurs.append("Dossier médical ID est vide!\n");
        } else {
            try {
                int dossierMedicalId = Integer.parseInt(dossierMedicalIdStr);
                if (dossierMedicalId <= 0) {
                    erreurs.append("Dossier médical ID doit être un entier positif!\n");
                }
            } catch (NumberFormatException e) {
                erreurs.append("Dossier médical ID doit être un entier!\n");
            }
        }

        // Vérification de la date de consultation
        if (dpDateConsultation.getValue() == null) {
            erreurs.append("Date de consultation est vide!\n");
        } else {
            Date dateConsultation = java.sql.Date.valueOf(dpDateConsultation.getValue());
            if (dateConsultation == null) {
                erreurs.append("Date de consultation invalide!\n");
            }
            Date today = new Date();
            System.out.println(today);
            if(today.after(dateConsultation)) {
                erreurs.append("Date de consultation invalide!\n");
            }
        }

        // Vérification de l'email
        String email = tfEmail.getText().trim();
        if (email.isEmpty()) {
            erreurs.append("Email est vide!\n");
        } else {
            // Vous pouvez ajouter ici des vérifications supplémentaires pour l'email (par exemple, un format valide)
            if (!email.contains("@") || !email.contains(".")) {
                erreurs.append("Email doit être valide (ex. user@example.com)!\n");
            }
        }

        return erreurs.toString();
    }

    private void clearInputs() {
        tfPatientId.clear();
        tfDocteurId.clear();
        tfDossierMedicalId.clear();
        dpDateConsultation.setValue(null);
        tfEmail.clear();
    }

    @FXML
    private void Retour(ActionEvent event) {
        Stage stageclose=(Stage)((Node)event.getSource()).getScene().getWindow();
        stageclose.close();
        try {
            Parent root= FXMLLoader.load(getClass().getResource("/FXMLDossierM.fxml"));
            Scene scene = new Scene(root);
            Stage primaryStage=new Stage();
            primaryStage.setScene(scene);
            primaryStage.show();
        } catch (IOException ex) {
            Logger.getLogger(GestionYasmine.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    @FXML
    private void handleCarteSelection(ActionEvent event) {
        Consultation selectedConsultation = tvConsultations.getSelectionModel().getSelectedItem();

        if (selectedConsultation != null) {
            try {
                DossierMedical dossierMedical = serviceDossierMedical.getDossierMedicalById(selectedConsultation.getDossiermedical_id());
                if (dossierMedical != null) {
                    FXMLLoader loader = new FXMLLoader(getClass().getResource("/FXMLCarte.fxml"));
                    Parent root = loader.load();
                    FXMLCarteController controller = loader.getController();
                    controller.setConsultationInfo(
                            selectedConsultation.getPatient_name(),
                            dossierMedical.getGroupesang(),
                            dossierMedical.getMaladie_chronique(),
                            dossierMedical.getResultat_analyse().toString(),
                            String.valueOf(selectedConsultation.getDate_consultation()),
                            selectedConsultation.getEmail()
                    );
                    Stage stage = new Stage();
                    stage.setScene(new Scene(root));
                    stage.show();
                } else {
                    System.out.println("Dossier medical not found for the selected consultation.");
                }
            } catch (IOException e) {
                System.out.println("Error loading FXMLCarte.fxml: " + e.getMessage());
            } catch (Exception e) {
                System.out.println("Error fetching dossier medical: " + e.getMessage());
            }
        } else {
            System.out.println("Please select a consultation to view the card.");
        }
    }

    @FXML
    private void handleGroupe(ActionEvent event) {
        try {
            // Load the FXML file for the new interface
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/FXMLGrpCarte.fxml"));
            Parent root = loader.load();

            // Create a new stage for the new interface
            Stage stage = new Stage();
            stage.setScene(new Scene(root));
            stage.setTitle("Consultation Group");

            // Show the new interface
            stage.show();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }



}

