<?php
  # file: AP_Mysqli_classes.inc.php
  # extends mysqli and mysqli_result classes to provide for
  # exception handling

class AP_Mysqli extends mysqli
{
  public function connect($host = NULL, $user = NULL, $pass = NULL, 
                          $db = NULL, $port = NULL, $socket = NULL)
  {
    $link = parent::connect($host, $user, $pass, $db, $port, $socket);

    if( mysqli_connect_errno() )
      throw new AP_MysqliException(mysqli_connect_error(), $this->sqlstate);

    return $link;
  }

  public function query($query)
  {
    $result = parent::query($query);

    if($this->errno)
      throw new AP_MysqliException($this->error, $this->sqlstate);

    $result->link = $this;
    return $result;
  }

  public function prepare($sql)
  {
    $stmt = parent::prepare($sql);

    if($this->errno)
      throw new AP_MysqliException($this->error, $this->sqlstate);

    return $stmt;
  }

  public function multi_query($sql)
  {
    $result = parent::multi_query($sql);

    if($this->errno)
      throw new AP_MysqliException($this->error, $this->sqlstate);

    return $result;
  }

  public function store_result()
  {
    $result = parent::store_result();

    if($this->errno)
      throw new AP_MysqliException($this->error, $this->sqlstate);

    return $result;
  }

  public function use_result()
  {
    $result = parent::use_result();

    if($this->errno)
      throw new AP_MysqliException($this->error, $this->sqlstate);

    return $result;
  }

  public function more_results()
  {
    $result = parent::more_results();

    if($this->errno)
      throw new AP_MysqliException($this->error, $this->sqlstate);

    return $result;
  }

  public function next_result()
  {
    $result = parent::next_result();

    if($this->errno)
      throw new AP_MysqliException($this->error, $this->sqlstate);

    return $result;
  }
}

class AP_MysqliResult extends mysqli_result
{
  public function fetch_array()
  {
    $row = parent::fetch_array();

    if($this->link->errno)
      throw new AP_MysqliException($this->link->error, 
                                    $this->link->sqlstate);

    return $row;
  }

  public function fetch_assoc()
  {
    $row = parent::fetch_assoc();

    if($this->link->errno)
      throw new AP_MysqliException($this->link->error, 
                                    $this->link->sqlstate);

    return $row;
  }

  public function fetch_object()
  {
    $row = parent::fetch_object();

    if($this->link->errno)
      throw new AP_MysqliException($this->link->error, 
                                    $this->link->sqlstate);

    return $row;
  }

  public function fetch_row()
  {
    $row = parent::fetch_row();

    if($this->link->errno)
      throw new AP_MysqliException($this->link->error, 
                                    $this->link->sqlstate);

    return $row;
  }

  public function fetch_fields()
  {
    $fields = parent::fetch_fields();

    if($this->link->errno)
      throw new AP_MysqliException($this->link->error, 
                                    $this->link->sqlstate);

    return $fields;
  }

  public function fetch_field()
  {
    $field = parent::fetch_field();

    if($this->link->errno)
      throw new AP_MysqliException($this->link->error, 
                                    $this->link->sqlstate);

    return $field;
  }

  public function fetch_field_direct($index)
  {
    $field = parent::fetch_field_direct($index);

    if($this->link->errno)
      throw new AP_MysqliException($this->link->error, 
                                    $this->link->sqlstate);

    return $field;
  }
}

class AP_MysqliException extends Exception
{  
  public function __construct($message, $sqlstate)
  {
    parent::__construct($message, $sqlstate);
  }
}
?>