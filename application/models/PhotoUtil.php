<?php

class Model_PhotoUtil
{
	const DEFAULT_PHOTO_NAME = "picturetofollow.jpg";
	
	function __construct()
	{		
	}
	
	//copy photo "picture to follow" to the destination folder
	public function copyDefaultPhoto($destination)
	{
		$sourceFile = "images/".self::DEFAULT_PHOTO_NAME;
		copy($sourceFile, $destination);
	}
	
	//scale photo and copy it do destination foler
	public function resampimagejpg( $forcedwidth, $forcedheight, $sourcefile, $destfile )
	{						
		//Open a new image
		$image = new Imagick($sourcefile); 
	 
		$is = getimagesize( $sourcefile );
		
		if ($is[0] >= $is[1])
		{		
			$image->resizeImage($forcedwidth, $forcedheight, imagick::FILTER_LANCZOS, 1);			
		}
		else
		{		
			$image->resizeImage($forcedheight, $forcedwidth, imagick::FILTER_LANCZOS, 1);
		}		
	 
		//Store the scaled version
		$image->writeImage($destfile);		    
	}
}