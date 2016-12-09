<?php

    // configuration
    require("../includes/config.php"); 

    // render portfolio
    if(isset($_SESSION["id"])){
    $positions = [];
    $rows=CS50::query("SELECT * FROM portfolio WHERE user_id=?", $_SESSION["id"]);
    $bal=CS50::query("SELECT * FROM users WHERE id=?", $_SESSION["id"]);
    $cash=$bal[0]["cash"];
    foreach ($rows as $row)
    {
        $stock = lookup($row["symbol"]);
        if ($stock !== false)
        {
            $positions[] = [
            "name" => $stock["name"],
            "price" => number_format($stock["price"], 2, '.', ','),
            "shares" => $row["shares"],
            "symbol" => $row["symbol"],
            "total"  => $row["shares"]*$stock["price"]
            ];
        }
    }
                 $positions[] = [
            "name" => "",
            "price" => "",
            "shares" => "",
            "symbol" => "CASH",
            "total"  => $cash
            ];
    
    render("portfolio.php",["positions" => $positions, "title" => "Portfolio"]);
    }
    
?>
