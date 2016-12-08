<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // TODO
        if (isset($_POST["username"]) && $_POST["username"]){
            if (isset($_POST["password"]) && $_POST["password"]){
                if($_POST["password"] == $_POST["confirmation"]){
                    $check=CS50::query("INSERT IGNORE INTO users (username, hash, cash) VALUES(?, ?, 10000.0000)", $_POST["username"], password_hash($_POST["password"], PASSWORD_DEFAULT));
                    if($check == 0){
                        apologize("username already exists");
                    }
                    else{
                       $rows = CS50::query("SELECT LAST_INSERT_ID() AS id");
                       $id=$rows[0]["id"];
                       $_SESSION["id"]=$id ;
                       redirect("/");
                    }
                }
                else{
                    apologize("your passwords did not match");
                }
            }
            else{
                apologize("you must enter your password");
            }
        }
        else{
            apologize("Username can not be empty");
        }
        
    }

?>