<?php

require_once("config/globals.php");
require_once("models/Redirect.php");

session_unset();
session_destroy();

Redirect::local($base, "login.php");

