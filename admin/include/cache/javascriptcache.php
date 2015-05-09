<?php

@define('cacheJStime',3600);

if (function_exists('cacheJS')) return;

function cacheJS($filename, $content='',$pukecomment=false,$kameleon_too=false)
{
	static $comment;

	if ($pukecomment)
	{
		echo $comment;
		return false;
	}

	if (!is_dir(dirname($filename))) @mkdir(dirname($filename),0755);

	global $KAMELEON_MODE,$_SERVER;
	if ($KAMELEON_MODE && !$kameleon_too) return false;

	clearstatcache();
	$t=@filemtime($filename);
	$sft=@filemtime($_SERVER["SCRIPT_FILENAME"]);
	
	$script_file=", SCRIPT FILE: ".date("d-m-y, H:i:s",$sft);

	if (!$t) 
	{
		$comment.="<!-- CACHE FILE: NONE ($filename) $script_file-->\n";
		$fp=@fopen($filename,"w");
		@fclose($fp);
		return false;
	}
	else 
	{
		$fs=filesize($filename);
		$comment.="<!-- CACHE FILE: ".date("H:i:s",$t)." ($filename, size=$fs) $script_file -->\n";
	}

	if (@filemtime($_SERVER["SCRIPT_FILENAME"])>$t && !strlen($content)) return false;

	if (!filesize($filename) && !strlen($content)) return false;

	$wr=0;
	if (strlen($content))
	{
		$fp=@fopen($filename.'---','w');
		if ($fp)
		{
			$wr=1;
			fwrite($fp,$content);
			@fclose($fp);
			@unlink($filename);
			@rename ($filename.'---',$filename);	
		}
		else
			return false;
	}

	if ($wr) return true;

	if ((time()-$t) < cacheJStime)
		return true;
	else
		return false;

}

function cacheContent($filename)
{
	$t=@filemtime($filename);
	$fd = @fopen ($filename, "r");
	if ($fd)
	{
		$content = @fread ($fd, filesize ($filename));
		@fclose ($fd);
	}
	return $content."<!-- File from cache, ".date("H:i:s",$t)." -->";
}

php?>