<%-- 
    Document   : SubmitLogin
    Created on : Mar 7, 2015, 10:18:37 AM
    Author     : besseym
--%>

<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Submit Login</title>
    </head>
    <body>
        <h1>Discussion Board Login:</h1>
        
        <form action="Login" method="POST"> 
              Username: <input type="text" name="username" /><br /> 
              Login: <input type="password" name="password" /><br /> 
              <input type="submit" value="Login" /> 
        </form>

    </body>
</html>
