<?php
/*
  Plugin Name: Vaktija Widget
  Description: Jednostavni vaktija widget za Sarajevo sa označenim trenutnim namazom
  Version: 1.0
  Author: Emir M
  Author URL: http://devcompetence.blogspot.com/
  License: GPLv2+
*/ 

/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  email: devcompetence@gmail.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class vaktija_widget extends WP_Widget {
    /** constructor -- name this the same as the class above */

    function vaktija_widget() {
        parent::WP_Widget(false, $name = 'Dnevna vaktija');	
    }
 
    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {	
        extract( $args );
        global $wpdb;
		$table_name = $wpdb->prefix . 'vaktija';
		
		$current_time = date('H:i');
		
        $times 	= $wpdb->get_row("SELECT * FROM $table_name where full_date = CURDATE()");
        ?>
              <?php echo $before_widget; ?>
                  <?php echo '<strong>Dnevna vaktija za Sarajevo za ' . date("d.m.Y.") .'<strong>'; ?>
						<br/><br/>
						<table id="vaktija">
							<tr>
								<td <?php if($current_time > $times->fajr && $currene) echo "style = 'font-weight: bold;'" ?>>Sabah</td>
								<td <?php if($current_time > $times->fajr && $currene) echo "style = 'font-weight: bold;'" ?>><?php echo date('H:i', strtotime($times->fajr)); ?></td>
							<tr>
							<tr>
								<td <?php if($current_time > $times->sunrise && $current_time < $times->zuhr) echo "style = 'font-weight: bold;'" ?>>Izlazak sunca</td>
								<td <?php if($current_time > $times->sunrise && $current_time < $times->zuhr) echo "style = 'font-weight: bold;'" ?>><?php echo date('H:i', strtotime($times->sunrise)); ?></td>
							<tr>
							<tr>
								<td <?php if($current_time > $times->zuhr && $current_time < $times->asr) echo "style = 'font-weight: bold;'" ?>>Podne</td>
								<td <?php if($current_time > $times->zuhr && $current_time < $times->asr) echo "style = 'font-weight: bold;'" ?>><?php echo date('H:i', strtotime($times->zuhr)) ?></td>
							<tr>
							<tr>
								<td <?php if($current_time > $times->asr && $current_time < $times->maghrib) echo "style = 'font-weight: bold;'" ?>>Ikindija</td>
								<td <?php if($current_time > $times->asr && $current_time < $times->maghrib) echo "style = 'font-weight: bold;'" ?>><?php echo date('H:i', strtotime($times->asr)) ?></td>
							<tr>
							<tr>
								<td <?php if($current_time > $times->maghrib & $current_time < $times->isha) echo "style = 'font-weight: bold;'" ?>>Akšam</td>
								<td <?php if($current_time > $times->maghrib & $current_time < $times->isha) echo "style = 'font-weight: bold;'" ?>><?php echo date('H:i', strtotime($times->maghrib)) ?></td>
							<tr>
							<tr>
								<td <?php if($current_time > $times->isha) echo "style = 'font-weight: bold;'" ?>>Jacija</td>
								<td <?php if($current_time > $times->isha) echo "style = 'font-weight: bold;'" ?>><?php echo date('H:i', strtotime($times->isha)) ?></td>
							<tr>
						</table>
				<small>Widget developed by <a href="http://devcompetence.blogspot.com/">DevCompetence</a></small>
              <?php echo $after_widget; ?>
        <?php
    }
 
    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		return $instance;
    }
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {
    }
	
	/**/
	public static function vaktija_create_plugin_database_table() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'vaktija';
		$sql = "CREATE TABLE $table_name (
			id mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
			full_date date NOT NULL,
			fajr nvarchar(10) NOT NULL,
			sunrise nvarchar(10) NOT NULL,
			zuhr nvarchar(10) NOT NULL,
			asr nvarchar(10) NOT NULL,
			maghrib nvarchar(10) NOT NULL,
			isha nvarchar(10) NOT NULL,
			PRIMARY KEY  (id)
			)";
	 
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
	
	public static function vaktija_plugin_install_data() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'vaktija';
		$wpdb->query("INSERT INTO $table_name
		(full_date,fajr,sunrise,zuhr,asr,maghrib,isha)
		values
		('2015-01-1','5:31','7:15','11:51','14:01','16:25','17:57'),
		('2015-01-2','5:31','7:15','11:51','14:02','16:26','17:58'),
		('2015-01-3','5:31','7:16','11:52','14:03','16:27','17:59'),
		('2015-01-4','5:32','7:16','11:52','14:04','16:28','18:00'),
		('2015-01-5','5:32','7:16','11:53','14:05','16:29','18:01'),
		('2015-01-6','5:32','7:15','11:53','14:06','16:30','18:02'),
		('2015-01-7','5:32','7:15','11:54','14:06','16:31','18:03'),
		('2015-01-8','5:32','7:15','11:54','14:07','16:32','18:04'),
		('2015-01-9','5:32','7:15','11:55','14:08','16:33','18:05'),
		('2015-01-10','5:32','7:14','11:55','14:09','16:34','18:06'),
		('2015-01-11','5:31','7:14','11:55','14:10','16:35','18:06'),
		('2015-01-12','5:31','7:14','11:56','14:11','16:36','18:07'),
		('2015-01-13','5:31','7:13','11:56','14:12','16:37','18:08'),
		('2015-01-14','5:31','7:13','11:56','14:13','16:39','18:09'),
		('2015-01-15','5:31','7:12','11:57','14:14','16:40','18:10'),
		('2015-01-16','5:30','7:12','11:57','14:15','16:41','18:11'),
		('2015-01-17','5:29','7:11','11:57','14:16','16:43','18:12'),
		('2015-01-18','5:29','7:11','11:58','14:18','16:44','18:13'),
		('2015-01-19','5:29','7:10','11:58','14:19','16:45','18:14'),
		('2015-01-20','5:29','7:09','11:58','14:20','16:46','18:15'),
		('2015-01-21','5:28','7:08','11:59','14:21','16:47','18:16'),
		('2015-01-22','5:28','7:08','11:59','14:22','16:48','18:17'),
		('2015-01-23','5:27','7:07','11:59','14:23','16:49','18:18'),
		('2015-01-24','5:27','7:06','11:59','14:24','16:51','18:20'),
		('2015-01-25','5:26','7:05','12:00','14:25','16:52','18:21'),
		('2015-01-26','5:25','7:04','12:00','14:26','16:54','18:22'),
		('2015-01-27','5:24','7:03','12:00','14:28','16:55','18:23'),
		('2015-01-28','5:24','7:03','12:00','14:29','16:57','18:25'),
		('2015-01-29','5:23','7:02','12:00','14:30','16:58','18:26'),
		('2015-01-30','5:22','7:01','12:01','14:31','16:59','18:27'),
		('2015-01-31','5:21','7:00','12:01','14:32','17:01','18:28'),
		('2015-02-1','5:20','6:59','12:01','14:33','17:02','18:29'),
		('2015-02-2','5:19','6:58','12:01','14:34','17:04','18:30'),
		('2015-02-3','5:18','6:56','12:01','14:35','17:05','18:31'),
		('2015-02-4','5:17','6:55','12:01','14:36','17:07','18:32'),
		('2015-02-5','5:16','6:54','12:01','14:38','17:08','18:33'),
		('2015-02-6','5:15','6:53','12:01','14:39','17:10','18:35'),
		('2015-02-7','5:14','6:51','12:02','14:41','17:11','18:36'),
		('2015-02-8','5:13','6:50','12:02','14:42','17:12','18:37'),
		('2015-02-9','5:12','6:49','12:02','14:43','17:14','18:39'),
		('2015-02-10','5:11','6:47','12:02','14:44','17:15','18:40'),
		('2015-02-11','5:10','6:46','12:02','14:45','17:16','18:41'),
		('2015-02-12','5:08','6:44','12:02','14:45','17:17','18:42'),
		('2015-02-13','5:07','6:43','12:02','14:46','17:18','18:43'),
		('2015-02-14','5:06','6:42','12:02','14:47','17:20','18:45'),
		('2015-02-15','5:05','6:40','12:02','14:48','17:21','18:46'),
		('2015-02-16','5:04','6:39','12:02','14:49','17:23','18:48'),
		('2015-02-17','5:02','6:37','12:01','14:50','17:24','18:49'),
		('2015-02-18','5:00','6:36','12:01','14:51','17:25','18:50'),
		('2015-02-19','4:59','6:35','12:01','14:52','17:27','18:51'),
		('2015-02-20','4:57','6:33','12:01','14:53','17:28','18:52'),
		('2015-02-21','4:56','6:32','12:01','14:54','17:30','18:53'),
		('2015-02-22','4:54','6:30','12:01','14:55','17:31','18:54'),
		('2015-02-23','4:53','6:28','12:01','14:56','17:32','18:55'),
		('2015-02-24','4:52','6:27','12:01','14:57','17:34','18:57'),
		('2015-02-25','4:50','6:25','12:01','14:58','17:35','18:58'),
		('2015-02-26','4:48','6:23','12:00','14:59','17:36','18:59'),
		('2015-02-27','4:47','6:22','12:00','15:00','17:37','19:01'),
		('2015-02-28','4:45','6:20','12:00','15:01','17:38','19:02'),
		('2015-03-1','4:42','6:18','12:00','15:03','17:40','19:05'),
		('2015-03-2','4:40','6:16','12:00','15:04','17:41','19:06'),
		('2015-03-3','4:38','6:15','11:59','15:04','17:42','19:07'),
		('2015-03-4','4:37','6:13','11:59','15:05','17:44','19:09'),
		('2015-03-5','4:35','6:11','11:59','15:07','17:45','19:10'),
		('2015-03-6','4:34','6:09','11:59','15:08','17:46','19:11'),
		('2015-03-7','4:32','6:08','11:59','15:09','17:48','19:13'),
		('2015-03-8','4:30','6:07','11:58','15:10','17:49','19:14'),
		('2015-03-9','4:28','6:05','11:58','15:10','17:50','19:15'),
		('2015-03-10','4:27','6:03','11:58','15:11','17:52','19:17'),
		('2015-03-11','4:25','6:01','11:58','15:12','17:53','19:18'),
		('2015-03-12','4:23','5:59','11:57','15:12','17:54','19:19'),
		('2015-03-13','4:21','5:58','11:57','15:12','17:56','19:21'),
		('2015-03-14','4:19','5:56','11:57','15:13','17:57','19:22'),
		('2015-03-15','4:16','5:54','11:56','15:14','17:58','19:23'),
		('2015-03-16','4:15','5:52','11:56','15:15','17:59','19:24'),
		('2015-03-17','4:13','5:50','11:56','15:16','18:00','19:26'),
		('2015-03-18','4:11','5:48','11:56','15:17','18:01','19:27'),
		('2015-03-19','4:09','5:46','11:55','15:17','18:02','19:28'),
		('2015-03-20','4:07','5:44','11:55','15:18','18:04','19:30'),
		('2015-03-21','4:05','5:43','11:55','15:19','18:05','19:31'),
		('2015-03-22','4:03','5:41','11:54','15:20','18:06','19:32'),
		('2015-03-23','4:01','5:39','11:54','15:20','18:08','19:34'),
		('2015-03-24','4:00','5:37','11:54','15:21','18:09','19:35'),
		('2015-03-25','3:58','5:36','11:53','15:21','18:10','19:36'),
		('2015-03-26','3:56','5:34','11:53','15:22','18:11','19:38'),
		('2015-03-27','3:53','5:32','11:53','15:22','18:13','19:40'),
		('2015-03-28','3:51','5:31','11:53','15:23','18:14','19:41'),
		('2015-03-29','4:48','6:29','12:52','16:23','19:15','20:42'),
		('2015-03-30','4:47','6:27','12:52','16:24','19:16','20:43'),
		('2015-03-31','4:45','6:25','12:52','16:24','19:18','20:45'),
		('2015-04-1','4:43','6:23','12:51','16:25','19:19','20:47'),
		('2015-04-2','4:40','6:21','12:51','16:25','19:20','20:48'),
		('2015-04-3','4:38','6:19','12:51','16:25','19:21','20:49'),
		('2015-04-4','4:35','6:17','12:50','16:25','19:22','20:50'),
		('2015-04-5','4:33','6:15','12:50','16:26','19:23','20:52'),
		('2015-04-6','4:31','6:14','12:50','16:27','19:24','20:53'),
		('2015-04-7','4:29','6:12','12:50','16:28','19:25','20:55'),
		('2015-04-8','4:27','6:10','12:49','16:28','19:27','20:57'),
		('2015-04-9','4:25','6:08','12:49','16:29','19:28','20:58'),
		('2015-04-10','4:23','6:06','12:49','16:30','19:29','21:00'),
		('2015-04-11','4:21','6:05','12:48','16:30','19:31','21:02'),
		('2015-04-12','4:18','6:04','12:48','16:31','19:32','21:03'),
		('2015-04-13','4:16','6:02','12:48','16:31','19:33','21:05'),
		('2015-04-14','4:14','6:00','12:48','16:31','19:34','21:06'),
		('2015-04-15','4:12','5:58','12:47','16:31','19:36','21:08'),
		('2015-04-16','4:09','5:57','12:47','16:32','19:37','21:09'),
		('2015-04-17','4:07','5:55','12:47','16:32','19:38','21:11'),
		('2015-04-18','4:05','5:53','12:47','16:32','19:39','21:13'),
		('2015-04-19','4:03','5:52','12:46','16:33','19:40','21:15'),
		('2015-04-20','4:01','5:50','12:46','16:33','19:41','21:16'),
		('2015-04-21','3:59','5:48','12:46','16:34','19:42','21:18'),
		('2015-04-22','3:57','5:46','12:46','16:35','19:43','21:19'),
		('2015-04-23','3:55','5:45','12:46','16:35','19:45','21:21'),
		('2015-04-24','3:52','5:43','12:45','16:36','19:46','21:22'),
		('2015-04-25','3:50','5:42','12:45','16:36','19:47','21:24'),
		('2015-04-26','3:48','5:40','12:45','16:36','19:48','21:26'),
		('2015-04-27','3:46','5:39','12:45','16:37','19:50','21:28'),
		('2015-04-28','3:43','5:38','12:45','16:38','19:51','21:30'),
		('2015-04-29','3:41','5:36','12:45','16:38','19:52','21:32'),
		('2015-04-30','3:38','5:35','12:44','16:38','19:53','21:33'),
		('2015-05-1','3:36','5:33','12:44','16:38','19:55','21:35'),
		('2015-05-2','3:34','5:32','12:44','16:39','19:56','21:37'),
		('2015-05-3','3:32','5:30','12:44','16:39','19:57','21:39'),
		('2015-05-4','3:30','5:29','12:44','16:39','19:58','21:40'),
		('2015-05-5','3:28','5:27','12:44','16:39','20:00','21:42'),
		('2015-05-6','3:26','5:26','12:44','16:40','20:01','21:44'),
		('2015-05-7','3:24','5:25','12:44','16:40','20:02','21:46'),
		('2015-05-8','3:22','5:23','12:44','16:40','20:03','21:47'),
		('2015-05-9','3:20','5:22','12:44','16:41','20:04','21:49'),
		('2015-05-10','3:18','5:21','12:44','16:41','20:05','21:51'),
		('2015-05-11','3:16','5:19','12:44','16:42','20:06','21:53'),
		('2015-05-12','3:14','5:18','12:44','16:42','20:07','21:55'),
		('2015-05-13','3:12','5:17','12:44','16:43','20:08','21:57'),
		('2015-05-14','3:10','5:16','12:44','16:44','20:09','21:58'),
		('2015-05-15','3:08','5:15','12:44','16:44','20:11','22:00'),
		('2015-05-16','3:06','5:14','12:44','16:45','20:12','22:02'),
		('2015-05-17','3:04','5:13','12:44','16:45','20:13','22:04'),
		('2015-05-18','3:02','5:12','12:44','16:45','20:14','22:05'),
		('2015-05-19','3:01','5:11','12:44','16:46','20:15','22:07'),
		('2015-05-20','2:59','5:10','12:44','16:46','20:16','22:08'),
		('2015-05-21','2:57','5:09','12:44','16:46','20:17','22:10'),
		('2015-05-22','2:55','5:08','12:44','16:46','20:18','22:12'),
		('2015-05-23','2:53','5:07','12:44','16:46','20:19','22:14'),
		('2015-05-24','2:51','5:07','12:44','16:46','20:20','22:15'),
		('2015-05-25','2:50','5:06','12:44','16:47','20:21','22:17'),
		('2015-05-26','2:48','5:05','12:44','16:47','20:22','22:18'),
		('2015-05-27','2:46','5:04','12:44','16:47','20:23','22:20'),
		('2015-05-28','2:44','5:03','12:44','16:47','20:24','22:21'),
		('2015-05-29','2:43','5:03','12:44','16:48','20:25','22:23'),
		('2015-05-30','2:42','5:02','12:45','16:49','20:26','22:25'),
		('2015-05-31','2:41','5:01','12:45','16:49','20:27','22:26'),
		('2015-06-1','2:39','5:01','12:45','16:49','20:27','22:27'),
		('2015-06-2','2:38','5:00','12:45','16:49','20:28','22:29'),
		('2015-06-3','2:36','5:00','12:45','16:49','20:28','22:30'),
		('2015-06-4','2:35','4:59','12:45','16:49','20:29','22:32'),
		('2015-06-5','2:34','4:59','12:46','16:50','20:30','22:34'),
		('2015-06-6','2:33','4:58','12:46','16:51','20:31','22:35'),
		('2015-06-7','2:32','4:58','12:46','16:51','20:31','22:36'),
		('2015-06-8','2:31','4:57','12:46','16:51','20:32','22:37'),
		('2015-06-9','2:30','4:57','12:46','16:51','20:33','22:38'),
		('2015-06-10','2:30','4:57','12:47','16:52','20:33','22:38'),
		('2015-06-11','2:29','4:57','12:47','16:52','20:34','22:39'),
		('2015-06-12','2:28','4:57','12:47','16:53','20:34','22:40'),
		('2015-06-13','2:27','4:56','12:47','16:53','20:35','22:41'),
		('2015-06-14','2:27','4:56','12:47','16:54','20:36','22:42'),
		('2015-06-15','2:27','4:56','12:48','16:54','20:36','22:42'),
		('2015-06-16','2:27','4:56','12:48','16:54','20:36','22:42'),
		('2015-06-17','2:27','4:56','12:48','16:54','20:37','22:43'),
		('2015-06-18','2:27','4:56','12:48','16:54','20:37','22:43'),
		('2015-06-19','2:26','4:56','12:48','16:54','20:38','22:44'),
		('2015-06-20','2:26','4:57','12:49','16:55','20:38','22:45'),
		('2015-06-21','2:26','4:57','12:49','16:55','20:38','22:45'),
		('2015-06-22','2:27','4:57','12:49','16:55','20:38','22:45'),
		('2015-06-23','2:27','4:57','12:49','16:55','20:38','22:44'),
		('2015-06-24','2:28','4:58','12:49','16:55','20:38','22:44'),
		('2015-06-25','2:28','4:58','12:49','16:55','20:39','22:44'),
		('2015-06-26','2:29','4:59','12:50','16:56','20:39','22:44'),
		('2015-06-27','2:30','4:59','12:50','16:56','20:39','22:44'),
		('2015-06-28','2:31','4:59','12:50','16:56','20:39','22:44'),
		('2015-06-29','2:32','5:00','12:50','16:56','20:38','22:43'),
		('2015-06-30','2:32','5:00','12:50','16:56','20:38','22:43'),
		('2015-07-1','2:33','5:00','12:51','16:56','20:38','22:43'),
		('2015-07-2','2:34','5:01','12:51','16:56','20:38','22:43'),
		('2015-07-3','2:35','5:02','12:51','16:56','20:38','22:42'),
		('2015-07-4','2:36','5:02','12:51','16:56','20:38','22:42'),
		('2015-07-5','2:37','5:03','12:52','16:56','20:37','22:41'),
		('2015-07-6','2:39','5:03','12:52','16:56','20:37','22:40'),
		('2015-07-7','2:40','5:04','12:52','16:56','20:37','22:39'),
		('2015-07-8','2:41','5:05','12:52','16:56','20:36','22:38'),
		('2015-07-9','2:42','5:05','12:52','16:56','20:36','22:37'),
		('2015-07-10','2:44','5:06','12:52','16:57','20:36','22:37'),
		('2015-07-11','2:46','5:07','12:53','16:57','20:36','22:36'),
		('2015-07-12','2:48','5:08','12:53','16:57','20:35','22:34'),
		('2015-07-13','2:50','5:09','12:53','16:57','20:35','22:33'),
		('2015-07-14','2:52','5:10','12:53','16:57','20:34','22:32'),
		('2015-07-15','2:53','5:11','12:53','16:56','20:33','22:30'),
		('2015-07-16','2:55','5:11','12:53','16:56','20:33','22:29'),
		('2015-07-17','2:56','5:12','12:53','16:56','20:32','22:28'),
		('2015-07-18','2:58','5:13','12:53','16:56','20:31','22:27'),
		('2015-07-19','3:00','5:14','12:53','16:56','20:30','22:25'),
		('2015-07-20','3:02','5:15','12:53','16:56','20:29','22:24'),
		('2015-07-21','3:04','5:16','12:54','16:56','20:28','22:22'),
		('2015-07-22','3:06','5:17','12:54','16:56','20:27','22:21'),
		('2015-07-23','3:08','5:18','12:54','16:56','20:26','22:19'),
		('2015-07-24','3:10','5:20','12:54','16:56','20:25','22:18'),
		('2015-07-25','3:11','5:21','12:54','16:55','20:24','22:16'),
		('2015-07-26','3:13','5:22','12:54','16:55','20:23','22:14'),
		('2015-07-27','3:15','5:23','12:54','16:54','20:22','22:12'),
		('2015-07-28','3:17','5:23','12:54','16:54','20:21','22:11'),
		('2015-07-29','3:19','5:24','12:54','16:53','20:20','22:09'),
		('2015-07-30','3:21','5:25','12:54','16:53','20:19','22:07'),
		('2015-07-31','3:23','5:26','12:54','16:52','20:17','22:05'),
		('2015-08-1','3:25','5:27','12:53','16:51','20:16','22:03'),
		('2015-08-2','3:26','5:29','12:53','16:50','20:15','22:01'),
		('2015-08-3','3:28','5:30','12:53','16:50','20:14','21:59'),
		('2015-08-4','3:30','5:31','12:53','16:50','20:13','21:57'),
		('2015-08-5','3:33','5:32','12:53','16:50','20:12','21:55'),
		('2015-08-6','3:35','5:33','12:53','16:49','20:11','21:54'),
		('2015-08-7','3:37','5:34','12:53','16:49','20:09','21:52'),
		('2015-08-8','3:38','5:35','12:53','16:48','20:08','21:50'),
		('2015-08-9','3:40','5:37','12:53','16:48','20:07','21:48'),
		('2015-08-10','3:42','5:38','12:53','16:47','20:05','21:46'),
		('2015-08-11','3:45','5:39','12:52','16:46','20:04','21:44'),
		('2015-08-12','3:47','5:40','12:52','16:45','20:02','21:42'),
		('2015-08-13','3:48','5:41','12:52','16:44','20:00','21:40'),
		('2015-08-14','3:49','5:43','12:52','16:43','19:59','21:38'),
		('2015-08-15','3:52','5:44','12:52','16:43','19:58','21:36'),
		('2015-08-16','3:54','5:45','12:52','16:43','19:56','21:34'),
		('2015-08-17','3:55','5:46','12:51','16:42','19:54','21:32'),
		('2015-08-18','3:56','5:47','12:51','16:41','19:53','21:30'),
		('2015-08-19','3:58','5:48','12:51','16:41','19:51','21:27'),
		('2015-08-20','4:00','5:49','12:51','16:40','19:49','21:25'),
		('2015-08-21','4:02','5:50','12:50','16:39','19:48','21:23'),
		('2015-08-22','4:03','5:51','12:50','16:38','19:46','21:21'),
		('2015-08-23','4:05','5:52','12:50','16:37','19:45','21:19'),
		('2015-08-24','4:07','5:53','12:50','16:37','19:43','21:17'),
		('2015-08-25','4:09','5:55','12:49','16:36','19:42','21:15'),
		('2015-08-26','4:10','5:56','12:49','16:35','19:40','21:12'),
		('2015-08-27','4:12','5:57','12:49','16:34','19:39','21:10'),
		('2015-08-28','4:14','5:58','12:49','16:33','19:37','21:08'),
		('2015-08-29','4:16','5:59','12:48','16:32','19:35','21:06'),
		('2015-08-30','4:17','6:00','12:48','16:30','19:33','21:04'),
		('2015-08-31','4:19','6:01','12:48','16:29','19:31','21:02'),
		('2015-09-1','4:20','6:02','12:47','16:28','19:29','20:59'),
		('2015-09-2','4:22','6:03','12:47','16:27','19:28','20:58'),
		('2015-09-3','4:23','6:04','12:47','16:26','19:26','20:56'),
		('2015-09-4','4:25','6:05','12:46','16:25','19:24','20:54'),
		('2015-09-5','4:26','6:07','12:46','16:24','19:22','20:51'),
		('2015-09-6','4:28','6:08','12:46','16:23','19:20','20:49'),
		('2015-09-7','4:29','6:09','12:45','16:22','19:18','20:47'),
		('2015-09-8','4:31','6:10','12:45','16:21','19:17','20:45'),
		('2015-09-9','4:33','6:11','12:45','16:20','19:15','20:43'),
		('2015-09-10','4:34','6:13','12:44','16:19','19:13','20:41'),
		('2015-09-11','4:35','6:14','12:44','16:17','19:11','20:39'),
		('2015-09-12','4:37','6:15','12:44','16:16','19:09','20:37'),
		('2015-09-13','4:38','6:16','12:43','16:14','19:08','20:35'),
		('2015-09-14','4:40','6:17','12:43','16:13','19:06','20:33'),
		('2015-09-15','4:41','6:19','12:43','16:12','19:04','20:31'),
		('2015-09-16','4:43','6:20','12:42','16:11','19:02','20:29'),
		('2015-09-17','4:44','6:21','12:42','16:10','19:00','20:26'),
		('2015-09-18','4:46','6:22','12:42','16:09','18:58','20:24'),
		('2015-09-19','4:47','6:23','12:41','16:08','18:57','20:22'),
		('2015-09-20','4:48','6:24','12:41','16:07','18:55','20:20'),
		('2015-09-21','4:49','6:25','12:40','16:05','18:53','20:18'),
		('2015-09-22','4:51','6:26','12:40','16:03','18:51','20:16'),
		('2015-09-23','4:52','6:27','12:40','16:02','18:49','20:14'),
		('2015-09-24','4:54','6:28','12:39','16:01','18:47','20:12'),
		('2015-09-25','4:55','6:30','12:39','16:00','18:45','20:10'),
		('2015-09-26','4:56','6:31','12:39','15:59','18:43','20:08'),
		('2015-09-27','4:57','6:32','12:38','15:57','18:41','20:06'),
		('2015-09-28','4:59','6:33','12:38','15:56','18:40','20:05'),
		('2015-09-29','5:00','6:35','12:38','15:55','18:38','20:03'),
		('2015-09-30','5:01','6:36','12:37','15:54','18:37','20:01'),
		('2015-10-1','5:02','6:37','12:37','15:53','18:35','19:59'),
		('2015-10-2','5:03','6:38','12:37','15:51','18:33','19:57'),
		('2015-10-3','5:04','6:40','12:36','15:49','18:31','19:55'),
		('2015-10-4','5:06','6:41','12:36','15:48','18:29','19:53'),
		('2015-10-5','5:07','6:42','12:36','15:47','18:27','19:51'),
		('2015-10-6','5:08','6:43','12:36','15:45','18:25','19:49'),
		('2015-10-7','5:09','6:44','12:35','15:43','18:24','19:47'),
		('2015-10-8','5:11','6:45','12:35','15:42','18:22','19:45'),
		('2015-10-9','5:13','6:46','12:35','15:41','18:20','19:44'),
		('2015-10-10','5:14','6:47','12:34','15:40','18:18','19:42'),
		('2015-10-11','5:15','6:49','12:34','15:38','18:16','19:40'),
		('2015-10-12','5:16','6:50','12:34','15:37','18:15','19:39'),
		('2015-10-13','5:17','6:51','12:34','15:36','18:13','19:38'),
		('2015-10-14','5:18','6:53','12:33','15:35','18:11','19:36'),
		('2015-10-15','5:19','6:54','12:33','15:33','18:09','19:34'),
		('2015-10-16','5:21','6:55','12:33','15:32','18:08','19:33'),
		('2015-10-17','5:22','6:57','12:33','15:31','18:07','19:32'),
		('2015-10-18','5:23','6:58','12:33','15:30','18:05','19:30'),
		('2015-10-19','5:24','6:59','12:32','15:28','18:03','19:28'),
		('2015-10-20','5:26','7:00','12:32','15:27','18:02','19:27'),
		('2015-10-21','5:27','7:02','12:32','15:26','18:00','19:25'),
		('2015-10-22','5:28','7:03','12:32','15:25','17:58','19:23'),
		('2015-10-23','5:29','7:05','12:32','15:23','17:57','19:22'),
		('2015-10-24','5:30','7:06','12:32','15:22','17:55','19:20'),
		('2015-10-25','4:31','6:07','11:31','14:21','16:54','18:19'),
		('2015-10-26','4:32','6:08','11:31','14:20','16:52','18:17'),
		('2015-10-27','4:33','6:09','11:31','14:18','16:51','18:16'),
		('2015-10-28','4:35','6:10','11:31','14:17','16:49','18:15'),
		('2015-10-29','4:36','6:12','11:31','14:16','16:48','18:14'),
		('2015-10-30','4:37','6:13','11:31','14:15','16:46','18:12'),
		('2015-10-31','4:38','6:14','11:31','14:14','16:45','18:11'),
		('2015-11-1','4:39','6:15','11:31','14:13','16:43','18:10'),
		('2015-11-2','4:40','6:17','11:31','14:11','16:42','18:09'),
		('2015-11-3','4:42','6:18','11:31','14:10','16:41','18:08'),
		('2015-11-4','4:43','6:20','11:31','14:09','16:40','18:07'),
		('2015-11-5','4:44','6:21','11:31','14:08','16:39','18:06'),
		('2015-11-6','4:45','6:22','11:31','14:07','16:37','18:04'),
		('2015-11-7','4:46','6:24','11:31','14:06','16:36','18:03'),
		('2015-11-8','4:47','6:25','11:31','14:05','16:35','18:02'),
		('2015-11-9','4:48','6:27','11:31','14:04','16:34','18:01'),
		('2015-11-10','4:49','6:28','11:31','14:03','16:32','18:00'),
		('2015-11-11','4:51','6:29','11:31','14:02','16:31','17:59'),
		('2015-11-12','4:52','6:31','11:31','14:01','16:30','17:58'),
		('2015-11-13','4:54','6:32','11:32','14:01','16:29','17:57'),
		('2015-11-14','4:55','6:33','11:32','14:01','16:28','17:56'),
		('2015-11-15','4:56','6:34','11:32','14:00','16:27','17:55'),
		('2015-11-16','4:56','6:35','11:32','13:59','16:26','17:54'),
		('2015-11-17','4:57','6:37','11:32','13:58','16:25','17:53'),
		('2015-11-18','4:58','6:38','11:32','13:57','16:24','17:52'),
		('2015-11-19','4:59','6:39','11:33','13:57','16:23','17:52'),
		('2015-11-20','5:00','6:41','11:33','13:56','16:22','17:51'),
		('2015-11-21','5:01','6:42','11:33','13:55','16:21','17:50'),
		('2015-11-22','5:03','6:43','11:33','13:54','16:21','17:50'),
		('2015-11-23','5:04','6:45','11:34','13:54','16:20','17:50'),
		('2015-11-24','5:05','6:46','11:34','13:54','16:19','17:49'),
		('2015-11-25','5:07','6:47','11:34','13:53','16:19','17:49'),
		('2015-11-26','5:08','6:48','11:35','13:53','16:19','17:49'),
		('2015-11-27','5:09','6:50','11:35','13:53','16:18','17:48'),
		('2015-11-28','5:09','6:51','11:35','13:52','16:18','17:48'),
		('2015-11-29','5:10','6:52','11:36','13:52','16:17','17:48'),
		('2015-11-30','5:11','6:53','11:36','13:51','16:17','17:48'),
		('2015-12-1','5:12','6:54','11:36','13:51','16:16','17:47'),
		('2015-12-2','5:12','6:56','11:36','13:50','16:16','17:47'),
		('2015-12-3','5:13','6:57','11:37','13:50','16:16','17:47'),
		('2015-12-4','5:14','6:58','11:37','13:50','16:16','17:47'),
		('2015-12-5','5:15','6:59','11:38','13:50','16:15','17:46'),
		('2015-12-6','5:16','7:00','11:38','13:50','16:15','17:46'),
		('2015-12-7','5:17','7:01','11:39','13:50','16:15','17:46'),
		('2015-12-8','5:18','7:02','11:39','13:50','16:15','17:46'),
		('2015-12-9','5:19','7:03','11:40','13:50','16:14','17:46'),
		('2015-12-10','5:19','7:04','11:40','13:50','16:14','17:46'),
		('2015-12-11','5:20','7:05','11:40','13:51','16:14','17:46'),
		('2015-12-12','5:21','7:06','11:41','13:51','16:14','17:46'),
		('2015-12-13','5:22','7:07','11:41','13:51','16:15','17:47'),
		('2015-12-14','5:23','7:08','11:42','13:52','16:15','17:47'),
		('2015-12-15','5:24','7:08','11:42','13:52','16:15','17:48'),
		('2015-12-16','5:24','7:09','11:43','13:52','16:15','17:48'),
		('2015-12-17','5:25','7:09','11:43','13:53','16:16','17:49'),
		('2015-12-18','5:26','7:10','11:44','13:54','16:16','17:49'),
		('2015-12-19','5:27','7:10','11:44','13:54','16:16','17:50'),
		('2015-12-20','5:27','7:10','11:45','13:54','16:16','17:50'),
		('2015-12-21','5:28','7:11','11:45','13:55','16:17','17:51'),
		('2015-12-22','5:28','7:12','11:46','13:55','16:18','17:52'),
		('2015-12-23','5:29','7:12','11:47','13:56','16:18','17:52'),
		('2015-12-24','5:29','7:12','11:47','13:56','16:19','17:53'),
		('2015-12-25','5:30','7:13','11:48','13:57','16:19','17:53'),
		('2015-12-26','5:30','7:13','11:48','13:57','16:20','17:53'),
		('2015-12-27','5:30','7:14','11:48','13:58','16:20','17:53'),
		('2015-12-28','5:30','7:14','11:48','13:58','16:21','17:54'),
		('2015-12-29','5:31','7:14','11:49','13:59','16:22','17:55'),
		('2015-12-30','5:31','7:14','11:50','14:00','16:23','17:56'),
		('2015-12-31','5:31','7:14','11:50','14:01','16:24','17:57')");
	}
	
	public static function vaktija_plugin_delete_data() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'vaktija';
		$wpdb->query("DROP TABLE $table_name");
	}
}

add_action('widgets_init', create_function('', 'return register_widget("vaktija_widget");'));
register_activation_hook( __FILE__, array('vaktija_widget', 'vaktija_create_plugin_database_table'));
register_activation_hook( __FILE__, array('vaktija_widget', 'vaktija_plugin_install_data'));
register_deactivation_hook(__FILE__, array('vaktija_widget', 'vaktija_plugin_delete_data'));
?>