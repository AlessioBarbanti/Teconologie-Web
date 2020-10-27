<?php

   class DBHelper{
      private $db;

      public function __construct($host, $user, $password, $db){
         $this->db = new mysqli($host, $user, $password, $db);
         if($this->db->connect_error){
            die("errore");
         }
      }


      public function getConcert(){
         $stmt = $this->db->prepare("SELECT * FROM concerto");
         $stmt->execute();
         $result = $stmt->get_result();
         $stmt->close();
         return $result->fetch_all(MYSQLI_ASSOC);
      }

      public function getAllConcert(){
         $stmt = $this->db->prepare("SELECT * FROM concerto ORDER BY 'data'");
         $stmt->execute();
         $result = $stmt->get_result();
         $stmt->close();
         return $result->fetch_all(MYSQLI_ASSOC);
      }

      public function getConcertEnding($limit){
         $stmt = $this->db->prepare("SELECT * FROM concerto ORDER BY 'data' LIMIT $limit");
         $stmt->execute();
         $result = $stmt->get_result();
         $stmt->close();
         return $result->fetch_all(MYSQLI_ASSOC);
      }

      public function getConcertlimit($limit){
         $stmt = $this->db->prepare("SELECT * FROM concerto ORDER BY Rand() LIMIT $limit");
         $stmt->execute();
         $result = $stmt->get_result();
         $stmt->close();
         return $result->fetch_all(MYSQLI_ASSOC);
      }

      public function getCredit($id){
         $stmt = $this->db->prepare("SELECT credito FROM utente where ID = $id");
         $stmt->execute();
         $result = $stmt->get_result();
         $stmt->close();
         return $result->fetch_all(MYSQLI_ASSOC);
      }

      public function updateCredit($credito, $id){
         $stmt = $this->db->prepare("UPDATE utente SET credito = $credito where id=$id");
         $stmt->execute();
         $stmt->close();
      }

      public function insertShipping($id, $nome, $cognome, $indirizzo, $zip, $telefono,$email){
         $stmt = $this->db->prepare("INSERT INTO indirizzo (id_utente, nome, cognome, indirizzo, zip, telefono, email) VALUES ($id, '$nome', '$cognome', '$indirizzo', '$zip', '$telefono', '$email')");
         $stmt->execute();
         $stmt->close();
        echo "<meta http-equiv='refresh' content='0'>";
      }

      public function updateShipping($id, $nome, $cognome, $indirizzo, $zip, $telefono,$email){
         $stmt = $this->db->prepare("UPDATE indirizzo SET nome = '$nome', cognome = '$cognome', indirizzo = '$indirizzo', zip = '$zip', telefono = '$telefono', email = '$email' WHERE id_utente = $id");
         $stmt->execute();
         $stmt->close();

      }

      public function updateTicketNumber($id, $quantity){
         $stmt = $this->db->prepare("UPDATE concerto SET n_biglietti = n_biglietti - $quantity WHERE ID = $id");
         $stmt->execute();
         $stmt->close();

      }

      public function getShipping($id){
         $stmt = $this->db->prepare("SELECT * FROM indirizzo where id_utente = $id");
         $stmt->execute();
         if($stmt){
            $result = $stmt->get_result();
            $stmt->close();
            return $result->fetch_all(MYSQLI_ASSOC);
         }
      }

      public function getShippingId(){
         $stmt = $this->db->prepare("SELECT id_utente FROM indirizzo");
         $stmt->execute();
         if($stmt){
            $result = $stmt->get_result();
            $stmt->close();
            return $result->fetch_all(MYSQLI_ASSOC);
         }
      }


      public function insertTicket($user_id, $concert_id){
         $stmt = $this->db->prepare("INSERT INTO biglietto (id_utente, id_concerto, data_acquisto) VALUES ($user_id, $concert_id, now())");
         $stmt->execute();
         $stmt->close();
      }

      public function getTicket($user_id){
         $stmt = $this->db->prepare("SELECT * FROM concerto JOIN biglietto ON concerto.id = biglietto.id_concerto AND biglietto.id_utente = $user_id");
         $stmt->execute();
         if($stmt){
            $result = $stmt->get_result();
            $stmt->close();
            return $result->fetch_all(MYSQLI_ASSOC);
         }
      }

   }
?>
