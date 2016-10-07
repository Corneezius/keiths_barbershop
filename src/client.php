<?php

  class Client
  {
    private $name;
    private $barber_id;
    private $id;

    function __construct($client_name, $input_barber_id, $id = null)
    {
      $this->name = $client_name;
      $this->barber_id = $input_barber_id;
      //NOTE: Need this line in order to make client objects with a
      $this->id = $id;
    }

    function getId()
    {
      return $this->id;
    }

    function setClientName($client_name)
    {
      $this->name = $client_name;
    }

    function getClientName()
    {
      return $this->name;
    }

    function setBarberId($new_barber_id)
    {
      $this->barber_id = (int) $new_barber_id;
    }

    function getBarberId()
    {
      return $this->barber_id;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO clients (name, barber_id) VALUES ('{$this->getClientName()}', {$this->getBarberId()});");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function update($new_name)
    {
      $GLOBALS['DB']->exec("UPDATE clients SET name = '{$new_name}' WHERE barber_id = {$this->getBarberId()};");
      $this->setClientName($new_name);
    }

    // function getClients()
    // {
    //   $clients = array();
    //   $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients WHERE barber_id = {$this->getID()};");
    //
    //   foreach ($returned_clients as $client)
    //   {
    //     $client_name = $client['name'];
    //     $id = $client['id'];
    //     $barber_id = $client['barber_id'];
    //     $new_client = new Client($client_name, $barber_id, $id);
    //     array_push($clients, $new_client);
    //   }
    //     return $clients;
    //   }


      static function getAll()
      {
        $returned_clients = $GLOBALS["DB"]->query("SELECT * FROM clients;");
        $clients = array();
        foreach ($returned_clients as $client)
        {
            $name = $client['name'];
            $client_id = $client['id'];
            $barber_id = $client['barber_id'];
            $new_client = new Client($name, $barber_id, $client_id);
            array_push($clients, $new_client);
        }

        return $clients;
      }

      function delete()
      {
          $GLOBALS['DB']->exec("DELETE FROM clients WHERE id = {$this->getId()};");
      }

      static function deleteAll()
      {
          $GLOBALS['DB']->exec("DELETE from clients;");
      }

      static function find($search_id)
        {
            $found_client = null;
            $clients = Client::getAll();
            foreach($clients as $client)
            {
                $client_id = $client->getId();
                if ($client_id == $search_id)
                {
                    $found_client = $client;
                }
            }
            return $found_client;
        }
    }
?>
