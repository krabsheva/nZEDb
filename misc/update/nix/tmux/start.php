<?php
/**
 * This file makes the tmux monitoring script activate the processing cycle.
 * It does so by changing the running setting in the database, so that the monitor script knows to
 * (re)start applicable scripts.
 *
 * It will start the tmux server and monitoring scripts if needed.
 */
require_once realpath(dirname(dirname(dirname(dirname(__DIR__)))) . DIRECTORY_SEPARATOR . 'bootstrap.php');

use nzedb\Tmux;
use nzedb\db\DB;

$pdo = new DB();

// Ensure compatible tmux version is installed $tmux_version == "tmux 2.1\n" || $tmux_version == "tmux 2.2\n"
if (`which tmux`) {
	$tmux_version = trim(str_replace('tmux ', '', shell_exec('tmux -V')));
	if (version_compare($tmux_version, '2.0', '>') && version_compare($tmux_version, '2.3', '<')) {
		exit($pdo->log->error("tmux versions 2.1 and 2.2 are not compatible with nZEDb. Aborting\n"));
	}
} else {
        exit($pdo->log->error("tmux binary not found. Aborting\n"));
}

$tmux = new Tmux();
$tmux_settings = $tmux->get();
$tmux_session = (isset($tmux_settings->tmux_session)) ? $tmux_settings->tmux_session : 0;
$path = __DIR__;

// Set running value to on.
$tmux->startRunning();

// Create a placeholder session so tmux commands do not throw server not found errors.
exec('tmux new-session -ds placeholder 2>/dev/null');

//check if session exists
$session = shell_exec("tmux list-session | grep $tmux_session");
// Kill the placeholder
exec('tmux kill-session -t placeholder');
if (count($session) == 0) {
	echo $pdo->log->info("Starting the tmux server and monitor script.\n");
	passthru("php $path/run.php");
}
