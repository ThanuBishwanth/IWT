import javax.servlet.*;
import javax.servlet.http.*;
import java.io.IOException;

public class UserCookieServlet extends HttpServlet {
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        // Create a Cookie
        Cookie user1 = new Cookie("user1", "pwd1");
        Cookie user2 = new Cookie("user2", "pwd2");
        Cookie user3 = new Cookie("user3", "pwd3");
        Cookie user4 = new Cookie("user4", "pwd4");

        // Set expiration for cookies
        user1.setMaxAge(60 * 60); // 1 hour
        user2.setMaxAge(60 * 60);
        user3.setMaxAge(60 * 60);
        user4.setMaxAge(60 * 60);

        // Add cookies to the response
        response.addCookie(user1);
        response.addCookie(user2);
        response.addCookie(user3);
        response.addCookie(user4);

        response.setContentType("text/html");
        response.getWriter().println("Cookies for users have been set!");
    }
}
