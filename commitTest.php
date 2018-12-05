<?php
include 'includes/user.inc.php';
include 'includes/commitments.inc.php';

$resources = new Commitments();

$resources->printCommits();
