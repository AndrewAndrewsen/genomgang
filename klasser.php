<?php

class Fruit {
    public $name;
    public $color;
    public $type;

    function __construct($name, $color, $type) {
        $this->name = $name;
        $this->color = $color;
        $this->type = $type;
    }

    function get_name() {
        return $this->name;
    }

    function get_color() {
        return $this->color;
    }

    function get_type() {
        return $this->type;
    }
}

$apple = new Fruit("Fint äpple", "Röd", "Äpple");
$banana = new Fruit("Fin banan", "Gul", "Banan");

echo $apple->get_name() . " " . $apple->get_color() . " " . $apple->get_type() . "<br />";
echo $banana->get_name() . " " . $banana->get_color() . " " . $banana->get_type() . "<br />";


