<?php


class MyPDO extends PDO
{

   
    public function __construct($dsn, $username = null, $passwd = null, $options = null, $product = false)
    {
        
        parent::__construct($dsn, $username, $passwd, $options);

        
        if ($product === false) {
          
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }
}
