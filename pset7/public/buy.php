<?php

    // configuration
    require("../includes/config.php"); 



    // if user reached page via GET
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("buy_form.php",["title"=> "buy"]);
        
    }
    else if(isset($_POST["symbol"]) && $_POST["symbol"]){         //if user reached via post check for symbol  
        if(isset($_POST["shares"]) && $_POST["shares"]){
            $stock=lookup($_POST["symbol"]);
            //if user has submitted wrong symbol
            if($stock === false)
                apologize("Symbol doesn't exist!");
            //check whether user provided valid number of shares    
            $check=preg_match("/^\d+$/", $_POST["shares"]);
            
            if($check == true)
            {    
                $rows=CS50::query("SELECT * FROM users WHERE id=?",$_SESSION["id"]);
                $user_cash=$rows[0]["cash"];
                $required_cash=$stock["price"]*$_POST["shares"];
                if(($user_cash-$required_cash)<0)
                    apologize("you can't afford it");
                CS50::query("INSERT INTO portfolio (user_id, symbol, shares) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)",$_SESSION["id"],$stock["symbol"],$_POST["shares"]);
                CS50::query("UPDATE users SET cash=? WHERE id=?",$user_cash-$required_cash,$_SESSION["id"]);
                CS50::query("INSERT INTO history (user_id,transaction,symbol,shares,price) VALUES (?,'BUY',?,?,?)",$_SESSION["id"],$stock["symbol"],$_POST["shares"],$stock["price"]);
                redirect("/");
            }
            else{
            //if invalid number of shares provided
            apologize("please provide proper number of share");
            }
        }
        else{
            //if number of shares not provided
            apologize("please provide number of shares you want to buy");
        }
    }
    else{
        //if user has not submitted symbol
        apologize("please provide the symbol");         
    }

?>
