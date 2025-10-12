<?php

class Event {
    private $eventId;
    private $name;
    private $date;

    public function __construct($eventId, $name, $date) {
        $this->eventId = $eventId;
        $this->name = $name;
        $this->date = $date;
    }

    public function getEventId() {
        return $this->eventId;
    }

    public function getName() {
        return $this->name;
    }

    public function getDate() {
        return $this->date;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function save() {
        // Code to save the event to the database
    }

    public function delete() {
        // Code to delete the event from the database
    }

    public static function find($eventId) {
        // Code to find an event by its ID
    }

    public static function all() {
        // Code to retrieve all events
    }
}