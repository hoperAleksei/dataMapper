<?php

require_once "Data.php";
require_once "DataMapper.php";

interface DataRepository
{
    public function save(Data $data);
    public function delete($id);
    public function find(Data $data);
    public function findAll();
}

class DbDateRepository
{
    private DataMapper $mapper;

    public function __construct(DataMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function save(Data $data)
    {
        $this->mapper->save($data);
    }

    public function delete($id)
    {
        $this->mapper->delete($id);
    }

    public function find(Data $data)
    {
        return $this->mapper->find($data);
    }

    public function findAll()
    {
        return $this->mapper->find(new Data());
    }

}