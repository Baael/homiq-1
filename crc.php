<?php
$crc="0";
define( 'CRC8INIT',0x00);
define ('CRC8POLY',0x18);

function init_crc8()
{
	global $crc;
	$crc = 0;
}

function return_crc8()
{ 
	global $crc;
	
	return $crc; 
}
function calc_crc8($data)
{
	global $crc;

        $bit_counter = 8;
	do 
	{
		$feedback_bit = ($crc ^ $data) & 0x01;
		if ( $feedback_bit == 0x01 ) 
		{

			$crc = $crc ^ CRC8POLY;

		}
		$crc = ($crc >> 1) & 0x7F;
		if ($feedback_bit == 0x01 ) 
		{
			$crc = $crc | 0x80;
		}
		$data = $data >> 1;
		$bit_counter--;

	} 
	while ($bit_counter > 0);


}

function hcrc($string)
{

	init_crc8();
	for ($i=0;$i<strlen($string);$i++)
	{
		calc_crc8(ord($string[$i]));
	}

	return return_crc8();
}


