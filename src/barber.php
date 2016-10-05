<?php

  class Barber
  {
    private $name;
    private $id;

    function __construct($barber_name, $id = null)
    {
      $this->name = $barber_name;
      $this->id = $id;
    }

    function getId()
    {
      return $this->id;
    }

    function setName($barber_name)
    {
      $this->name = $barber_name;
    }

    function getName()
    {
      return $this->name;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO barbers (name) VALUES ('{$this->getName()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function getClients()
    {
      $clients = array();
      $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients WHERE barber_id = {$this->getId()};");

      foreach ($returned_clients as $client)
      {
        $client_name = $client['name'];
        $id = $client['id'];
        $barber_id = $client['barber_id'];
        $new_client = new Client($client_name, $barber_id, $id);
        array_push($clients, $new_client);
      }
        return $clients;
      }

      function update($barber_name)
      {
        $GLOBALS['DB']->exec("UPDATE barbers SET name = '{$barber_name}' WHERE id = {$this->getId()}");
        $this->setName($barber_name);
      }

      static function getAll()
      {
        $returned_barbers = $GLOBALS["DB"]->query("SELECT * FROM barbers;");
        $barbers = array();
        foreach ($returned_barbers as $barber)
        {
            $name = $barber['name'];
            $barber_id = $barber['id'];
            $new_barber = new Barber($name, $barber_id);
            array_push($barbers, $new_barber);
        }

        return $barbers;
      }

      function delete()
      {
        $GLOBALS['DB']->exec("DELETE FROM barbers WHERE id = {$this->getId()};");
        $GLOBALS['DB']->exec("DELETE FROM clients WHERE barber_id = {$this->getId()};");
      }

      static function deleteAll()
      {
          $GLOBALS['DB']->exec("DELETE from barbers;");
      }

      static function find($search_id)
        {
            $found_barber = null;
            $barbers = Barber::getAll();
            foreach($barbers as $barber)
            {
                $barber_id = $barber->getId();
                if ($barber_id == $search_id)
                {
                    $found_barber = $barber;
                }
            }
            return $found_barber;
        }
    }
?>
