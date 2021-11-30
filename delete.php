<?php

require_once "_connect.php";
require_once 'lib/Database.php';

$data = Database::getInstance();

$bookingID = $_POST['id'];
$passengerId = $_POST['passengerId'];
$ticketId = $_POST['ticketId'];

$deleteBookingID = $data->query("DELETE FROM booking WHERE id = $bookingID;");
$deletePassengerId = $data->query("DELETE FROM passenger WHERE passenger.id = $passengerId;");
$deleteTicketId = $data->query("DELETE FROM ticket WHERE id = $passengerId;");

if ($deleteBookingID && $deletePassengerId && $deleteTicketId) {
  echo "Votre billet d'avion a été annulé, vous allez être remboursé prochainement";
  header('location:/index.php');
}