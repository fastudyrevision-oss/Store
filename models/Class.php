<?php

class ArtClass {
    private $classId;
    private $name;

    public function __construct($classId, $name) {
        $this->classId = $classId;
        $this->name = $name;
    }

    public function getClassId() {
        return $this->classId;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    // Additional methods can be added as needed
}