<?php

    // configuration
    require("../includes/config.php"); 



    // if user reached page via GET
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $rows=CS50::query("SELECT symbol FROM portfolio WHERE user_id=?", $_SESSION["id"]);
        if(!empty($rows))
            render("sell_form.php",["symbols"=> $rows , "title"=> "sell"]);
        apologize("Nothing to sell");    
        
    }
    //check if user has submitted symbol
    else if(isset($_POST["symbol"]) && $_POST["symbol"]){
        //find out number of shares user owns for that particular symbol
        $rows=CS50::query("SELECT * FROM portfolio WHERE user_id=? AND symbol =?", $_SESSION["id"],$_POST["symbol"]);
        $shares=$rows[0]["shares"];
        
        //get the price of the symbol and caluculate the gain
        $stock = lookup($_POST["symbol"]);
        CS50::query("DELETE FROM portfolio WHERE user_id=? AND symbol =?", $_SESSION["id"],$_POST["symbol"]);
        $gain=$shares*$stock["price"];
        
        //select user current cash and add it with gain
        $user=CS50::query("SELECT * FROM users WHERE id=?", $_SESSION["id"]);
        $cash=$user[0]["cash"];
        $cash=$cash+$gain;
        
        //update history table and user table
        CS50::query("UPDATE users SET cash=? WHERE id=?",$cash, $_SESSION["id"]);
        CS50::query("INSERT INTO history (user_id,transaction,symbol,shares,price) VALUES (?,'SELL',?,?,?)",$_SESSION["id"],$stock["symbol"],$shares,$stock["price"]);
        redirect("/");
    }
    else{
        
        apologize("you haven't selected anything to sell");
    }

?>
