/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.jspdisscussionboard;

import java.sql.Timestamp;
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.io.PrintWriter;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.List;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

/**
 *
 * @author besseym
 */
@WebServlet(name = "DiscussionBoard", urlPatterns = {"/DiscussionBoard"})
public class DiscussionBoard extends HttpServlet {

    
    private List<String> posts;
    private List<String> usernames;
    private List<String> timeStamps;
    
     public void addPost(String username, String post, String timeStamp) {
        
         try { 
               String dataDirectory = System.getenv("OPENSHIFT_DATA_DIR");
               File file = new File(dataDirectory + "/DiscussionBoardData.txt");
               
               BufferedWriter writer = new BufferedWriter(new FileWriter(file, true));
               writer.write(post + "\n" + timeStamp + "\n" + username + "\n");
               writer.close(); 

          } catch (IOException e) {
               e.printStackTrace();
          }
        
    }
    
     public void getDiscussionBoard() {
          posts      = new ArrayList<String>();
          usernames  = new ArrayList<String>();
          timeStamps = new ArrayList<String>();

          try {
               String dataDirectory = System.getenv("OPENSHIFT_DATA_DIR");
               File file = new File(dataDirectory + "/DiscussionBoardData.txt");
                
               BufferedReader reader = new BufferedReader(new FileReader(file));

               String line = "";
               int change = 0;
                       
               while ((line = reader.readLine()) != null) 
               {
                   if (change == 0)
                   {
                       posts.add(line);
                       change = 1;
                   }
                   
                   else if (change == 1)
                   {
                       timeStamps.add(line);
                       change = 2;
                   }
                   
                   else
                   {
                       usernames.add(line);
                       change = 0;  
                   }
               }

          } catch (IOException e) {
               e.printStackTrace();
          }
     }
    
    
    /**
     * Processes requests for both HTTP <code>GET</code> and <code>POST</code>
     * methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        try (PrintWriter out = response.getWriter()) {
            
            HttpSession session = request.getSession(true);
            String username = session.getAttribute("username").toString();
            
            String timeStamp = new SimpleDateFormat("HH:mm.ss MM/dd/yyyy").format(new java.util.Date());
            
            String post = request.getParameter("post");
            
            if (post != null)
                addPost(username, post, timeStamp);
            
            getDiscussionBoard();
            
            
            /* TODO output your page here. You may use following sample code. */
            out.println("<!DOCTYPE html>");
            out.println("<html>");
            out.println("<head>");
            out.println("<title>Discussion Board</title>");
            out.println("<link rel=\"stylesheet\" type=\"text/css\" href=\"JSP.css\">");
            out.println("</head>");
            out.println("<body>");
            out.println("<h1>Discussion Board</h1>");
            out.println("<a href=\"addToDiscussionBoard.jsp\">Add Post to Discussion Board</a>");

            for (int i = usernames.size() - 1; i >= 0 ; i--)
            {
                 out.println("<div class='wholePost'>");
                 
                 out.println("<span id='time'>" + timeStamps.get(i) + "</span>");
                 out.println("<span id='user'>" + usernames.get(i) + "</span>");
                 out.println("</br>");
                 out.println("<span id='post'>" + posts.get(i) + "</span>");
                 
                 out.println("</div>");
            }
            out.println("</body>");
            out.println("</html>");
        }
    }

    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /**
     * Handles the HTTP <code>GET</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Handles the HTTP <code>POST</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Returns a short description of the servlet.
     *
     * @return a String containing servlet description
     */
    @Override
    public String getServletInfo() {
        return "Short description";
    }// </editor-fold>

}
