module com.example.gestion_reclamation_karim {
    requires javafx.controls;
    requires javafx.fxml;
    requires java.sql;
    requires twilio;
    requires org.apache.pdfbox;
    opens com.example.gestion_Yasmine to javafx.fxml;
    opens controllers to javafx.fxml;
    opens entities to javafx.base; // Open the entities package to javafx.base

    exports com.example.gestion_Yasmine;
    exports controllers;


   /* opens com.example.gestion_reclamation_karim to javafx.fxml;
    exports com.example.gestion_reclamation_karim;
    exports controllers;
    opens controllers to javafx.fxml;*/

}