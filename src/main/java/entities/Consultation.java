
package entities;

import java.util.Date;

public class Consultation {
    private int id;
    private int patient_id;
    private String patient_name;
    private int docteur_id;
    private String docteur_name;

    private int dossiermedical_id;
    private Date date_consultation;
    private String email;
    public Consultation() {
    }

    // Parameterized constructor
    public Consultation(int id, int patient_id, int docteur_id, int dossiermedical_id, Date date_consultation, String email) {
        this.id = id;
        this.patient_id = patient_id;
        this.docteur_id = docteur_id;
        this.dossiermedical_id = dossiermedical_id;
        this.date_consultation = date_consultation;
        this.email = email;
    }


    // Getter and Setter methods
    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getPatient_id() {
        return patient_id;
    }

    public void setPatient_id(int patient_id) {
        this.patient_id = patient_id;
    }

    public int getDocteur_id() {
        return docteur_id;
    }

    public void setDocteur_id(int docteur_id) {
        this.docteur_id = docteur_id;
    }

    public int getDossiermedical_id() {
        return dossiermedical_id;
    }

    public void setDossiermedical_id(int dossiermedical_id) {
        this.dossiermedical_id = dossiermedical_id;
    }

    public Date getDate_consultation() {
        return date_consultation;
    }

    public void setDate_consultation(Date date_consultation) {
        this.date_consultation = date_consultation;
    }

    public String getEmail() {
        return email;
    }

    public String getPatient_name() {
        return patient_name;
    }

    public String getDocteur_name() {
        return docteur_name;
    }

    public void setPatient_name(String patient_name) {
        this.patient_name = patient_name;
    }

    public void setDocteur_name(String docteur_name) {
        this.docteur_name = docteur_name;
    }

    public void setEmail(String email) {
        this.email = email;
    }
    public String toString() {
        return "Consultation{" +
                "id=" + id +
                ", patient_id=" + patient_id +
                ", docteur_id=" + docteur_id +
                ", dossiermedical_id=" + dossiermedical_id +
                ", date_consultation=" + date_consultation +
                ", email='" + email + '\'' +
                '}';
    }
}
