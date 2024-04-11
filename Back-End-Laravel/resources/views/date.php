<?php
header("Content-type:application/javascript");
$Produs1=["ID"=>"P1","Pret"=>100,"Denumire"=>"Televizor"];
$Produs2=["ID"=>"P2","Pret"=>30,"Denumire"=>"Ipod"];
$Produse=[$Produs1,$Produs2];
$DateRaspuns=["Comanda"=>["Client"=>"PopIon","Produse"=>$Produse]];
$NumeFunctieClient=$_GET["callback"];
print $NumeFunctieClient."(".json_encode($DateRaspuns).")";
?>
