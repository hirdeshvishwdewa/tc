<?php

defined("__ACCESS__") or die ("Direct Access Not Allowed !");

class ValidationRegEx {
	const regEx = array(
						"int" 				=> null
						
						,"email" 			=> null
						
						,"name" 		=> "/^[A-Za-z]{3,20}$/"
						
						,"username" 		=> "/^[A-Za-z][A-Za-z0-9]{5,31}$/"
						/*Must start with letter, 6-32 characters, Letters and numbers only*/

						,"password" 		=> "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/"
						
						,"tc_name" 			=> "/^[A-Za-z0-9 ]{5,120}$/"
						/*Min char 5, max char 255, only alphanumeric and spaces*/
						
						,"tc_short_desc"	=> "/^[A-Za-z0-9 ]{100,255}$/"
						/*Min char 100, max char 255, only alphanumeric and spaces*/
						
						,"order" 			=> "/^[A-Za-z]{3,4}$/"
						
						,"area_name" 		=> "/^[A-Za-z0-9 ]{3,255}$/"
						
						,"review_desc" 		=> "/^[A-Za-z0-9 ]{50,625}$/"
						/*Min char 50, max char 625, only alphanumeric and spaces*/
						
						,"review_title" 	=> "/^[A-Za-z0-9 ]{5,120}$/"
						/*Min char 5, max char 120, only alphanumeric and spaces*/

						,"searchTerm"		=> "/^[A-Za-z0-9 ]{3,25}$/"

						,"mobile_number"	=> "/^[0-9]{10}$/"

						,"boolean"			=> null
					);
}