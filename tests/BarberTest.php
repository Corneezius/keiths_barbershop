<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/barber.php";
    require_once "src/client.php";

    $server = 'mysql:host=localhost:8889;dbname=keiths_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class BarberTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
             Barber::deleteAll();
             Client::deleteAll();
        }

        function test_getId()
        {
          // Arrange
          $test_id = 1;
          $test_name = "Keith";
          $test_barber = new Barber ($test_name, $test_id);
          // Act
          $result = $test_barber->getId();
          // assert
          $this->assertEquals($result, $test_id);
        }

        function test_getName()
        {
          // Arrange
          $name = "Keith";
          $test_barber = new Barber($name);
          // Act
          $result = $test_barber->getName();
          // Assert
          $this->assertEquals($name,$result);
        }

      function test_setName()
      {
        // Arrange
        $name = "Keith";
        $test_barber = new Barber($name);
        $new_name = "Chan";
        // Act
        $test_barber->setName($new_name);
        $result  = $test_barber->getName();
        // Assert
        $this->assertEquals($new_name,$result);
      }

      function test_save()
      {
        // Arrange
        $name = "Keith";
        $test_barber = new Barber($name);
        $test_barber->save();
        // Act
        $result = Barber::getAll();
        // Assert
        $this->assertEquals($test_barber,$result[0]);
      }
      //
      function test_getAll()
      {// Arrange
      $name = "Keith";
      $test_barber = new Barber($name);
      $test_barber->save();
      $name2 = "Chan";
      $test_barber2 = new Barber ($name2);
      $test_barber2->save();
      // Act
      $result = Barber::getAll();
      // Assert
      $this->assertEquals([$test_barber, $test_barber2], $result);
      }
      //
      function test_deleteAll()
      {// Arrange
      $name = "Keith";
      $test_barber = new Barber($name);
      $test_barber->save();
      $name2 = "Chan";
      $test_barber2 = new Barber ($name2);
      $test_barber2->save();
      // Act
      Barber::deleteAll();
      $result = Barber::getAll();
      // Assert
      $this->assertEquals([], $result);
      }

      //
      function test_find()
      {// Arrange
      $name = "Keith";
      $test_barber = new Barber($name);
      $test_barber->save();
      $name2 = "Chan";
      $test_barber2 = new Barber ($name2);
      $test_barber2->save();
      // Act
      $result = Barber::find($test_barber->getId());
      // Assert
      $this->assertEquals($test_barber, $result);
      }
      //
      function test_getClients()
      {
          //ARRANGE
          $name = "Keith";
          $name2 = "Chan";
          $test_barber = new Barber($name);
          $test_barber->save();
          $test_barber_id = $test_barber->getId();
          $test_barber2 = new Barber($name2);
          $test_barber2->save();
          $test_barber_id2 = $test_barber2->getId();
          $client_name = "Eric";
          $test_client = new Client($client_name, $test_barber_id);
          $test_client->save();
          $client_name2 = "Dad";
          $test_client2 = new Client($client_name2, $test_barber_id);
          $test_client2->save();
          $client_name3 = "George";
          $test_client3 = new Client($client_name3, $test_barber_id2);
          $test_client3->save();
          //ACT
          $result = $test_barber->getClients();
          //ASSERT
          print("\nexpected value:\n");
          var_dump($test_client);
          print("\n");
          var_dump($test_client2);
          print("\n");

          print("\nresult:\n");
          var_dump($result);
          print("\n");

          $this->assertEquals([$test_client, $test_client2], $result);
      }
      //
      function test_Update()
      {
          //ARRANGE
          $name = "Keith";
          $test_barber = new Barber($name);
          $test_barber->save();
          $new_name = "Chan";
          //ACT
          $test_barber->update($new_name);
          //ASSERT
          $this->assertEquals("Chan", $test_barber->getName());
      }
      //
      function testDelete()
      {
          //Arrange
          $name = "Keith";
          $id = null;
          $test_barber = new Barber($name);
          $test_barber->save();
          $name2 = "Chan";
          $test_barber2 = new Barber($name2);
          $test_barber2->save();
          //Act
          $test_barber->delete();
          //Assert
          $this->assertEquals([$test_barber2], Barber::getAll());
      }

      function testDeleteBarberClients()
      {
          //Arrange
          $name = "Keith";
          $id = null;
          $test_barber = new Barber($name, $id);
          $test_barber->save();
          $client = "Tanya";
          $barber_id = $test_barber->getId();
          $test_client = new Client($client, $id, $barber_id);
          $test_client->save();
          //Act
          $test_barber->delete();
          //Assert
          $this->assertEquals([], Client::getAll());
      }
    }
?>
