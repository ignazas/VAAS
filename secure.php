<?php
// Note that it is a good practice to NOT end your PHP files with a closing PHP tag.
    // This prevents trailing newlines on the file from being included in your output,
    // which can cause problems with redirecting users. 
    if(empty($_SESSION['user']))
    {
        // If they are not, we redirect them to the login page.
        header("Location: index.php?action=svecias");
        
        // Remember that this die statement is absolutely critical.  Without it,
        // people can view your members-only content without logging in.
        die("Redirecting to login.php");
    }
    
    // Everything below this point in the file is secured by the login system
    
    // We can display the user's username to them by reading it from the session array.  Remember that because
    // a username is user submitted content we must use htmlentities on it before displaying it to the user.
    
?>