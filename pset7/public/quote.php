<?php

    // configuration
    require("../includes/config.php"); 



    // if user reached page via GET
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("quote_form.php",["title"=> "quote"]);
        
    }
    //check if user has submitted symbol
    else if(isset($_POST["symbol"]) && $_POST["symbol"]){
        //search for symbol
        $stock = lookup($_POST["symbol"]);
        //if symbol not found
        if($stock === false){
            apologize("Symbol not found");
        }
        else{
            //render quote lookup
            render("quote_lookup.php",$stock);
        }
    }

?>
