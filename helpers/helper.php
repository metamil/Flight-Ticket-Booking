<?php
function subview($file){
	$file = __DIR__.'/../sub-views/'.$file;
	include $file;
}