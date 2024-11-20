<%@ page import="java.sql.*" %>
<%
    String name = request.getParameter("name");
    String password = request.getParameter("password");
    String email = request.getParameter("email");
    String phone = request.getParameter("phone");

    if (name != null && password != null && email != null && phone != null) {
        String url = "jdbc:mysql://localhost:3306/user_management";
        String dbUser = "root";
        String dbPassword = "root";

        try (Connection conn = DriverManager.getConnection(url, dbUser, dbPassword)) {
            String query = "INSERT INTO users (name, password, email_id, phone_number) VALUES (?, ?, ?, ?)";
            PreparedStatement pstmt = conn.prepareStatement(query);
            pstmt.setString(1, name);
            pstmt.setString(2, password);
            pstmt.setString(3, email);
            pstmt.setString(4, phone);
            pstmt.executeUpdate();
            out.println("User registered successfully!");
        } catch (SQLException e) {
            out.println("Error: " + e.getMessage());
        }
    }
%>
<form method="post">
    Name: <input type="text" name="name" required><br>
    Password: <input type="password" name="password" required><br>
    Email: <input type="email" name="email" required><br>
    Phone: <input type="text" name="phone" required><br>
    <button type="submit">Register</button>
</form>
