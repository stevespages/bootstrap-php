<?php

// MODELS

$today_form_array = array ( 	"quote_of_the_day" => array (
																"name" => "quote_of_the_day",
																"required" => "",
																"value" => "",
																"error_mssg" => "",
																"form_label" => "Add a quote<strong>!</strong>",
																"type" => "text",
																"validate" => "not_blank"
																),
										"author" => array	(
																"name" => "author",
																"required" => "",
																"value" => "",
																"error_mssg" => "",
																"form_label" => "Author",
																"type" => "text",
																"validate" => "string"
																),
										"image_1" => array 	(
																"name" => "image_1",
																"required" => "",
																"value" => "",
																"error_mssg" => "",
																"form_label" => "Image 1",
																"type" => "file",
																"validate" => ""
																),
										"image_2"	=>	array		(
																"name" => "image_2",
																"required" => "",
																"value" => "",
																"error_mssg" => "",
																"form_label" => "Image 2",
																"type" => "file",
																"validate" => ""
															)
);
