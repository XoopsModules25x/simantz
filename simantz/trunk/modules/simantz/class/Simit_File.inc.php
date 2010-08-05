<?php
//include ("upload_class.php"); //classes is the map where the class file is stored (one above the root)
//error_reporting(E_ALL);
$max_size = 1024*100; // the max. size for uploading

class muli_files extends file_upload {

        //multiple file
	var $number_of_files = 0;
	var $names_array;
	var $tmp_names_array;
	var $error_array;
	var $wrong_extensions = 0;
	var $bad_filenames = 0;
        //upload photo
	var $x_size;
	var $y_size;
	var $x_max_size = 300;
	var $y_max_size = 200;
	var $x_max_thumb_size = 110;
	var $y_max_thumb_size = 88;
	var $thumb_folder;
	var $foto_folder;
	var $larger_dim;
	var $larger_curr_value;
	var $larger_dim_value;
	var $larger_dim_thumb_value;
	var $use_image_magick = true;

	function extra_text($msg_num) {
		switch ($this->language) {
			case "de":
			// add you translations here
			break;
			default:
			$extra_msg[1] = "Error for: <b>".$this->the_file."</b>";
			$extra_msg[2] = "You have tried to upload ".$this->wrong_extensions." files with a bad extension, the following extensions are allowed: <b>".$this->ext_string."</b>";
			$extra_msg[3] = "Select at least on file.";
			$extra_msg[4] = "Select the file(s) for upload.";
			$extra_msg[5] = "You have tried to upload <b>".$this->bad_filenames." files</b> with invalid characters inside the filename.";
		}
		return $extra_msg[$msg_num];
	}
	// this method checkes the number of files for upload
	// this example works with one or more files
	function count_files() {
		foreach ($this->names_array as $test) {
			if ($test != "") {
				$this->number_of_files++;
			}
		}
		if ($this->number_of_files > 0) {
			return true;
		} else {
			return false;
		}
	}
	function upload_multi_files () {
		$this->message = "";
		if ($this->count_files()) {
			foreach ($this->names_array as $key => $value) {
				if ($value != "") {
					$this->the_file = $value;
					$new_name = $this->set_file_name();
					if ($this->check_file_name($new_name)) {
						if ($this->validateExtension()) {
							$this->file_copy = $new_name;
							$this->the_temp_file = $this->tmp_names_array[$key];
							if (is_uploaded_file($this->the_temp_file)) {
								if ($this->move_upload($this->the_temp_file, $this->file_copy)) {
									$this->message[] = $this->error_text($this->error_array[$key]);
									if ($this->rename_file) $this->message[] = $this->error_text(16);
									sleep(1); // wait a seconds to get an new timestamp (if rename is set)
								}
							} else {
								$this->message[] = $this->extra_text(1);
								$this->message[] = $this->error_text($this->error_array[$key]);
							}
						} else {
							$this->wrong_extensions++;
						}
					} else {
						$this->bad_filenames++;
					}
				}
			}
			if ($this->bad_filenames > 0) $this->message[] = $this->extra_text(5);
			if ($this->wrong_extensions > 0) {
				$this->show_extensions();
				$this->message[] = $this->extra_text(2);
			}
		} else {
			$this->message[] = $this->extra_text(3);
		}
	}


        /* start upload photo function */

        function process_image($landscape_only = false, $create_thumb = false, $delete_tmp_file = false, $compression = 85) {
		$filename = $this->upload_dir.$this->file_copy;
		$this->check_dir($this->thumb_folder); // run these checks to create not existing directories
		$this->check_dir($this->foto_folder); // the upload dir is created during the file upload (if not already exists)
		$thumb = $this->thumb_folder.$this->file_copy;
		$foto = $this->foto_folder.$this->file_copy;
		if ($landscape_only) {
			$this->get_img_size($filename);
			if ($this->y_size > $this->x_size) {
				$this->img_rotate($filename, $compression);
			}
		}
		$this->check_dimensions($filename); // check which size is longer then the max value
		if ($this->larger_curr_value > $this->larger_dim_value) {
			$this->thumbs($filename, $foto, $this->larger_dim_value, $compression);
		} else {
			copy($filename, $foto);
		}
		if ($create_thumb) {
			if ($this->larger_curr_value > $this->larger_dim_thumb_value) {
				$this->thumbs($filename, $thumb, $this->larger_dim_thumb_value, $compression); // finally resize the image
			} else {
				copy($filename, $thumb);
			}
		}
		if ($delete_tmp_file) $this->del_temp_file($filename); // note if you delete the tmp file the check if a file exists will not work
	}
	function get_img_size($file) {
		$img_size = getimagesize($file);
		$this->x_size = $img_size[0];
		$this->y_size = $img_size[1];
	}
	function check_dimensions($filename) {
		$this->get_img_size($filename);
		$x_check = $this->x_size - $this->x_max_size;
		$y_check = $this->y_size - $this->y_max_size;
		if ($x_check < $y_check) {
			$this->larger_dim = "y";
			$this->larger_curr_value = $this->y_size;
			$this->larger_dim_value = $this->y_max_size;
			$this->larger_dim_thumb_value = $this->y_max_thumb_size;
		} else {
			$this->larger_dim = "x";
			$this->larger_curr_value = $this->x_size;
			$this->larger_dim_value = $this->x_max_size;
			$this->larger_dim_thumb_value = $this->x_max_thumb_size;
		}
	}
	function img_rotate($wr_file, $comp) {
		$new_x = $this->y_size;
		$new_y = $this->x_size;
		if ($this->use_image_magick) {
			exec(sprintf("mogrify -rotate 90 -quality %d %s", $comp, $wr_file));
		} else {
			$src_img = imagecreatefromjpeg($wr_file);
			$rot_img = imagerotate($src_img, 90, 0);
			$new_img = imagecreatetruecolor($new_x, $new_y);
			imageantialias($new_img, TRUE);
			imagecopyresampled($new_img, $rot_img, 0, 0, 0, 0, $new_x, $new_y, $new_x, $new_y);
			imagejpeg($new_img, $this->upload_dir.$this->file_copy, $comp);
		}
	}
	function thumbs($file_name_src, $file_name_dest, $target_size, $quality = 80) {
		//print_r(func_get_args());
		$size = getimagesize($file_name_src);
		if ($this->larger_dim == "x") {
			$w = number_format($target_size, 0, ',', '');
			$h = number_format(($size[1]/$size[0])*$target_size,0,',','');
		} else {
			$h = number_format($target_size, 0, ',', '');
			$w = number_format(($size[0]/$size[1])*$target_size,0,',','');
		}
		if ($this->use_image_magick) {
			exec(sprintf("convert %s -resize %dx%d -quality %d %s", $file_name_src, $w, $h, $quality, $file_name_dest));
		} else {
			$dest = imagecreatetruecolor($w, $h);
			imageantialias($dest, TRUE);
			$src = imagecreatefromjpeg($file_name_src);
			imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);
			imagejpeg($dest, $file_name_dest, $quality);
		}
	}
        
        /* end upload photo function */
}

?>