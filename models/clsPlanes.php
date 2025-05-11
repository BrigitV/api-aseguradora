<?php

class Planes
{
    private $planes_id;
    private $placa;
    private $plan_descripcion;
    private $plan_valor;

    public function __construct($placa, $plan_descripcion, $plan_valor)
    {
        $this->placa = $placa;
        $this->plan_descripcion = $plan_descripcion;
        $this->plan_valor = $plan_valor;
    }

    //geters

    public function getId()
    {
        return $this->planes_id;
    }

    public function getPlaca()
    {
        return $this->placa;
    }


    public function getPlanDescripcion()
    {
        return $this->plan_descripcion;
    }
    public function getPlanValor()
    {
        return $this->plan_valor;
    }

    //setters 

    public function setId($planes_id)
    {
        $this->planes_id = $planes_id;
    }

    public function setplaca($placa)
    {
        $this->placa = $placa;
    }

    public function setPlanDescripcion()
    {
        return $this->plan_descripcion;
    }

    public function setPlanValor($plan_valor)
    {
        $this->plan_valor = $plan_valor;

        return $this;
    }
}
