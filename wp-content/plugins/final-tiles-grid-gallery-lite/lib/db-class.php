<?php

if(! class_exists('FinalTilesDB'))
{
	class FinalTilesDB {
		
		private static $pInstance;
		
		private function __construct() {}
		
		public static function getInstance() 
		{
			if(!self::$pInstance) {
				self::$pInstance = new FinalTilesDB();
			}
			
			return self::$pInstance;
		}
		
		public function query() 
		{
			return "Test";	
		}
		

		public function update_config($id, $data)
		{
			global $wpdb;
			$tb_g = $wpdb->prefix . "FinalTiles_gallery";
			$wpdb->update($tb_g, array('configuration' => $data), array('Id' => $id));
		}

		public static function updateConfiguration()
		{
			global $wpdb;
			$tb_g = $wpdb->prefix . "FinalTiles_gallery";

			$galleries = $wpdb->get_results("SELECT * FROM $tb_g");
			foreach($galleries as $gallery)
			{
				if($gallery->configuration == NULL)
				{
					unset($gallery->configuration);
					$configuration = json_encode($gallery);				
					$wpdb->update($tb_g, 
									array('configuration' => $configuration),
									array('Id' => $gallery->Id));
				}
			}
		}
		

		public function addGallery($data) 
		{
			global $wpdb;		  
			$tb_g = $wpdb->prefix . "FinalTiles_gallery";

			$configuration = json_encode($data);
			$data = array('configuration' => $configuration);
			$galleryAdded =  $wpdb->insert( $tb_g, $data);
			return $galleryAdded;
		}
		
		public function getNewGalleryId() 
		{
			global $wpdb;
			return $wpdb->insert_id;
		}
		
		public function deleteGallery($gid) 
		{
			global $wpdb;
			$tb_g = $wpdb->prefix . "FinalTiles_gallery";
			$tb_i = $wpdb->prefix . "FinalTiles_gallery_images";
			$wpdb->query($wpdb->prepare("DELETE FROM $tb_i WHERE gid = %d", $gid));
			$wpdb->query($wpdb->prepare("DELETE FROM $tb_g WHERE Id = %d", $gid));
		}
		
		public function editGallery($gid, $data) 
		{
			global $wpdb;
			$configuration = json_encode($data);
			$tb_g = $wpdb->prefix . "FinalTiles_gallery";
			$tb_i = $wpdb->prefix . "FinalTiles_gallery_images";

			$g = $wpdb->update($tb_g, 
							array('configuration' => $configuration),
							array('Id' => $gid));
							
			//exit( var_dump( $wpdb->last_query ) );
			return $g;
		}
		
		public function getGalleryConfig($id)
		{
			global $wpdb;
			$tb_g = $wpdb->prefix . "FinalTiles_gallery";
			$tb_i = $wpdb->prefix . "FinalTiles_gallery_images";
			$gallery = $wpdb->get_row($wpdb->prepare("SELECT * FROM $tb_g WHERE Id = %d", $id));

			return $gallery->configuration;
		}
		public function getGalleryById($id, $array=false) 
		{
			global $wpdb;
			$tb_g = $wpdb->prefix . "FinalTiles_gallery";
			$tb_i = $wpdb->prefix . "FinalTiles_gallery_images";
			$gallery = $wpdb->get_row($wpdb->prepare("SELECT * FROM $tb_g WHERE Id = %d", $id));

			if($array)
			{
				return get_object_vars(json_decode($gallery->configuration));
			}
			if($gallery == null)
				return null;
				
			$data = json_decode($gallery->configuration);
			if($data->captionBehavior == "hidden")
				$data->captionEffect = "none";
			if($data->captionBehavior == "visible")
				$data->captionEffect = "fixed";
			if($data->captionBehavior == "always-visible")
				$data->captionEffect = "fixed-bg";
			if(isset($data->loadedRotate))
				$data->loadedRotateY = $data->loadedRotate;
			if(isset($data->loadedScale)) {
				$data->loadedScaleY = $data->loadedScale;
				$data->loadedScaleX = $data->loadedScale;
			}


			if(isset($data->captionVerticalAlignment))
				$data->captionVerticalAlignment = strtolower($data->captionVerticalAlignment);

			if(isset($data->captionHorizontalAlignment))
				$data->captionHorizontalAlignment = strtolower($data->captionHorizontalAlignment);

			return $data;
		}
		
		public function getGalleries() 
		{
			global $wpdb;
			$tb_g = $wpdb->prefix . "FinalTiles_gallery";
			$tb_i = $wpdb->prefix . "FinalTiles_gallery_images";

			$query = "SELECT Id, configuration FROM $tb_g order by id";
			$galleryResults = $wpdb->get_results( $query );
			
			$result = array();
			foreach($galleryResults as $gallery)
			{
				$data = json_decode($gallery->configuration);
				$data->Id = $gallery->Id;
				$result[] = $data;
			}
			return $result;
		}
		
		public function addVideo($data) 
		{
			global $wpdb;		
			$tb_g = $wpdb->prefix . "FinalTiles_gallery";
			$tb_i = $wpdb->prefix . "FinalTiles_gallery_images";

			$videoAdded = $wpdb->insert( $tb_i,
			        array( 'gid' => $data['gid'], 'imagePath' => $data['imagePath'], 'type' => 'video', 'sortOrder' => 0, 'imageId' => rand(100000, 1000000) ));
			$id = $wpdb->insert_id;
	        $wpdb->update($tb_i, array('sortOrder' => $id), array('id' => $id));
			return $videoAdded;
		}
		
		public function editVideo($id, $data)
		{
			global $wpdb;
			$tb_i = $wpdb->prefix . "FinalTiles_gallery_images";
			$result = $wpdb->update( $tb_i, $data, array( 'Id' => $id ) );
			return $result;
		}

		public function addImages($gid, $images) 
		{		
			global $wpdb;		
			$tb_i = $wpdb->prefix . "FinalTiles_gallery_images";

			foreach ($images as $image) {
				if(! isset($image->group))
					$image->group = "";

				$data = array( 'gid' => $gid,
				               'imagePath' => esc_url_raw($image->imagePath),
				               'description' => isset($image->description) ? sanitize_text_field($image->description) : "",
				               'imageId' => absint($image->imageId),
											 'group' => sanitize_text_field($image->group),
											 'link' => esc_url_raw($image->link),
											 'alt' => sanitize_text_field($image->alt),
											 'target' => sanitize_text_field($image->target),
				               'title' => isset($image->title) ? sanitize_text_field($image->title ): "", 'sortOrder' => 0 );

				if(isset($image->filters))
					$data['filters'] = sanitize_text_field($image->filters);

				$data['type'] = isset($image->type) ? sanitize_text_field($image->type): 'image';

				$imageAdded = $wpdb->insert( $tb_i, $data );
				$id = $wpdb->insert_id;
				$wpdb->update($tb_i, array('sortOrder' => $id), array('id' => $id));
			}
			
			return true;
		}
		
		public function addFullImage($data) {
			global $wpdb;		
			$tb_i = $wpdb->prefix . "FinalTiles_gallery_images";
			$imageAdded = $wpdb->insert( $tb_i, $data );
			return $imageAdded;
		}
		
		public function deleteImage($id) {
			global $wpdb;
			$tb_i = $wpdb->prefix . "FinalTiles_gallery_images";
			$query = "DELETE FROM $tb_i WHERE Id = '$id'";
			if($wpdb->query($wpdb->prepare("DELETE FROM $tb_i WHERE Id = %d", $id)) === FALSE) {
				return false;
			}
			else {
				return true;
			}
		}
		
		public function editImage($id, $data) 
		{
			global $wpdb;
			$tb_i = $wpdb->prefix . "FinalTiles_gallery_images";
			$imageEdited = $wpdb->update( $tb_i, $data, array( 'Id' => $id ) );
			return $imageEdited;
		}

		public function getImage($id)
		{
			global $wpdb;
			$tb_i = $wpdb->prefix . "FinalTiles_gallery_images";
			return $wpdb->get_row($wpdb->prepare("SELECT * FROM $tb_i WHERE id = %d", $id));
		}

		public function sortImages($ids) 
		{
			global $wpdb;
			$tb_i = $wpdb->prefix . "FinalTiles_gallery_images";
			$index = 1;
			foreach($ids as $id) 
			{
				$data = array('sortOrder' => $index++);
				$wpdb->update( $tb_i, $data, array( 'Id' => $id ) );
			}
			return true;
		}
		
		public function getImagesByGalleryId($gid, $skip=0, $size=0) 
		{
			global $wpdb;
			$tb_i = $wpdb->prefix . "FinalTiles_gallery_images";

			$q = $wpdb->prepare("SELECT * FROM $tb_i WHERE gid = %d ORDER BY sortOrder ASC", $gid);
			if($size > 0)
				$q = $wpdb->prepare("SELECT * FROM $tb_i WHERE gid = %d ORDER BY sortOrder ASC LIMIT %d, %d", $gid, $skip, $size);

			$imageResults = $wpdb->get_results($q);

			foreach($imageResults as &$image)
			{
				$image->source = "gallery";
				if(! isset($image->group))
					$image->group = null;
				if(! isset($image->hidden))
					$image->hidden = 'F';
			}
			
			return $imageResults;
		}
		
		public function getGalleryByGalleryId($gid) {
			global $wpdb;
			$tb_g = $wpdb->prefix . "FinalTiles_gallery";
			$gallery = $wpdb->get_results("SELECT $tb_g.*, $tb_i.* FROM $wpdb->FinalTiles_gallery INNER JOIN $tb_i ON ($wpdb->FinalTiles_gallery.Id = $tb_i.gid) WHERE $wpdb->FinalTiles_gallery.Id = '$gid' ORDER BY sortOrder ASC");		
			return $gallery;
		}
	}
}
?>