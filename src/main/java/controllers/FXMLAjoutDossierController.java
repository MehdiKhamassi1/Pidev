 /*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package controllers;

 import com.example.gestion_Yasmine.GestionYasmine;
 import entities.DossierMedical;
 import entities.Statut;
 import javafx.collections.FXCollections;
 import javafx.collections.ObservableList;
 import javafx.scene.control.ComboBox;
 import services.ServiceDossierMedical;
 import javafx.event.ActionEvent;
 import javafx.fxml.FXML;
 import javafx.fxml.FXMLLoader;
 import javafx.fxml.Initializable;
 import javafx.scene.Node;
 import javafx.scene.Parent;
 import javafx.scene.Scene;
 import javafx.scene.control.Alert;
 import javafx.scene.control.TextArea;
 import javafx.scene.control.TextField;
 import javafx.scene.image.ImageView;
 import javafx.scene.layout.AnchorPane;
 import javafx.stage.Stage;

 import java.io.IOException;
 import java.net.URL;
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
public class FXMLAjoutDossierController implements Initializable {

    @FXML
    private AnchorPane anchore;
    @FXML
    private TextField tfgrpsang;
    @FXML
    private TextArea tfmaladie;
    @FXML
    private ImageView img;
    @FXML
    private TextField tfid;

     @FXML
     private ComboBox<String> tfresultat_analyse;
     ObservableList<String> data= FXCollections.observableArrayList();
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        List<String> sts = new ArrayList<String>();
        sts.add("POSITIVE");
        sts.add("NEGATIVE");

        data.addAll(sts);
        tfresultat_analyse.setItems(data);

    }

    @FXML
    private void ajouter(ActionEvent event) {
        
          if (controleDeSaisie().length() > 0) {
        Alert alert = new Alert(Alert.AlertType.WARNING);
        alert.setTitle("Erreur d'ajout");
        alert.setContentText(controleDeSaisie());
        alert.show();
    } else {

        DossierMedical r = new DossierMedical();
        r.setGroupesang(tfgrpsang.getText());
        r.setMaladie_chronique(tfmaladie.getText());
        r.setPatient_id(Integer.parseInt(tfid.getText()));
         if (tfresultat_analyse.getSelectionModel().getSelectedItem().equals(Statut.NEGATIVE.toString())) {
               r.setResultat_analyse(Statut.NEGATIVE);
              } else  r.setResultat_analyse(Statut.POSITIVE);

        ServiceDossierMedical sr = new ServiceDossierMedical();
        sr.ajouter(r);

        Alert alert=new Alert(Alert.AlertType.INFORMATION);
            alert.setTitle("Dossier Medical");
            alert.setContentText("dossier ajouté avec succes");
            alert.showAndWait();

               tfgrpsang.clear();
        tfmaladie.clear();
        tfid.clear();


      
        }
        
    }

     public String controleDeSaisie() {
         StringBuilder erreur = new StringBuilder();

         // Vérification de groupesang
         if (tfgrpsang.getText().trim().isEmpty()) {
             erreur.append("Groupe sanguin vide!\n");
         }
         String gsang = tfgrpsang.getText().trim();
         if(
                 !gsang.equals("A-") &&
                         !gsang.equals("A+") &&
                         !gsang.equals("B-") &&
                         !gsang.equals("B+") &&
                         !gsang.equals("AB+") &&
                         !gsang.equals("AB-") &&
                         !gsang.equals("O-") &&
                         !gsang.equals("O+")
         ) {
             erreur.append("Groupe sanguin invalide!\n");
         }

         // Vérification de maladie_chronique
         if (tfmaladie.getText().trim().isEmpty()) {
             erreur.append("Maladie chronique vide!\n");
         }

         // Vérification de patient_id
         String patientIdStr = tfid.getText().trim();
         if (patientIdStr.isEmpty()) {
             erreur.append("Patient ID vide!\n");
         } else {
             try {
                 int patientId = Integer.parseInt(patientIdStr);
                 if (patientId <= 0) {
                     erreur.append("Patient ID doit être un entier positif!\n");
                 }
             } catch (NumberFormatException e) {
                 erreur.append("Patient ID doit être un entier!\n");
             }
         }



         return erreur.toString();
     }

     @FXML
    private void gstDossier(ActionEvent event) {
        Stage stageclose=(Stage)((Node)event.getSource()).getScene().getWindow();
        stageclose.close();
        try {
            Parent root=FXMLLoader.load(Objects.requireNonNull(getClass().getResource("/FXMLDossierM.fxml")));
            Scene scene = new Scene(root);
            Stage primaryStage=new Stage();
            primaryStage.setTitle("Consultation");
            primaryStage.setScene(scene);
            primaryStage.show();
        } catch (IOException ex) {
            Logger.getLogger(GestionYasmine.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

}
