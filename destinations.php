<?php
/*
Plugin Name: Destinations
Plugin URI:  https://github.com/mkotov13/destinations
Description: Results page generator
Version:     0.1
Author:      Maksim Kotov
Author URI:  webgrove.co
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Tote Destinations is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Tote Destinations is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Tote Destinations. If not, see {License URI}.
*/
function safe_print() {
   print " -------- I think I'm getting a clue!";
}

add_action('admin_notices', 'safe_print');
/* End of File */