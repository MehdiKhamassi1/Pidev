package Util;


import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class DataSource {
    String url = "jdbc:mysql://127.0.0.1:3306/notreatment1";
    String login = "root";
    String pwd = "";
    public  static DataSource db;
    public Connection con;
    public DataSource() {
        try {
            con= DriverManager.getConnection(url, login, pwd);
            System.out.println("Connected Successfully!");
        } catch (SQLException ex) {
            System.out.println(ex);
        }
    }

    public Connection  getConn()
    {
        return con;
    }
    public static DataSource getInstance()
    {if(db==null)
        db=new DataSource();
        return db;
    }




}
