<?php

namespace App;

class Config
{
    private $file;
    private $array;
    public function __construct($file)
    {
        $dir = __DIR__ . '/../config/' . $file . '.php';
        if (!file_exists($dir)) {
            $this->file = fopen($dir, 'a');
            $this->array = [];
        } else {
            $this->file = fopen($dir, 'w');
            $this->array = config($file);
        }
    }

    public function get($key = 'nulll')
    {
        if ($key = 'nulll')
            return $this->array[$key];
        if (array_key_exists($key, $this->array)) {
            return $this->array[$key];
        } else {
            return null;
        }
    }

    public function getMany(){
        return $this->array;
    }

    public function setMany($array)
    {
        foreach (array_keys($array) as $key) {
            $this->array[$key] = $array[$key];
        }
        $this->save();
    }

    public function set($key, $value)
    {
        $this->array[$key] = $value;
    }

    private function save()
    {
        $conten = "<?php \n return [\n";
        $conten .= $this->toSave($this->array);
        $conten .= "];";
        fwrite($this->file, $conten);
    }

    private function toSave($array)
    {
        $conten = "";
        foreach (array_keys($array) as $key) {
            if (is_array($array[$key])) {
                $conten .= "'$key' => [ \n";
                foreach (array_keys($array[$key]) as $key2) {
                    $conten .= "'" . $array[$key][$key2] . "',\n";
                }
                $conten .= "], \n";
            } else {
                $conten .= "'$key' => '" . $this->array[$key] . "', \n";
            }
        }
        return $conten;
    }

    public function __destruct()
    {
        fclose($this->file);
    }
}
