<?php

namespace RBAC\Models;

class Formation extends DB {
    public $id;
    public $nom;
    public $code;
    public $niveau;
    public $duree;
    public $courses;
    public $courseIds;
}
