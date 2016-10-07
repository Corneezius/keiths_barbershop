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


    class ClientTest extends PHPUnit_Framework_TestCase
    {

      protected function tearDown()
      {
          Barber::deleteAll();
          Client::deleteAll();
      }
      // function test_getId()
      // {
      //     //ARRANGE
      //     $barber_name = "Keith";
      //     $test_barber = new Barber($barber_name);
      //     $test_barber->save();
      //     $barber_id = $test_barber->getId();
      //     $name = "Dad";
      //     $test_client = new Client($name, $barber_id);
      //     //ACT
      //     $result = $test_barber->getId();
      //     //ASSERT
      //     $this->assertEquals($id, $result);
      // }
      function test_getName()
      {
          //ARRANGE
          $barber_name = "Keith";
          $test_barber = new Barber($barber_name);
          $test_barber->save();
          $barber_id = $test_barber->getId();
          $name = "Dad";
          $test_client = new Client($name, $barber_id);
          //ACT
          $result = $test_client->getClientName();
          //ASSERT
          $this->assertEquals($name, $result);
      }
      function test_setName()
      {
          //ARRANGE
          $barber_name = "Keith";
          $test_barber = new Barber($barber_name);
          $test_barber->save();
          $barber_id = $test_barber->getId();
          $name = "Dad";
          $test_client = new Client($name, $barber_id);
          $new_name = "Luisa";
          //ACT
          $test_client->setClientName($new_name);
          $result = $test_client->getClientName();
          //ASSERT
          $this->assertEquals($new_name, $result);
      }
      function test_getBarberId()
      {
          //ARRANGE
          $barber_name = "Keith";
          $test_barber = new Barber($barber_name);
          $test_barber->save();
          $barber_id = $test_barber->getId();
          $name = "Dad";
          $test_client = new Client($name, $barber_id);
          //ACT
          $result = $test_client->getBarberId();
          //ASSERT
          $this->assertEquals($barber_id, $result);
      }
      function test_setBarberId()
      {
          //ARRANGE
          $barber_name = "Keith";
          $test_barber = new Barber($barber_name);
          $test_barber->save();
          $barber_id = $test_barber->getId();
          $barber_name = "Daniela";
          $test_barber2 = new Barber($barber_name);
          $test_barber2->save();
          $barber_id2 = $test_barber2->getId();
          $name = "Dad";
          $test_client = new Client($name, $barber_id);
          //ACT
          $test_client->setBarberId($barber_id2);
          $result = $test_client->getBarberId();
          //ASSERT
          $this->assertEquals($barber_id2, $result);
      }
      function test_save()
      {
          //Arrange
          $barber_name = "Keith";
          $test_barber = new Barber($barber_name);
          $test_barber->save();
          $barber_id = $test_barber->getId();
          $name = "Ema";
          $test_client = new Client($name, $barber_id);
          $test_client->save();
          //Act
          $result = Client::getAll();
          //Assert
          $this->assertEquals($test_client, $result[0]);
      }
      function test_getAll()
      {
          //Arrange
          $barber_name = "Keith";
          $test_barber = new Barber($barber_name);
          $test_barber->save();
          $barber_id = $test_barber->getId();
          $name = "Daisy";
          $name2 = "Martha";
          $test_client = new Client($name, $barber_id);
          $test_client->save();
          $test_client2 = new Client($name2, $barber_id);
          $test_client2->save();
          //Act
          $result = Client::getAll();
          //Assert
          $this->assertEquals([$test_client, $test_client2], $result);
      }
      function test_deleteAll()
      {
          //Arrange
          $barber_name = "Keith";
          $test_barber = new Barber($barber_name);
          $test_barber->save();
          $barber_id = $test_barber->getId();
          $name = "Dad";
          $name2 = "Eric";
          $test_client = new Client($name, $barber_id);
          $test_client->save();
          $test_client2 = new Client($name2, $barber_id);
          $test_client2->save();
          //Act
          Client::deleteAll();
          $result = Client::getAll();
          //Assert
          $this->assertEquals([], $result);
      }
      function test_Update()
      {
          //ARRANGE
          $name = "Shannon";
          $id = null;
          $test_client = new Client($name, $id);
          $test_client->save();
          $new_name = "Jorge";
          //ACT
          $test_client->update($new_name);
          //ASSERT
          $this->assertEquals("Jorge", $test_client->getClientName());
      }
      function testDelete()
      {
          //Arrange
          $barber_name = "Marge";
          $test_barber = new Barber($barber_name);
          $test_barber->save();
          $barber_id = $test_barber->getId();
          $barber_name2 = "Keith";
          $test_barber2 = new Barber($barber_name2);
          $test_barber2->save();
          $barber_id2 = $test_barber2->getId();
          $name = "Dad";
          $id = null;
          $test_client = new Client($name, $barber_id, $id);
          $test_client->save();
          $name2 = ";,.";
          $test_client2 = new Client($name2, $barber_id2, $id);
          $test_client2->save();
          //Act
          $test_client->delete();
          //Assert
          $this->assertEquals([$test_client2], Client::getAll());
      }
      function test_find()
      {
          //Arrange
          $barber_name = "Keith";
          $test_barber = new Barber($barber_name);
          $test_barber->save();
          $barber_id = $test_barber->getId();
          $name = "Denise";
          $name2 = "Ema";
          $test_Client = new Client($name, $barber_id);
          $test_Client->save();
          $test_Client2 = new Client($name2, $barber_id);
          $test_Client2->save();
          //Act
          $result = Client::find($test_Client->getId());
          //Assert
          $this->assertEquals($test_Client, $result);
      }
  }
?>
