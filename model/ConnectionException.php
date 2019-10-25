<?php

namespace model;


class ConnectionException extends \Exception {
    public $messageToUser = "Sorry something went wrong with connection";
}