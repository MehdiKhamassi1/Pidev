/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package controllers;


import com.example.gestion_Yasmine.GestionYasmine;
import entities.Consultation;
import entities.DossierMedical;
import entities.Statut;
import services.ServiceConsultation;
import services.ServiceDossierMedical;
import services.ServiceDossierMedical;
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
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.stage.Stage;

import java.io.IOException;
import java.net.URL;
import java.sql.Date;
import java.util.ArrayList;
import java.util.List;
import java.util.Objects;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;


/**
 * FXML Controller class
 *
 * @author winxspace
 */
public class FXMLDossierMController implements Initializable {


    public TextField tf_patient_id;
    public TextArea tfmaladie;
    public TextField tfrecherche;
    public TextField tfgrpsang;
 
    @FXML
    private ComboBox<String> status;
     @FXML
    private TableView<DossierMedical> tvresultat;
      ServiceDossierMedical str=new ServiceDossierMedical();
    ObservableList<String> data=FXCollections.observableArrayList();
      @FXML
       private TableColumn<DossierMedical, Integer> cid;
       @FXML
       private TableColumn<DossierMedical, Integer> c_patient_id;
        @FXML
       private TableColumn<DossierMedical, String> cgrpsang;
        @FXML
        private TableColumn<DossierMedical, Statut> cstatus;

        @FXML
        private TableColumn<DossierMedical, String> cmaladie;

    private ServiceDossierMedical serviceDossierMedical = new ServiceDossierMedical();
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        List<String> sts = new ArrayList<String>();
        sts.add("POSITIVE");
        sts.add("NEGATIVE");

        data.addAll(sts);
        status.setItems(data);

    }
    private void loadDossier() {
        List<DossierMedical> consultations = serviceDossierMedical.afficher();
        ObservableList<DossierMedical> dataList = FXCollections.observableArrayList(consultations);
        tvresultat.setItems(dataList);
    }

    @FXML
    private void afficher(ActionEvent event) {
        ObservableList<DossierMedical> dataList = FXCollections.observableArrayList(str.afficher());
        //cid.setCellValueFactory(new PropertyValueFactory<>("id"));
        c_patient_id.setCellValueFactory(new PropertyValueFactory<>("patient_id"));
        cgrpsang.setCellValueFactory(new PropertyValueFactory<>("groupesang"));
        cmaladie.setCellValueFactory(new PropertyValueFactory<>("maladie_chronique"));
        cstatus.setCellValueFactory(new PropertyValueFactory<>("resultat_analyse"));
        tvresultat.setItems(dataList);
    }

@FXML
private void display(ActionEvent event) {
    DossierMedical selectedDossier = tvresultat.getSelectionModel().getSelectedItem(); // Get selected item from table view
    if (selectedDossier != null) {
        // Display selected row data in text fields
       tf_patient_id.setText(String.valueOf(selectedDossier.getPatient_id()));
        tfgrpsang.setText(selectedDossier.getGroupesang());
        tfmaladie.setText(selectedDossier.getMaladie_chronique());



    }
}

@FXML
private void modifier(ActionEvent event) {

    DossierMedical selectedDossier = tvresultat.getSelectionModel().getSelectedItem(); // Get selected item from table view
    if (selectedDossier != null) {
        // Update selected row data with values from text fields
        selectedDossier.setPatient_id(Integer.parseInt(tf_patient_id.getText()));
        selectedDossier.setGroupesang(tfgrpsang.getText());
        String sts = status.getSelectionModel().getSelectedItem().toString();
        switch(sts) {
            case "POSITIVE" : {
                selectedDossier.setResultat_analyse(Statut.POSITIVE);
                break;
            }
            case "NEGATIVE" : {
                selectedDossier.setResultat_analyse(Statut.NEGATIVE);
                break;
            }

            default : {
                selectedDossier.setResultat_analyse(Statut.POSITIVE);
                break;
            }
        }

        selectedDossier.setMaladie_chronique(tfmaladie.getText());
        str.modifier(selectedDossier, selectedDossier.getId());
        tf_patient_id.clear();
        tfmaladie.clear();
        tfgrpsang.clear();
        tvresultat.refresh();
        loadDossier();
    }
}


    @FXML
    private void supprimer(ActionEvent event) throws Exception {
        ServiceDossierMedical sr = new ServiceDossierMedical();
        if(tvresultat.getSelectionModel().getSelectedItem()!=null){
            int id=tvresultat.getSelectionModel().getSelectedItem().getId();
            sr.supprimer(id);
            loadDossier();

        }
    }







    @FXML
    private void ajouterDossier(ActionEvent event) {
        Stage stageclose=(Stage)((Node)event.getSource()).getScene().getWindow();
        stageclose.close();
        try {
            Parent root=FXMLLoader.load(getClass().getResource("/FXMLAjoutDossier.fxml"));
            Scene scene = new Scene(root);
            Stage primaryStage=new Stage();
            primaryStage.setScene(scene);
            primaryStage.show();
        } catch (IOException ex) {
            Logger.getLogger(GestionYasmine.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    @FXML
    private void gstReponses(ActionEvent event) {
        Stage stageclose=(Stage)((Node)event.getSource()).getScene().getWindow();
        stageclose.close();
        try {
            Parent root=FXMLLoader.load(getClass().getResource("/FXMLConsul.fxml"));
            Scene scene = new Scene(root);
            Stage primaryStage = new Stage();
            primaryStage.setTitle("Dossier!");
            primaryStage.setScene(scene);
            primaryStage.show();
        } catch (IOException ex) {
            Logger.getLogger(GestionYasmine.class.getName()).log(Level.SEVERE, null, ex);
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
