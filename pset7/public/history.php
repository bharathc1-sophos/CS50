<?php
    // configuration
    require("../includes/config.php");
    if ($_SERVER["REQUEST_METHOD"] == "GET"){
        //get all the rows of user
        $rows=CS50::query("SELECT * FROM history WHERE user_id=?",$_SESSION["id"]);
        render("history_lookup.php",["positions" => $rows,"title" => "history"]);
    }
    redirect("/");
?>