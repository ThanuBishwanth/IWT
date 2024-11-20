import java.sql.*;

public class JDBCConnectivity {
    public static void main(String[] args) {
        String url = "jdbc:mysql://localhost:3306/user_management"; // Update if using Oracle
        String username = "root"; // Replace with your DB username
        String password = "root"; // Replace with your DB password

        try (Connection conn = DriverManager.getConnection(url, username, password)) {
            System.out.println("Connected to the database successfully!");

            // Insert Example
            String insertQuery = "INSERT INTO users (name, password, email_id, phone_number) VALUES (?, ?, ?, ?)";
            PreparedStatement pstmt = conn.prepareStatement(insertQuery);
            pstmt.setString(1, "John Doe");
            pstmt.setString(2, "password123");
            pstmt.setString(3, "john.doe@example.com");
            pstmt.setString(4, "9876543210");
            pstmt.executeUpdate();
            System.out.println("Inserted record successfully!");

            // Select Example
            String selectQuery = "SELECT * FROM users";
            Statement stmt = conn.createStatement();
            ResultSet rs = stmt.executeQuery(selectQuery);

            while (rs.next()) {
                System.out.println("User: " + rs.getString("name") + ", Email: " + rs.getString("email_id"));
            }
        } catch (SQLException e) {
            System.out.println("Error connecting to the database: " + e.getMessage());
        }
    }
}
