<?php
class CustomSessionHandler implements SessionHandlerInterface
{
    public $connection;
    public function __construct()
    {
    }

    function open($path, $name): bool
    {
        $servername = "localhost";
        $username = "test_session";
        $password = "etu001844";
        $database = "sessions";

        $connection = new mysqli($servername, $username, $password, $database);

        if ($connection->connect_error) {
            return false;
        } else {
            $this->connection = $connection;
            return true;
        }
    }

    public function close(): bool
    {
        if (isset($this->connection)) {
            $this->connection->close();
        }
        return true;
    }

    public function read($sessionId): string | bool
    {
        $query = "SELECT sessionData FROM sessions where sessionID='%s' and expired=false";
        $query = sprintf($query);
        $result = $this->connection->query($query);
        $data = $result->fetch_object();
        if (is_object($data)) {
            return $data->sessiondata;
        } else {
            return false;
        }
    }
    function exists($sessionId): bool
    {
        $query = "select sessionId from sessions where sessionId='%s'";
        $query = sprintf($query, $sessionId);
        $result = $this->connection->execute_query($query);
        $data = $result->fetch_assoc();
        if (is_array($data)) {
            if (count($data) > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function create($sessionId, $data) : bool{
        $query = "INSERT INTO sessions (sessionId, sessionData, added) VALUES ('%s','%s', now())";
        $query = sprintf($query, $sessionId, $data);
        $res = $this->connection->query($query);
        if(is_bool($res)){
            return $res;
        }else{
            return false;
        }
    }

    function update($sessionId, $data): bool{
        $query = "UPDATE sessions set sessionData='%s' where sessionId = '%s'";
        $query = sprintf($query, $data, $sessionId);
        $res = $this->connection->query($query);
        if(is_bool($res)){
            return $res;
        }else{
            return false;
        }
    }
    function expire($sessionId): bool{
        $query = "UPDATE sessions set expired=true where sessionId = '%s'";
        $query = sprintf($query, $sessionId);
        $res = $this->connection->query($query);
        if(is_bool($res)){
            return $res;
        }else{
            return false;
        }
    }


    public function write($sessionId, $data): bool
    {
        if($this->exists($sessionId)) {
            return $this->update($sessionId, $data);
        }else{
            return $this->create($sessionId, $data);
        }
    }

    public function destroy($sessionId) : bool
    {
        return $this->expire($sessionId);
    }

    public function gc($maxLifetime) : bool
    {
        $query = "UPDATE sessions set expired=true where (to_seconds(now()) - to_seconds(added)) > %d";
        $query = sprintf($query, $maxLifetime);
        $res = $this->connection->query($query);
        if(is_bool($res)){
            return $res;
        }else{
            return false;
        }
    }
}

$customSessionHandler = new CustomSessionHandler();
