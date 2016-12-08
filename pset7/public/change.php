<?php
    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("change_form.php", ["title" => "Change Password"]);
    }
    else
    {
        if (isset($_POST["old_password"]) && $_POST["old_password"]){
            // query database for user
            $rows = CS50::query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);


            // first (and only) row
            $row = $rows[0];

            // compare hash of user's input against hash that's in database
            if (password_verify($_POST["old_password"], $row["hash"]))
            {
                if (isset($_POST["password"]) && $_POST["password"]){
                    
                    if($_POST["password"] == $_POST["confirmation"]){
                        $check=CS50::query("UPDATE users SET hash=? WHERE id=?", password_hash($_POST["password"], PASSWORD_DEFAULT) , $_SESSION["id"]);
                        if($check == 0){
                            apologize("username already exists");
                        }
                    }
                    else{
                        apologize("your passwords did not match");
                    }
                }
                else{
                    apologize("you must enter your new password");
                }

                // redirect to portfolio
                redirect("/");
            }
            apologize("invalid password");
        }
        else{
            apologize("old password can not be empty");
        }
    }
?>