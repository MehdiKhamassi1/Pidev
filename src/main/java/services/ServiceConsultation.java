package services;


import Util.DataSource;
import entities.Consultation;
import entities.DossierMedical;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.List;
import java.sql.*;
import java.util.ArrayList;


public class ServiceConsultation implements Iservice<Consultation> {
    Connection conn = DataSource.getInstance().getConn();

    public ServiceConsultation() {

    }

    // Add a new Consultation object to the database
    @Override
    public void ajouter(Consultation consultation) {
        String query = "INSERT INTO consultation (patient_id, docteur_id, dossiermedical_id, date_consultation, email) " +
                "VALUES (?, ?, ?, ?, ?)";
        try (PreparedStatement stmt = conn.prepareStatement(query)) {
            stmt.setInt(1, consultation.getPatient_id());
            stmt.setInt(2, consultation.getDocteur_id());
            stmt.setInt(3, consultation.getDossiermedical_id());
            stmt.setDate(4, new java.sql.Date(consultation.getDate_consultation().getTime()));
            stmt.setString(5, consultation.getEmail());
            stmt.executeUpdate();
            System.out.println("Consultation added successfully.");
        } catch (SQLException e) {
            System.out.println("Error adding consultation: " + e.getMessage());
        }
    }

    // Modify an existing Consultation object in the database

    public void modifier(Consultation consultation, int id) {
        String query = "UPDATE consultation SET patient_id = ?, docteur_id = ?, dossiermedical_id = ?, date_consultation = ?, email = ? " +
                "WHERE id = ?";
        try (PreparedStatement stmt = conn.prepareStatement(query)) {
            stmt.setInt(1, consultation.getPatient_id());
            stmt.setInt(2, consultation.getDocteur_id());
            stmt.setInt(3, consultation.getDossiermedical_id());
            stmt.setDate(4, new java.sql.Date(consultation.getDate_consultation().getTime()));
            stmt.setString(5, consultation.getEmail());
            stmt.setInt(6, consultation.getId());
            stmt.executeUpdate();
            System.out.println("Consultation updated successfully.");
        } catch (SQLException e) {
            System.out.println("Error updating consultation: " + e.getMessage());
        }
    }



    @Override
    // Delete a Consultation object from the database
    public void supprimer(int id) {
        String query = "DELETE FROM consultation WHERE id = ?";
        try (PreparedStatement stmt = conn.prepareStatement(query)) {
            stmt.setInt(1, id);
            stmt.executeUpdate();
            System.out.println("Consultation deleted successfully.");
        } catch (SQLException e) {
            System.out.println("Error deleting consultation: " + e.getMessage());
        }
    }

    // Display a list of all Consultation objects from the database
    @Override
    public List<Consultation> afficher() {
        List<Consultation> consultations = new ArrayList<>();
        String query = "SELECT consultation.id, date_consultation, consultation.email, doctors.nom AS doctor_name," +
                " doctors.prenom AS doctor_surname," +
                " doctors.id AS doctor_id," +
                " patients.nom AS patient_name," +
                "patients.prenom AS patient_surname, " +
                "patients.id AS patient_id, " +
                "dossiermedical_id\n" +
                "FROM consultation\n" +
                "INNER JOIN user AS doctors ON consultation.docteur_id = doctors.id\n" +
                "INNER JOIN user AS patients ON consultation.patient_id = patients.id\n";
        try (Statement stmt = conn.createStatement(); ResultSet rs = stmt.executeQuery(query)) {
            while (rs.next()) {
                Consultation consultation = new Consultation();
                consultation.setId(rs.getInt("id"));
                consultation.setDocteur_id(rs.getInt("doctor_id"));
                consultation.setPatient_id(rs.getInt("patient_id"));
                consultation.setId(rs.getInt("id"));
                consultation.setPatient_name(rs.getString("patient_name")+" "+rs.getString("patient_surname"));
                consultation.setDocteur_name(rs.getString("doctor_name")+" "+rs.getString("doctor_surname"));
                consultation.setDossiermedical_id(rs.getInt("dossiermedical_id"));
                consultation.setDate_consultation(rs.getDate("date_consultation"));
                consultation.setEmail(rs.getString("email"));
                System.out.println(consultation);
                consultations.add(consultation);
            }
            System.out.println("Consultations displayed successfully.");
        } catch (SQLException e) {
            System.out.println("Error displaying consultations: " + e.getMessage());
        }
        return consultations;
    }





}

