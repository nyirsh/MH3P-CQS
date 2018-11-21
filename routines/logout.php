<?

// Logout procedure
if (isset($_POST['logoutchk']))
{
    if ($isLogged)
    {
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        $_SESSION = array();
        session_unset();
        session_destroy();

        if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass']))
        {
           setcookie("cookname", "", time()-60*60*24*100, "/");
           setcookie("cookpass", "", time()-60*60*24*100, "/");
        }

        $isLogged = false;
    }
}

?>