<?php

    // configuration
    require("../includes/config.php"); 



    // else if user reached page via POST (as by submitting a form via POST)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("quote_form.php",["title"=> "quote"]);
        
    }
    else if(isset($_POST["symbol"]) && $_POST["symbol"]){
        $stock = lookup($_POST["symbol"]);
        if($stock === false){
            apologize("Symbol not found");
        }
        else{
            render("quote_lookup.php",$stock);
        }
    }

?>
