<?php

    // configuration
    require("../includes/config.php"); 



    // else if user reached page via POST (as by submitting a form via POST)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $rows=CS50::query("SELECT symbol FROM portfolio WHERE user_id=?", $_SESSION["id"]);
        render("sell_form.php",["symbols"=> $rows , "title"=> "sell"]);
        
    }
    else if(isset($_POST["symbol"]) && $_POST["symbol"]){
        $rows=CS50::query("SELECT * FROM portfolio WHERE user_id=? AND symbol =?", $_SESSION["id"],$_POST["symbol"]);
        $shares=$rows[0]["shares"];
        $stock = lookup($_POST["symbol"]);
        
        
        CS50::query("DELETE FROM portfolio WHERE user_id=? AND symbol =?", $_SESSION["id"],$_POST["symbol"]);
        $gain=$shares*$stock["price"];
        
        
        $user=CS50::query("SELECT * FROM users WHERE id=?", $_SESSION["id"]);
        $cash=$user[0]["cash"];
        $cash=$cash+$gain;
        
        CS50::query("UPDATE users SET cash=? WHERE id=?",$cash, $_SESSION["id"]);
        CS50::query("INSERT INTO history (user_id,transaction,symbol,shares,price) VALUES (?,'SELL',?,?,?)",$_SESSION["id"],$stock["symbol"],$shares,$stock["price"]);
        redirect("/");
    }
    else{
        
        apologize("you haven't selected anything to sell");
    }

?>
