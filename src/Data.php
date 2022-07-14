<?php
// Active record class for the 'data' table.
class Data
{
    public $id;
    public $message;

    public function __construct($message = null, $id = null)
    {
        $this->message = $message;
        $this->id = $id;
    }

}