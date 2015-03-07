<%-- 
    Document   : addToDiscussionBoard
    Created on : Mar 7, 2015, 12:39:05 PM
    Author     : besseym
--%>

<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>JSP Page</title>
    </head>
    <body>
        <h1>Insert into Discussion Board</h1>
        
        <a href="DiscussionBoard">View Discussion Board</a>
        
        <form action="DiscussionBoard" method="POST"> 
              Discussion Board Post: <input type="textarea" name="post" /><br /> 
              <input type="submit" value="Add Post" /> 
        </form>
    </body>
</html>
